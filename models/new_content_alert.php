<?php
class NewContentAlertModel implements Countable, IteratorAggregate
{
	private $time_stamp;
	private $pages;
	
	public function __construct($time_stamp) {
		$this->time_stamp = $time_stamp;
	}
	
	public function count()
	{
		$cnt = 0;
		if (!$this->pages) {
			$this->pages = $this->getAllPages();
		}
		foreach ($this->pages as $set) {
			$cnt += count($set['pages']);
		}
		return $cnt;
	}
	
	public function getIterator()
	{
		if (!$this->pages) {
			$this->pages = $this->getAllPages();
		}
		return new ArrayIterator($this->pages);
	}
	
	private function getAllPages()
	{
		$db = Loader::db();
		$res = $db->query(
				"SELECT 
					cvb.cID,
					pl.bID,
					pl.num,
					pl.cParentID,
					pl.cThis,
					pl.orderBy,
					pl.ctID,
					pl.displayAliases,
					pl.rssTitle,
					pl.rssDescription,
					pl.truncateSummaries,
					pl.displayFeaturedOnly,
					pl.includeAllDescendents
				FROM
					btPageList AS pl
				INNER JOIN
					Blocks AS b
				ON
					pl.bID = b.bID
				INNER JOIN
					CollectionVersionBlocks AS cvb
				ON
					b.bID = cvb.bID
				WHERE
					pl.rss = 1
				AND
					b.bIsActive = 1"
		);
	
		$pages = array();
		foreach($res as $row) {
			$pages[] = array(
					'title' => $row['rssTitle'],
					'description' => $row['rssDescription'],
					'pages' => $this->getPages($row, $db)
			);
		}
	
		return $pages;
	}
	
	public function getPages($row, $db)
	{
		Loader::model('page_list');
		$pl = new PageList();
		$pl->setNameSpace('b' . $row['bID']);
			
		$cArray = array();
	
		switch($row['orderBy']) {
			case 'display_asc':
				$pl->sortByDisplayOrder();
				break;
			case 'display_desc':
				$pl->sortByDisplayOrderDescending();
				break;
			case 'chrono_asc':
				$pl->sortByPublicDate();
				break;
			case 'alpha_asc':
				$pl->sortByName();
				break;
			case 'alpha_desc':
				$pl->sortByNameDescending();
				break;
			default:
				$pl->sortByPublicDateDescending();
		}
	
		Loader::model('attribute/categories/collection');
		if ($row['displayFeaturedOnly'] == 1) {
			$cak = CollectionAttributeKey::getByHandle('is_featured');
			if (is_object($cak)) {
				$pl->filterByIsFeatured(1);
			}
		}
		if (!$row['displayAliases']) {
			$pl->filterByIsAlias(0);
		}
		$pl->filter('cvName', '', '!=');
	
		$pl->filter('UNIX_TIMESTAMP(cvDateCreated)', $this->time_stamp, '>');
	
		if ($row['ctID']) {
			$pl->filterByCollectionTypeID($row['ctID']);
		}
	
		$columns = $db->MetaColumns(CollectionAttributeKey::getIndexedSearchTable());
		if (isset($columns['AK_EXCLUDE_PAGE_LIST'])) {
			$pl->filter(false, '(ak_exclude_page_list = 0 or ak_exclude_page_list is null)');
		}
			
		if ( intval($row['cParentID']) != 0) {
			$cParentID = ($row['cThis']) ? $row['cID'] : $row['cParentID'];
			if ($row['includeAllDescendents']) {
				$pl->filterByPath(Page::getByID($cParentID)->getCollectionPath());
			} else {
				$pl->filterByParentID($cParentID);
			}
		}
	
		$num = (int) $row['num'];
			
		if ($num > 0) {
			$pl->setItemsPerPage($num);
			$pages = $pl->getPage();
		} else {
			$pages = $pl->get();
		}
		return $pages;
	}
}