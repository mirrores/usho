<?php

/**
 * 个性邮件模块
 *
 * The followings are the available columns in table 'mai_column':
 * @property integer $id
 * @property integer $mail_id
 * @property string $title
 * @property integer $style_id
 * @property string $intro
 * @property string $content
 * @property string $url
 * @property string $img_path
 * @property integer $order_num
 */
class MailColumn extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class title.
     * @return MaiModule the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table title
     */
    public function tableName() {
        return 'usho_mail_column';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mail_id,style_id, title', 'required'),
            array('mail_id, style_id, is_show_title,order_num', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('intro', 'length', 'max' => 255),
            array('content', 'safe'),
            array('url, img_path,title_img_path', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, mail_id, title, style_id, intro, url, img_path, order_num', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mail' => array(self::BELONGS_TO, 'Mail', 'mail_id'),
            'style' => array(self::BELONGS_TO, 'MailColumnStyle', 'style_id'),
            'contents' => array(self::HAS_MANY, 'MailColumnContent', 'column_id','order'=>'order_num ASC,id ASC'),
            'contentCount' => array(self::STAT, 'MailColumnContent', 'column_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'mail_id' => '对应邮件',
            'title' => '栏目标题',
            'title_img_path'=>'标题图片',
            'style_id' => '栏目样式',
            'is_show_title'=>'显示标题',
            'intro' => '栏目介绍',
            'content' => '详细内容',
            'url' => '栏目链接',
            'img_path' => '相关图片',
            'order_num' => '排序',
        );
    }
    
    //获得下拉列表
    public function getList($mail_id=0) {
        $returnArr = $this->findAll("mail_id=:mail_id",array(":mail_id"=>$mail_id));
        return CHtml::listData($returnArr, 'id', 'title');
    }
    
    //删除后删除相关内容
    public function afterDelete() {
        parent::afterDelete();
        MailColumnContent::model()->deleteAll('column_id='.$this->id); 
        return true;
    }

}
