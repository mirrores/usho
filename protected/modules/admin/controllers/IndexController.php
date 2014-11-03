<?php

/* 
 * 后台整体框架控制器
 */
class IndexController extends AdminController{
    
    //头部
    function actionHead(){
        $this->renderPartial('head');
    }
    
    //左侧
    function actionLeft(){
        $this->renderPartial('left');
    }
    
    //右侧
    function actionRight(){
        $this->renderPartial('right');
    }
    
    
    //集成一起
    function actionIndex(){
       //var_dump(Yii::app()->db); //查看数据库连接
        $this->renderPartial('index');
        
    }
    
}
