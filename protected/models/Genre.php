<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Genre extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'genre';
    }
    public function getGenreList(){
        $returnArr=  $this->findAll();
        return CHtml::listData($returnArr, 'code', 'name');
    }
    public function attributeLabels() {
        return array(
            'genre_code'=>'办学类型编码',
             'genre_name'=>'办学类型名称',
        );
    }
    public function rules() {
        return array(
            array('code,name','required'),
            array('code','numerical','integerOnly'=>true),
        );
    }
}
