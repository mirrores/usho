<?php

/**
 * This is the model class for table "mail_column_content".
 *
 * The followings are the available columns in table 'mail_column_content':
 * @property string $id
 * @property string $column_id
 * @property string $title
 * @property string $intro
 * @property string $url
 * @property string $style
 * @property integer $order_num
 * @property string $img_path
 */
class MailColumnContent extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailColumnContent the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //保存之前
    public function beforeSave() {
        parent::beforeSave();
        if ($this->content) {
            $this->content = str_replace('<p>', '<p style="margin:0 0 10px 0">', $this->content);
        }
        return true;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'usho_mail_column_content';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,column_id,url', 'required'),
            array('order_num', 'numerical', 'integerOnly' => true),
            array('column_id', 'length', 'max' => 10),
            array('title', 'length', 'max' => 150),
            array('intro', 'length', 'max' => 255),
            array('url, img_path', 'length', 'max' => 200),
            array('style', 'length', 'max' => 50),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, column_id, title, intro, url, style, order_num, img_path', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'column' => array(self::BELONGS_TO, 'MailColumn', 'column_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'column_id' => '所属模块',
            'title' => '标题',
            'intro' => '内容概况',
            'content' => '详细内容',
            'url' => '链接',
            'style' => '标题样式',
            'order_num' => '排序',
            'img_path' => '相关图片',
        );
    }

}
