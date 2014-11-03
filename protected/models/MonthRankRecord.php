<?php

/**
 * This is the model class for table "month_rank_record".
 *
 * The followings are the available columns in table 'month_rank_record':
 * @property integer $id
 * @property integer $alumni_id
 * @property string $month
 * @property integer $news_count
 * @property integer $month_news_count
 * @property integer $event_count
 * @property integer $month_event_count
 * @property integer $weibo_count
 * @property integer $month_weibo_count
 * @property integer $month_rank
 * @property string $create_date
 * @property string $update_date
 */
class MonthRankRecord extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonthRankRecord the static model class
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
		return 'month_rank_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alumni_id, month, news_count, month_news_count, event_count, month_event_count, weibo_count, month_weibo_count, month_rank, create_date', 'required'),
			array('alumni_id, news_count, month_news_count, event_count, month_event_count, weibo_count, month_weibo_count, month_rank', 'numerical', 'integerOnly'=>true),
			array('month', 'length', 'max'=>10),
			array('update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, alumni_id, month, news_count, month_news_count, event_count, month_event_count, weibo_count, month_weibo_count, month_rank, create_date, update_date', 'safe', 'on'=>'search'),
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
			'alumni_id' => 'Alumni',
			'month' => 'Month',
			'news_count' => 'News Count',
			'month_news_count' => 'Month News Count',
			'event_count' => 'Event Count',
			'month_event_count' => 'Month Event Count',
			'weibo_count' => 'Weibo Count',
			'month_weibo_count' => 'Month Weibo Count',
			'month_rank' => 'Month Rank',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
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
		$criteria->compare('alumni_id',$this->alumni_id);
		$criteria->compare('month',$this->month,true);
		$criteria->compare('news_count',$this->news_count);
		$criteria->compare('month_news_count',$this->month_news_count);
		$criteria->compare('event_count',$this->event_count);
		$criteria->compare('month_event_count',$this->month_event_count);
		$criteria->compare('weibo_count',$this->weibo_count);
		$criteria->compare('month_weibo_count',$this->month_weibo_count);
		$criteria->compare('month_rank',$this->month_rank);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}