<?php

/**
 * This is the model class for table "client_log".
 *
 * The followings are the available columns in table 'client_log':
 * @property integer $id
 * @property integer $user_id
 * @property integer $client_id
 * @property integer $alumni_id
 * @property string $content
 * @property string $create_date
 * @property string $next_client_date
 */
class ClientLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClientLog the static model class
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
		return 'client_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, client_id, content, create_date', 'required'),
			array('user_id, client_id, alumni_id', 'numerical', 'integerOnly'=>true),
			array('next_client_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, client_id, alumni_id, content, create_date, next_client_date', 'safe', 'on'=>'search'),
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
            'client' => array(self::BELONGS_TO, 'User', 'client_id'),
            'alumni' => array(self::BELONGS_TO, 'Alumni', 'alumni_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => '练习人',
			'client_id' => '客户',
			'alumni_id' => '所属校友会',
			'content' => '内容',
			'create_date' => 'Create Date',
			'next_client_date' => '下次联系日期',
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('alumni_id',$this->alumni_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('next_client_date',$this->next_client_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}