<?php defined('C5_EXECUTE') or die('Access Denied');

class NewContentPackage extends Package
{
	protected $pkgHandle = 'new_content';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '0.9.0';
	
	public function getPackageDescription() {
		return t('Show a alert to recurring visitors with new or changed content since their last visit.');
	}
	
	public function getPackageName() {
		return t('New Content Alert');
	}
	
	public function on_start() {
		Events::extend('on_page_view', 'NewContentHelper', 'loadFiles', 'packages/' . $this->pkgHandle . '/helpers/new_content.php');
	}
	
	public function install() {
		$pkg = parent::install();
	
		Loader::model('single_page');
	
	
		$p = SinglePage::add('/new_content', $pkg);
		if (is_object($p)) {
			$p->update(array('cName'=>t('New Content'), 'cDescription'=>t('New Content Alert')));
		}
	}
}
