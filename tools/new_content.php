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
$count = count($model);
echo $jsonh->encode(array(
	'count' => $count,
	'message' => $count ?
		t('There has been placed %d new content items since your last visit.', $count) :
		t('There has been placed no new content since your last visit.')
));
