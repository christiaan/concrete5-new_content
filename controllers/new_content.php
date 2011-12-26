<?php defined('C5_EXECUTE') or die('Access Denied');
class NewContentController extends Controller
{
	public function view($time_stamp = null)
	{
		if (!$time_stamp) {
			header('x', true, 404);
			$this->render('/page_not_found');
			return;
		}
		
		$time_stamp = (int) $time_stamp;
		$this->set('time_stamp', $time_stamp);
		
		Loader::model('new_content', 'new_content');
		$model = new NewContentModel($time_stamp);
		$this->set('model', $model);
	}
}