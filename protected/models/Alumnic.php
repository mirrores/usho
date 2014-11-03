<?php

/**
 * This is the model class for table "alumnic".
 *
 * The followings are the available columns in table 'alumnic':
 * @property integer $id
 * @property string $name
 * @property string $website
 * @property integer $alumni_id
 * @property string $logo_path
 * @property string $introduction
 * @property string $remark
 * @property string $create_date
 * @property string $update_date
 * @property string $keyword
 * @property integer $is_recommend
 * @property integer $news_count
 * @property integer $month_news_count
 * @property integer $event_count
 * @property integer $baidu_index
 * @property string $last_collection_date
 */
class Alumnic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alumnic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alumni_id, is_recommend, news_count, month_news_count, event_count, baidu_index', 'numerical', 'integerOnly'=>true),
			array('name, website, logo_path, remark, keyword', 'length', 'max'=>255),
			array('introduction, create_date, update_date, last_collection_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, website, alumni_id, logo_path, introduction, remark, create_date, update_date, keyword, is_recommend, news_count, month_news_count, event_count, baidu_index, last_collection_date', 'safe', 'on'=>'search'),
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
			'name' => '名称',
			'website' => '网址',
			'alumni_id' => '所属校友会',
			'logo_path' => '图片',
			'introduction' => '介绍',
			'remark' => '备注',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
			'keyword' => '关键字',
			'is_recommend' => '是否为推荐',
			'news_count' => '新闻总数',
			'month_news_count' => '本月新闻总数',
			'event_count' => '活动总数',
			'last_collection_date' => '最后采集日期',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('alumni_id',$this->alumni_id);
		$criteria->compare('logo_path',$this->logo_path,true);
		$criteria->compare('introduction',$this->introduction,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('is_recommend',$this->is_recommend);
		$criteria->compare('news_count',$this->news_count);
		$criteria->compare('month_news_count',$this->month_news_count);
		$criteria->compare('event_count',$this->event_count);
		$criteria->compare('baidu_index',$this->baidu_index);
		$criteria->compare('last_collection_date',$this->last_collection_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alumnic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
