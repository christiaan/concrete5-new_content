<?php defined('C5_EXECUTE') or die('Access Denied');
if (empty($_GET['ts'])) {
	header('x', true, 404);
	echo '404 not found';
	exit;
}

Loader::model('new_content', 'new_content');
$model = new NewContentModel((int) $_GET['ts']);
/* @var $jsonh JsonHelper */
$jsonh = Loader::helper('json');
/* @var $nav NavigationHelper */
$nav = Loader::helper('navigation');
/* @var $nav TextHelper */
$text = Loader::helper('text');
$page = Page::getByPath('/new_content');
$count = count($model);
echo $jsonh->encode(array(
	'count' => $count,
	'message' => $count ?
		('<a class="close close-btn" href="#">&times;</a>
        <p>'.t('There has been placed %s new content items since your last visit.', '<strong>'.$count.'</strong>').'</p>
        <div class="alert-actions">
          <a id="new_content_view" class="btn small" href="'.
          	$text->entities(rtrim($nav->getCollectionURL($page), '/')) . '/' . $model->timestamp().
          	'">'.t('View items').'</a> <a id="new_content_opt_out" class="btn small" href="#">'.t('Don\'t notify me again').'</a>
        </div>'      	
      	) :
		('<a class="close close-btn" href="#">&times;</a>
			<p>'.t('There has been placed no new content since your last visit.').'</p>
			<div class="alert-actions">
			    <a class="close" href="#">'.t('Close').'</a> <a id="new_content_opt_out" class="btn small" href="#">'.t("Don't notify me again").'</a>
			</div>'
		)
));
