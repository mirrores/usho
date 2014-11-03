<?php

/**
 * This is the model class for table "foundation".
 *
 * The followings are the available columns in table 'foundation':
 * @property integer $id
 * @property string $name
 * @property string $website
 * @property integer $school_id
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
 * @property integer $month_event_count
 * @property integer $month_rank
 * @property integer $baidu_index
 * @property string $last_collection_date
 * @property string $weixin
 * @property string $erweima_path
 * @property string $weibo
 */
class Foundation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Foundation the static model class
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
		return 'foundation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('school_id, is_recommend, news_count, month_news_count, event_count, month_event_count, month_rank, baidu_index', 'numerical', 'integerOnly'=>true),
			array('name, weixin, weibo', 'length', 'max'=>100),
			array('website, logo_path, remark, keyword, erweima_path', 'length', 'max'=>255),
			array('introduction, create_date, update_date, last_collection_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, website, school_id, logo_path, introduction, remark, create_date, update_date, keyword, is_recommend, news_count, month_news_count, event_count, month_event_count, month_rank, baidu_index, last_collection_date, weixin, erweima_path, weibo', 'safe', 'on'=>'search'),
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
            'school' => array(self::BELONGS_TO, 'School', 'school_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'name' => '校友会名称',
            'website' => '网站',
            'school_id' => '所属学校',
            'logo_path' => 'LOGO',
            'introduction' => '简介',
            'remark' => '备注',
            'create_date' => '创建时间',
            'update_date' => '修改时间',
            'keyword' => '关键字',
            'is_recommend' => '是否推荐',
            'news_count' => '新闻总数',
            'month_news_count' => '月活动总数',
            'event_count' => '活动总数',
			'month_event_count' => '月活动总数',
			'month_rank' => '月活跃度',
            'baidu_index' => '百度指数',
            'last_collection_date' => '最后采集日期',
            'weixin' => '微信号',
            'erweima_path' => '二维码',
            'weibo' => '微博帐号',
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
		$criteria->compare('website',$this->website,true);
		$criteria->compare('school_id',$this->school_id);
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
		$criteria->compare('month_event_count',$this->month_event_count);
		$criteria->compare('month_rank',$this->month_rank);
		$criteria->compare('baidu_index',$this->baidu_index);
		$criteria->compare('last_collection_date',$this->last_collection_date,true);
		$criteria->compare('weixin',$this->weixin,true);
		$criteria->compare('erweima_path',$this->erweima_path,true);
		$criteria->compare('weibo',$this->weibo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}