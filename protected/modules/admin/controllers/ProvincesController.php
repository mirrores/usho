<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProvincesController extends AdminController{
  function actionIndex(){
        $keyword=  Yii::app()->request->getParam('keyword');
        $criteria=new CDbCriteria();
        if($keyword){
            $_GET['keyword']=$keyword;
            $criteria->condition='(name like :keyword or pinyin like :keyword)';
            $criteria->params=array(':keyword'=>'%'.trim($keyword).'%');
        }
        $count= Provinces::model()->count($criteria);
        $pages=new CPagination($count);
        $pages->pageSize=15;
        $pages->applyLimit($criteria);
        $records= Provinces::model()->findAll($criteria);
        $this->render('index',array('records'=>$records,'pages'=>$pages,'keyword'=>$keyword));
         }
        public function  actionView($id){
            $this->render('view',array('model'=>  $this->loadModel($id)));
        }
        
     function actionCreate(){
        $model=new Provinces;
        if(isset($_POST['Provinces'])){
            $model->attributes=$_POST['Provinces'];
            $model->created_at=date('Y-m-d H:i:s');
            if($model->save())
                $this->redirect (array('index','id'=>$model->id));
        }
        $this->render('form',array('model'=>$model));
    }
    
    function actionUpdate($id){
        $model=  $this->loadModel($id);
        if(isset($_POST['Provinces'])){
            $model->attributes=$_POST['Provinces'];
            $model->updated_at=date('Y-m-d H:i:s');
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
        $model=Provinces::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
         
        }
        return $model;
    }
    protected function performAjaxValidation($model){
         if(isset($_POST['ajax'])&&$_POST['ajax']==='provinces-form'){
             echo CActiveForm::validate($model);
             Yii::app()->end();
         }
    }
}