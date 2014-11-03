<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Essay extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'essay';
    }
    public function attributeLabels() {
        return array(
            'report_issue'=>'月报期号',
            'essay_title'=>'文章标题',
            'category_id'=>'文章分类',
            'essay_introduction'=>'文章简介',
            'essay_content'=>'文章内容',
            'essay_school'=>'相关学校',
            'essay_keyword'=>'文章关键字',
            'essay_is_top'=>'是否置顶',
            'essay_is_release'=>'是否审核',
            'essay_image'=>'文章图片',
            'essay_url'=>'跳转链接',
            'essay_source'=>'文章来源',
            'essay_authod'=>'文章作者',
            'essay_sort'=>'文章排序',
        );
    }
}