<?php

//学校控制器
class SchoolController extends Controller {

    public function actionIndex() {
        
    }

    //后台输入学校名称自动完成提示
    public function actionAutocomplete() {
        $this->layout = false;
        $q = Yii::app()->request->getParam('searchDbInforItem');
        $record = Yii::app()->db->createCommand()
                ->select('id as value,name as label')
                ->from('school')
                ->where('name like "%' . $q . '%"')
                ->order('id ASC')
                ->limit(30)
                ->queryAll();
        echo json_encode($record);
    }

}
