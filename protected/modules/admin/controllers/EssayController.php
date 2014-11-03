<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EssayController extends CController{
    function actionShow(){
        $essay_model=  Essay::model();
        $cnt=$essay_model->count();
        $per=10;
        $page=new Pagination($cnt,$per);
        $sql="select * from essay $page->limit";
        $essay_info=$essay_model->findAllBySql($sql);
        $page_list=$page->fpage(array(0,1,2,3,4,5,6,7,8));
        $this->renderPartial('show',array('essay_info'=>$essay_info,'page_list'=>$page_list));
   
    }
    function actionAdd(){
        $essay_model=new Essay();
        if($_POST['Essay']){
            foreach($_POST['Essay'] as $_e->$_a){
                $essay_model->$_e=$_a;
            }
            if($essay_model->save()){
                $this->redirect('./index.php?r=admin/essay/show');
            }
        }
        $this->renderPartial('show',array('essay_model'=>$essay_model));
    }
    function actionUpdate($id){
        $essay_model=  Essay::model();
        $essay_info=$essay_model->findAllByPk($id);
        if($_POST['Essay']){
            foreach ($_POST['Essay'] as $_e->$_a){
                $essay_info->$_e=$_a;
                }
                if($essay_info->save()){
                    $this->redirect('./index.php?r=admin/essay/show');
                }
        }
        $this->renderPartial('show',array('essay_info'=>$essay_model));
    }
    function actionDel($id){
        $essay_model=  Essay::model();
        $essay_info=$essay_model->findAllByPk($id);
        if($essay_info->delete()){
            $this->renderPartial('./index.php?r=admin/essay/show');
        }
    }
}