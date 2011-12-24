<?php
class NewContentAlertController extends Controller
{
	public function view()
	{
		$time_stamp = 1324744001;
		$this->set('time_stamp', $time_stamp);
		
		Loader::model('new_content_alert', 'new_content_alert');
		$model = new NewContentAlertModel($time_stamp);
		$this->set('model', $model);
	}
}