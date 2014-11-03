<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property integer $user_id
 * @property integer $news_id
 * @property integer $event_id
 * @property string $quote_comment
 * @property string $content
 * @property integer $is_anonymity
 * @property integer $is_release
 * @property string $create_date
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
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
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, content, create_date', 'required'),
			array('user_id, news_id, event_id, is_anonymity, is_release', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>255),
			array('quote_comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, news_id, event_id, quote_comment, content, is_anonymity, is_release, create_date', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'news_id' => 'News',
			'event_id' => 'Event',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('event_id',$this->event_id);
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