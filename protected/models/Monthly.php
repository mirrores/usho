<?php

/**
 * This is the model class for table "monthly".
 *
 * The followings are the available columns in table 'monthly':
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $issue
 * @property string $cover_img_path
 * @property string $create_date
 * @property integer $template_id
 * @property integer $send_progress
 * @property integer $is_send_completed
 * @property string $send_completed_date
 */
class Monthly extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Monthly the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'monthly';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,subject', 'required'),
            array('template_id, sent_num,send_progress, is_send_completed', 'numerical', 'integerOnly' => true),
            array('name, intro, cover_img_path,subject', 'length', 'max' => 255),
            array('issue', 'length', 'max' => 50),
            array('create_date, send_completed_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, intro, issue, cover_img_path, create_date, template_id, send_progress, is_send_completed, send_completed_date', 'safe', 'on' => 'search'),
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
            'name' => '名称',
            'subject'=>'邮件标题',
            'intro' => '概况',
            'issue' => '期名',
            'cover_img_path' => '封面图片',
            'create_date' => '创建日期',
            'template_id' => '模板',
            'send_progress' => '发送进程',
            'is_send_completed' => '是否发送完毕',
            'send_completed_date' => '发送完成时间',
            'sent_num' => '已发总数',
        );
    }

}
