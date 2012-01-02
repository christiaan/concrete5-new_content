<?php defined('C5_EXECUTE') or die('Access Denied');
/* @var $nav NavigationHelper */
$nav = Loader::helper('navigation');
?>
<?php if (count($model)):
	foreach ($model as $section):?>
<h2><?php echo $section['title']?></h2>
<p><?php echo $section['description']?></p>
<ul>
<?php /* @var $page Page */
	foreach ($section['pages'] as $page):?>
<li><a href="<?php echo $nav->getCollectionURL($page)?>"><?php echo $page->getCollectionDescription()?></a></li>
<?php endforeach?>
</ul>
<?php endforeach;
	else:?>
<h2>No new Content</h2>
<p>Since your last visit there hasn't been placed any new content on this website.</p>
<?php endif;?>
