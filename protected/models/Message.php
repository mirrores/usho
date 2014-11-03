<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $id
 * @property integer $message_id
 * @property integer $type
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $create_date
 * @property string $udpate_date
 * @property string $keyword
 * @property integer $is_read
 * @property integer $is_recommend
 */
class Message extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_id, type, user_id, is_read, is_recommend', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>150),
			array('keyword', 'length', 'max'=>255),
			array('content, create_date, udpate_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, message_id, type, user_id, title, content, create_date, udpate_date, keyword, is_read, is_recommend', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                                           'user'=>array(self::BELONGS_TO,'User','user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'message_id' => '级父留言id',
			'type' => '言留类型',
			'user_id' => '户用id',
			'title' => '言留标题',
			'content' => '详细内容',
			'create_date' => 'Create Date',
			'udpate_date' => 'Udpate Date',
			'keyword' => '关键字',
			'is_read' => '是否已经阅读',
			'is_recommend' => '是否推荐',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('message_id',$this->message_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('udpate_date',$this->udpate_date,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('is_read',$this->is_read);
		$criteria->compare('is_recommend',$this->is_recommend);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
