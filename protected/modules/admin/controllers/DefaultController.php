<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		//$this->render('index');
        $this->redirect('http://www.usho.cn/admin/index');
	}
}