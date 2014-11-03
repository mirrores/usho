<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GenreController extends AdminController{
    function actionIndex(){
        $keyword=  Yii::app()->request->getParam('keyword');
        $criteria=new CDbCriteria();
        if($keyword){
            $criteria->condition='(genre_name like :keyword )';
            $criteria->params=array(':keyword'=>'%'.trim($keyword).'%');
        }
        $count= Genre::model()->count($criteria);
        $pages=new CPagination($count);
        $pages->pageSize=15;
        $pages->applyLimit($criteria);
        $records= Genre::model()->findAll($criteria);
        $this->render('index',array('records'=>$records,'pages'=>$pages));
         }
        public function  actionView($id){
            $this->render('view',array('model'=>  $this->loadModel($id)));
        }
        
     function actionCreate(){
        $model=new Genre;
        if(isset($_POST['Genre'])){
            $model->attributes=$_POST['Genre'];
            if($model->save())
                $this->redirect (array('index','id'=>$model->genre_id));
        }
        $this->render('form',array('model'=>$model));
    }
    
    function actionUpdate($id){
        $model=  $this->loadModel($id);
        if(isset($_POST['Genre'])){
            $model->attributes=$_POST['Genre'];
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
        $model=Genre::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
         
        }
        return $model;
    }
    protected function performAjaxValidation($model){
         if(isset($_POST['ajax'])&&$_POST['ajax']==='genre-form'){
             echo CActiveForm::validate($model);
             Yii::app()->end();
         }
    }
}