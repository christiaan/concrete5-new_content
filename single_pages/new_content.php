<?php defined('C5_EXECUTE') or die('Access Denied');
/* @var $nh NavigationHelper */
$nh = Loader::helper('navigation');
/* @var $th TextHelper */
$th = Loader::helper('text');
?>
<?php if (count($model)):
	foreach ($model as $section):?>
<h2><?php echo $section['title']?></h2>
<p><?php echo $section['description']?></p>
<div class="ccm-page-list">
<?php /* @var $page Page */
	foreach ($section['pages'] as $page):
	$title = $th->entities($page->getCollectionName());
	$url = $nh->getLinkToCollection($page);
	$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
	$target = empty($target) ? '_self' : $target;
	$description = $page->getCollectionDescription();
	$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
	$description = $th->entities($description);	
?>
	<h3 class="ccm-page-list-title">
		<a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo $title ?></a>
	</h3>
	<div class="ccm-page-list-description">
		<?php echo $description ?>
	</div>
<?php endforeach?>
</div>
<?php endforeach; 
	else:?>
<h2><?php echo t('No new Content')?></h2>
<p><?php echo t('Since your last visit there hasn\'t been placed any new content on this website.')?></p>
<?php endif;?>
