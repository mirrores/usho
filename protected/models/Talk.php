<?php

/**
 * This is the model class for table "talk".
 *
 * The followings are the available columns in table 'talk':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $user_id
 * @property string $create_date
 * @property integer $hit_num
 * @property integer $reply_num
 * @property integer $is_public
 * @property integer $is_anonymity
 * @property integer $is_fixed
 * @property integer $is_release
 */
class Talk extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Talk the static model class
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
		return 'talk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, user_id, create_date', 'required'),
			array('user_id, hit_num, reply_num, is_public, is_anonymity, is_fixed, is_release', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, user_id, create_date, hit_num, reply_num, is_public, is_anonymity, is_fixed, is_release', 'safe', 'on'=>'search'),
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
			'title' => '标题',
			'content' => '内容',
			'user_id' => 'User',
			'create_date' => 'Create Date',
			'hit_num' => '点击数',
			'reply_num' => '回复数',
			'is_public' => '是否公开',
			'is_anonymity' => '是否匿名',
			'is_fixed' => '是否置顶',
			'is_release' => '是否审核',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('hit_num',$this->hit_num);
		$criteria->compare('reply_num',$this->reply_num);
		$criteria->compare('is_public',$this->is_public);
		$criteria->compare('is_anonymity',$this->is_anonymity);
		$criteria->compare('is_fixed',$this->is_fixed);
		$criteria->compare('is_release',$this->is_release);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}