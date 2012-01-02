<?php defined('C5_EXECUTE') or die('Access Denied');
class NewContentHelper {
	
	public function loadFiles($c, $u) {
		$view = View::getInstance();
		$html = Loader::helper('html');
		$view->addHeaderItem($html->javascript('jquery.cookie.js'));
		$view->addHeaderItem($html->javascript('new_content.js', 'new_content'));
		$view->addHeaderItem($html->css('new_content.css', 'new_content'));
	}
}