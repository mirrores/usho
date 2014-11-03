<?php

/**
 * This is the model class for table "weibo_status_child".
 *
 * The followings are the available columns in table 'weibo_status_child':
 * @property integer $weibo_child_sys_id
 * @property integer $parent_weibo_sys_id
 * @property string $idstr
 * @property string $user_id
 * @property string $screen_name
 * @property string $created_at
 * @property string $id
 * @property string $mid
 * @property integer $retweeted_status
 * @property string $url
 * @property string $text
 * @property string $source
 * @property integer $favorited
 * @property integer $truncated
 * @property string $thumbnail_pic
 * @property string $bmiddle_pic
 * @property string $original_pic
 * @property integer $reposts_count
 * @property integer $comments_count
 * @property integer $attitudes_count
 * @property string $pic_urls
 */
class WeiboStatusChild extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'weibo_status_child';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_weibo_sys_id, retweeted_status, favorited, truncated, reposts_count, comments_count, attitudes_count', 'numerical', 'integerOnly'=>true),
			array('idstr, user_id, id, mid', 'length', 'max'=>20),
			array('screen_name, created_at', 'length', 'max'=>50),
			array('url, thumbnail_pic, bmiddle_pic, original_pic', 'length', 'max'=>150),
			array('source', 'length', 'max'=>100),
			array('text, pic_urls', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('weibo_child_sys_id, parent_weibo_sys_id, idstr, user_id, screen_name, created_at, id, mid, retweeted_status, url, text, source, favorited, truncated, thumbnail_pic, bmiddle_pic, original_pic, reposts_count, comments_count, attitudes_count, pic_urls', 'safe', 'on'=>'search'),
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
			'weibo_child_sys_id' => 'Weibo Child Sys',
			'parent_weibo_sys_id' => 'Parent Weibo Sys',
			'idstr' => 'Idstr',
			'user_id' => 'User',
			'screen_name' => 'Screen Name',
			'created_at' => 'Created At',
			'id' => 'ID',
			'mid' => 'Mid',
			'retweeted_status' => 'Retweeted Status',
			'url' => 'Url',
			'text' => 'Text',
			'source' => 'Source',
			'favorited' => 'Favorited',
			'truncated' => 'Truncated',
			'thumbnail_pic' => 'Thumbnail Pic',
			'bmiddle_pic' => 'Bmiddle Pic',
			'original_pic' => 'Original Pic',
			'reposts_count' => 'Reposts Count',
			'comments_count' => 'Comments Count',
			'attitudes_count' => 'Attitudes Count',
			'pic_urls' => 'Pic Urls',
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

		$criteria->compare('weibo_child_sys_id',$this->weibo_child_sys_id);
		$criteria->compare('parent_weibo_sys_id',$this->parent_weibo_sys_id);
		$criteria->compare('idstr',$this->idstr,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('screen_name',$this->screen_name,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('retweeted_status',$this->retweeted_status);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('favorited',$this->favorited);
		$criteria->compare('truncated',$this->truncated);
		$criteria->compare('thumbnail_pic',$this->thumbnail_pic,true);
		$criteria->compare('bmiddle_pic',$this->bmiddle_pic,true);
		$criteria->compare('original_pic',$this->original_pic,true);
		$criteria->compare('reposts_count',$this->reposts_count);
		$criteria->compare('comments_count',$this->comments_count);
		$criteria->compare('attitudes_count',$this->attitudes_count);
		$criteria->compare('pic_urls',$this->pic_urls,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WeiboStatusChild the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
