<?php defined('C5_EXECUTE') or die('Access Denied');

class NewContentPackage extends Package
{
	protected $pkgHandle = 'new_content';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.0.0';
	
	public function getPackageDescription() {
		return t('Show a alert to recurring visitors with new or changed content since their last visit.');
	}
	
	public function getPackageName() {
		return t('New Content Alert');
	}
	
	public function on_start() {
		// TODO require the javascript file
	}
	
	
	
	public function install() {
		$pkg = parent::install();
	
		Loader::model('single_page');
	
	
		$p = SinglePage::add('/new_content', $pkg);
		if (is_object($p)) {
			$p->update(array('cName'=>t('New Content'), 'cDescription'=>t('New Content Alert')));
		}
	
// 		$p1 = SinglePage::add('/dashboard/multilingual/setup', $pkg);
// 		if (is_object($p1)) {
// 			$p1->update(array('cName'=>t('Setup'), 'cDescription'=>''));
// 		}
// 		$p2 = SinglePage::add('/dashboard/multilingual/page_report', $pkg);
// 		if (is_object($p2)) {
// 			$p2->update(array('cName'=>t('Page Report'), 'cDescription'=>''));
// 		}
// 		BlockType::installBlockTypeFromPackage('switch_language', $pkg);
	}
}
