<?php

/* 
 * 后台管理员登陆
 * 作者：徐斌
 * 时间：14/2/26 上午
 */
class  ManagerController extends Controller{
    
    function actionLogin(){
        $login_model=new LoginForm();
        if(isset($_POST['LoginForm'])){
            $login_model->attributes=$_POST['LoginForm'];
            
            if($login_model->validate() && $login_model->login()){
                $this->redirect('./index.php?r=admin/index/index');
            }
        }
       $this->renderPartial('login',array('login_model'=>$login_model));
    }
    function actionLogout(){
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect('./index.php?r=admin/manager/login');
    }
}
