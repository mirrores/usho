<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ReportController extends CController{
    function actionShow(){
       $report_model= Report::model();
        $cnt=$report_model->count();
        $per=10;
        $page=new Pagination($cnt,$per);
        $sql="select * from report $page->limit";
        $report_info=$report_model->findAllBySql($sql);
        $page_list=$page->fpage(array(0,1,2,3,4,5,6,7,8));
        $this->renderPartial('show',array('report_info'=>$report_info,'page_list'=>$page_list));
    }
    function actionAdd(){
        $report_model=new Report();
        if(isset($_POST['Report'])){
            foreach ($_POST['Report'] as $_r => $_a) {
                $report_model->$_r=$_a;
            }
            if($report_model->save()){
                $this->redirect('./index.php?r=admin/report/show');
            }
        }
        $this->renderPartial('add',array('report_model'=>$report_model));
    }
    function actionUpdate($id){
        $report_model=  Report::model();
        $report_info=$report_model->findAllByPk($id);
         if(isset($_POST['Report'])){
             foreach ($_POST['Report'] as $_r => $_a) {
                 $report_info->$_r=$_a;
             }
             if($report_info->save()){
                 $this->redirect('./index.php?r=admin/report/show');
             }
         }
         $this->renderPartial('update',array('report_model'=>$report_info));
    }
    function actionDel($id){
        $report_model=  Report::model();
        $report_info=$report_model->findAllByPk($id);
        if($report_info->delete()){
            $this->redirect('./index.php?r=admin/report/show');
        }
    }
}