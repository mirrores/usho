<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Report extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'table';
    }
    public function attributeLabels() {
        return array(
            'report_name'=>'月报名称',
            'report_issue'=>'月报期号',
            'report_image'=>'封面图片',
            'introduction'=>'月报内容简介',
        );
    }
}