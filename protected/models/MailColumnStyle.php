<?php

/**
 * 模块样式
 *
 * The followings are the available columns in table 'mail_column_style':
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $created_at
 */
class MailColumnStyle extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailColumnStyle the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'usho_mail_column_style';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,content,intro', 'required'),
            array('name,ename', 'length', 'max' => 150),
            array('img_path,intro', 'length', 'max' => 250),
            array('content, created_at,is_system', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, content, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => '样式名称',
            'ename' => '唯一标识',
            'content' => '样式HTML',
            'intro' => '样式说明',
            'is_system'=>'系统样式',
            'created_at' => '创建日期',
            'img_path' => '示例图片'
        );
    }

    //获得下拉列表
    public function getCategoryList() {
        $returnArr = $this->findAll();
        return CHtml::listData($returnArr, 'id', 'name');
    }

}
