<?php

/**
 * 用户订阅
 *
 * The followings are the available columns in table 'user_subscribe':
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $content
 * @property string $content_id
 * @property integer $limit
 * @property string $created_at
 */
class UserSubscribe extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserSubscribe the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_subscribe';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('limit', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 20),
            array('type', 'length', 'max' => 255),
            array('content,content_ids', 'length', 'max' => 250),
            array('created_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, type, content, content_id, limit, created_at', 'safe', 'on' => 'search'),
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
            'user_id' => '用户',
            'type' => '题材类型',
            'content' => '订阅内容',
            'content_ids' => '内容ID',
            'limit' => '订阅数量',
            'created_at' => '订阅日期',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('content_id', $this->content_id, true);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
