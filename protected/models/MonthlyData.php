<?php

/**
 * This is the model class for table "monthly_data".
 *
 * The followings are the available columns in table 'monthly_data':
 * @property integer $id
 * @property integer $column_id
 * @property integer $news_id
 * @property integer $event_id
 * @property string $title
 * @property string $title_color
 * @property string $intro
 * @property string $content
 * @property string $keyword
 * @property string $author
 * @property string $img_path
 * @property integer $hit_num
 * @property string $source_url
 * @property string $create_date
 * @property string $update_date
 */
class MonthlyData extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonthlyData the static model class
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
		return 'monthly_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('column_id, title', 'required'),
			array('column_id, news_id, event_id, hit_num', 'numerical', 'integerOnly'=>true),
			array('title, intro, img_path, source_url', 'length', 'max'=>255),
			array('title_color', 'length', 'max'=>50),
			array('keyword, author', 'length', 'max'=>100),
			array('content, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, column_id, news_id, event_id, title, title_color, intro, content, keyword, author, img_path, hit_num, source_url, create_date, update_date', 'safe', 'on'=>'search'),
		);
	}

    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'column' => array(self::BELONGS_TO, 'MonthlyColumn', 'column_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'column_id' => '栏目',
			'news_id' => '新闻选择',
			'event_id' => '活动选择',
			'title' => '标题',
			'title_color' => '标题颜色',
			'intro' => '简介',
			'content' => '内容',
			'keyword' => '关键字',
			'author' => '作者',
			'img_path' => '图片',
			'hit_num' => '点击数',
			'date' => '日期',
			'source_url' => '来源地址',
			'create_date' => '创建日期',
			'update_date' => '修改日期',
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
		$criteria->compare('column_id',$this->column_id);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title_color',$this->title_color,true);
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('img_path',$this->img_path,true);
		$criteria->compare('hit_num',$this->hit_num);
		$criteria->compare('source_url',$this->source_url,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}