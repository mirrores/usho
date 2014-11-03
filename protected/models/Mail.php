<?php

/**
 * 邮件群发任务
 *
 * The followings are the available columns in table 'mail_tasks':
 * @property integer $id
 * @property string $name
 * @property string $subject
 * @property integer $template_id
 * @property integer $object_id
 * @property string $intro
 * @property string $send_completed_date
 * @property string $created_at
 * @property string $update_at
 */
class Mail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailSystem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'usho_mail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('template_id,subject,content_type', 'required'),
            array('template_id, object_id', 'numerical', 'integerOnly' => true),
            array('name, subject,issue,content_type', 'length', 'max' => 150),
            array('intro', 'length', 'max' => 255),
            array('send_completed_date,content,created_at, update_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, subject, template_id, object_id, intro, send_completed_date, created_at, update_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'columns' => array(self::HAS_MANY, 'MailColumn', 'mail_id','order'=>'order_num ASC'),
            'columnsCount' => array(self::STAT, 'MailColumn', 'mail_id'),
            'logs' => array(self::HAS_MANY, 'MailLog', 'mail_id','order'=>'id DESC'),
            'logsCount' => array(self::STAT, 'MailLog', 'mail_id'),
            'userList' => array(self::BELONGS_TO, 'UserList', 'object_id'),
            'template' => array(self::BELONGS_TO, 'MailTemplate', 'template_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => '邮件名称',
            'subject' => '邮件标题',
            'object_id' => '发送对象',
            'intro' => '介绍',
            'issue'=>'总期数',
            'content_type'=>'邮件内容',
            'content'=>'自定内容',
            'template_id'=>'邮件模板',
            'send_completed_date' => '发送完成日期',
            'created_at' => '创建日期',
            'update_at' => '修改日期',
        );
    }
    
    //删除后删除下属栏目、文章、日志
    public function afterDelete() {
        parent::afterDelete();
        foreach ($this->columns as $column) {
            MailColumnContent::model()->deleteAll('column_id='.$column->id);
            $column->delete();
        }
        MailLog::model()->deleteAll('mail_id='.$this->id);
        return true;
    }

    //将标签替换为php代码形式
    public static function compile($content) {
        if (!$content) {
            return false;
        }
        
        $content =str_replace('{body}', "<?=@\$body; ?>", $content);
       
        //栏目相关
        $content=  str_replace('{column_start}','<?php if($column->is_show_title):;?>', $content);
        $content=  str_replace('{column_end}','<?php endif;?>', $content);
        $content=  str_replace('{column_title}','<?=$column->title;?>', $content);
        $content=  str_replace('{column_title_img_path}','<?=$column->title_img_path;?>', $content);
        $content=  str_replace('{column_url}','<?=$column->column_url;?>', $content);
        $content=  str_replace('{column_intro}','<?=$column->intro;?>', $content);
        //栏目内容
        $content=  str_replace('{img_art_start}','<?php foreach($img_art_record AS $key=>$r):?>', $content);
        $content=  str_replace('{img_art_end}','<?php endforeach;?>', $content);
        //文章相关
        $content=  str_replace('{art_start}','<?php foreach($art_record AS $key=>$r):?>', $content);
        $content=  str_replace('{art_end}','<?php endforeach;?>', $content);
        $content=  str_replace('{art_title}','<?=$r->title;?>', $content);
        $content=  str_replace('{art_url}','<?=$r->url;?>', $content);
        $content=  str_replace('{art_intro}','<?=$r->intro;?>', $content);
        $content=  str_replace('{art_content}','<?=$r->content;?>', $content);
        $content=  str_replace('{art_img}','<?=str_replace("_thumbnail","",$r->img_path);?>', $content);
        $content=  str_replace('{art_img_mini}','<?=str_replace("thumbnail","mini",$r->img_path);?>', $content);
        $content=  str_replace('{art_img_thumbnail}','<?=$r->img_path;?>', $content);
        $content=  str_replace('{art_img_bmiddle}','<?=str_replace("thumbnail","bmiddle",$r->img_path);?>', $content);
        $content=  str_replace('{art_img_original}','<?=str_replace("_thumbnail","",$r->img_path);?>', $content);
        $content=  str_replace('{art_style}','<?=$r->art_style;?>', $content);
        
        //邮件顶部
        $content=  str_replace('{mail_name}','<?=isset($mail["name"])?$mail["name"]:"邮件名称未定义";?>', $content);
        $content=  str_replace('{mail_issue}','<?=isset($mail["issue"])?$mail["issue"]:null;?>', $content);
        $content=  str_replace('{logo_path}','<?=isset($style["logo_path"])?$style["logo_path"]:null;?>', $content);
        
        //样式参数
        $content=  str_replace('{background_color}','<?=isset($style["background_color"])?"#".$style["background_color"]:"#ffffff";?>', $content);
        $content=  str_replace('{body_background_color}','<?=isset($style["body_background_color"])?"#".$style["body_background_color"]:"#ffffff";?>', $content);
        $content=  str_replace('{head_background_color}','<?=isset($style["head_background_color"])?"#".$style["head_background_color"]:"#ffffff";?>', $content);
        $content=  str_replace('{column_background_color}','<?=isset($style["column_background_color"])?"#".$style["column_background_color"]:"#666666";?>', $content);
        $content=  str_replace('{text_color}','<?=isset($style["text_color"])?"#".$style["text_color"]:"#333";?>', $content);
        $content=  str_replace('{link_color}','<?=isset($style["link_color"])?"#".$style["link_color"]:"#01478F";?>', $content);
        $content=  str_replace('{column_color}','<?=isset($style["column_color"])?"#".$style["column_color"]:"#ffffff";?>', $content);
        return $content;
    }
    
    

}
