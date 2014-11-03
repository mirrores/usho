<?php

/**
 * This is the model class for table "talk_reply".
 *
 * The followings are the available columns in table 'talk_reply':
 * @property integer $id
 * @property integer $talk_id
 * @property integer $user_id
 * @property string $quote_comment
 * @property string $content
 * @property integer $is_anonymity
 * @property integer $is_release
 * @property string $create_date
 */
class TalkReply extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TalkReply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'talk_reply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('talk_id, user_id, content, create_date', 'required'),
			array('talk_id, user_id, is_anonymity, is_release', 'numerical', 'integerOnly'=>true),
			array('quote_comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, talk_id, user_id, quote_comment, content, is_anonymity, is_release, create_date', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'talk_id' => 'Talk',
			'user_id' => 'User',
			'quote_comment' => 'Quote Comment',
			'content' => 'Content',
			'is_anonymity' => 'Is Anonymity',
			'is_release' => 'Is Release',
			'create_date' => 'Create Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('talk_id',$this->talk_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('quote_comment',$this->quote_comment,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('is_anonymity',$this->is_anonymity);
		$criteria->compare('is_release',$this->is_release);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}