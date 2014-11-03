<?php

/**
 * This is the model class for table "user_trace".
 *
 * The followings are the available columns in table 'user_trace':
 * @property integer $id
 * @property integer $user_id
 * @property string $controller
 * @property string $action
 * @property string $keyword
 * @property integer $data_id
 * @property integer $news_id
 * @property integer $event_id
 * @property string $ip
 * @property string $explorer
 * @property string $create_date
 */
class UserTrace extends CActiveRecord {

    //以下用户id不进行保存
    public static $filter_user_id = array(852, 875, 878, 151, 876, 890);
    //以下用户ip地址不进行保存
    public static $filter_ip = array('127.0.0.1');

    //在保存之前检查
    public function beforeSave() {

        parent::beforeSave();

        if (in_array($this->user_id, self::$filter_user_id)) {
            $this->addError('user_id', '被忽略的用户id');
            return false;
        }
        if (in_array($this->ip, self::$filter_ip)) {
            $this->addError('user_id', '被忽略的用户ip');
            return false;
        }
        return true;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserTrace the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_trace';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('user_id, data_id, news_id, monthly_id,event_id', 'numerical', 'integerOnly' => true),
            array('controller, action', 'length', 'max' => 50),
            array('keyword, explorer', 'length', 'max' => 200),
            array('ip', 'length', 'max' => 20),
            array('create_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, controller, action, keyword, data_id, news_id, event_id, ip, explorer, create_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'news' => array(self::BELONGS_TO, 'News', 'data_id'),
            'event' => array(self::BELONGS_TO, 'Event', 'data_id'),
            'talk' => array(self::BELONGS_TO, 'Talk', 'data_id'),
            'monthly'=>array(self::BELONGS_TO,'Monthly','monthly_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'controller' => 'Controller',
            'action' => 'Action',
            'keyword' => 'Keyword',
            'data_id' => 'Data',
            'news_id' => 'News',
            'event_id' => 'Event',
            'ip' => 'Ip',
            'explorer' => 'Explorer',
            'create_date' => 'Create Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('controller', $this->controller, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('data_id', $this->data_id);
        $criteria->compare('news_id', $this->news_id);
        $criteria->compare('event_id', $this->event_id);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('explorer', $this->explorer, true);
        $criteria->compare('create_date', $this->create_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
