<?php

/* 
 * 分类控制
 * 作者：徐斌
 * 时间：14/3/5
 */
class CategoryController extends AdminController{
    function actionIndex(){
        $keyword=  Yii::app()->request->getParam('keyword');
        $criteria=new CDbCriteria();
        if($keyword){
            $criteria->condition='(name like :keyword or categor_intro like :keyword)';
            $criteria->params=array(':keyword'=>'%'.trim($keyword).'%');
        }
        $count= Category::model()->count($criteria);
        $pages=new CPagination($count);
        $pages->pageSize=15;
        $pages->applyLimit($criteria);
        $records= Category::model()->findAll($criteria);
        $this->render('index',array('records'=>$records,'pages'=>$pages));
         }
        public function  actionView($id){
            $this->render('view',array('model'=>  $this->loadModel($id)));
        }
        
     function actionCreate(){
        $model=new Category;
        if(isset($_POST['Category'])){
            $model->attributes=$_POST['Category'];
            if($model->save())
                $this->redirect (array('index','id'=>$model->category_id));
        }
        $this->render('form',array('model'=>$model));
    }
    
    function actionUpdate($id){
        $model=  $this->loadModel($id);
        if(isset($_POST['Category'])){
            $model->attributes=$_POST['Category'];
            $model->save();
        }
        $this->render('form',array('model'=>$model));
    }
    function actionDelete($id){
       $this->loadModel($id)->delete();
       if(!isset($_GET['ajax']))
           $this->redirect (array('index'));
    }
    public function loadModel($id){
        $model=Category::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
         
        }
        return $model;
    }
    protected function performAjaxValidation($model){
         if(isset($_POST['ajax'])&&$_POST['ajax']==='category-form'){
             echo CActiveForm::validate($model);
             Yii::app()->end();
         }
    }
}
