<?php

/**
 * This is the model class for table "provinces".
 *
 * The followings are the available columns in table 'provinces':
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $province_id
 * @property integer $group
 * @property string $pinyin
 */
class Provinces extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Provinces the static model class
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
		return 'provinces';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, group', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('pinyin', 'length', 'max'=>150),
			array('created_at, updated_at, province_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, created_at, updated_at, province_id, group, pinyin', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '省份名称',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'province_id' => 'Province',
			'group' => 'Group',
			'pinyin' => 'Pinyin',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('province_id',$this->province_id,true);
		$criteria->compare('group',$this->group);
		$criteria->compare('pinyin',$this->pinyin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}