<?php

/**
 * This is the model class for table "mail_template".
 *
 * The followings are the available columns in table 'mail_template':
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $content
 * @property string $text_color
 * @property string $link_color
 * @property string $created_at
 * @property string $background_color
 * @property string $head_background_color
 * @property string $body_background_color
 * @property string $column_background_color
 * @property string $column_color
 * @property string $font_size
 */
class MailTemplate extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailTemplate the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'usho_mail_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,content', 'required'),
            array('name,logo_path', 'length', 'max' => 150),
            array('intro', 'length', 'max' => 255),
            array('text_color, link_color, background_color, head_background_color, body_background_color, column_background_color, column_color, font_size', 'length', 'max' => 20),
            array('content, created_at,is_system', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, intro, content, text_color, link_color, created_at, background_color, head_background_color, body_background_color, column_background_color, column_color, font_size,is_system', 'safe', 'on' => 'search'),
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
            'intro' => '样式描述',
            'content' => 'HTML代码',
            'text_color' => '文本颜色',
            'link_color' => '链接颜色',
            'created_at' => '创建日期',
            'background_color' => '整体背景色',
            'head_background_color' => '顶部背景色',
            'body_background_color' => '主区域背景色',
            'column_background_color' => '栏目背景色',
            'column_color' => '栏目名称字体色',
            'logo_path' => 'logo图片',
            'is_system'=>'系统模板',
            'font_size' => '字体大小',
        );
    }

    //获得下拉列表
    public function getCategoryList() {
        $returnArr = $this->findAll();
        return CHtml::listData($returnArr, 'id', 'name');
    }

}
