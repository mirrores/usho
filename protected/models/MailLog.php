<?php

/**
 * 邮件发送日志
 *
 * The followings are the available columns in table 'mail_log':
 * @property string $id
 * @property string $user_id
 * @property string $subject
 * @property string $mail_id
 * @property string $status
 * @property string $send_at
 */
class MailLog extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'usho_mail_log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'length', 'max' => 20),
            array('email', 'length', 'max' => 50),
            array('subject, message', 'length', 'max' => 255),
            array('mail_id', 'length', 'max' => 10),
            array('sender', 'length', 'max' => 100),
            array('status', 'length', 'max' => 30),
            array('send_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, email, subject, mail_id, sender, message, status, send_at', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => '用户',
            'email' => '邮件地址',
            'subject' => '邮件主题',
            'mail_id' => '邮件',
            'sender' => '发送邮件',
            'message' => '状态详情',
            'status' => '状态',
            'send_at' => '发送日期',
        );
    }

    //获取邮件发送状态
    public static function getStatusLabel($name = 'other') {
        $status = array(
            'request' => '正在请求发送',
            'deliver' => '邮件已经发送',
            'open' => '邮件已经被打开',
            'click' => '邮件内容已经被阅读',
            'unsubscribe' => '邮件被取消订阅',
            'bounce' => '邮件被弹回(软退信)',
            'spam' => '被判定为垃圾邮件',
            'report_spam' => '被垃圾邮件举报',
            'invalid' => '邮件被判定为无效',
            'other' => '未知',
        );
        if (isset($status[$name])) {
            return $status[$name];
        } else {
            return $name;
        }
    }

}
