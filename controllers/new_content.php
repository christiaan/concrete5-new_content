<?php
class NewContentController extends Controller
{
	public function view()
	{
		$time_stamp = 1324744001;
		$this->set('time_stamp', $time_stamp);
		
		Loader::model('new_content', 'new_content');
		$model = new NewContentModel($time_stamp);
		$this->set('model', $model);
	}
}