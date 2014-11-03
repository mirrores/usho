<?php

/**
 * This is the model class for table "weibo_status".
 *
 * The followings are the available columns in table 'weibo_status':
 * @property integer $weibo_sys_id
 * @property string $idstr
 * @property string $user_id
 * @property string $screen_name
 * @property integer $created_at
 * @property string $id
 * @property string $mid
 * @property integer $retweeted_status
 * @property integer $repost_status
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
 * @property string $profile_image_url
 */
class WeiboStatus extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'weibo_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_at, retweeted_status, repost_status, favorited, truncated, reposts_count, comments_count, attitudes_count', 'numerical', 'integerOnly'=>true),
			array('idstr, user_id, id, mid', 'length', 'max'=>20),
			array('screen_name', 'length', 'max'=>50),
			array('url, thumbnail_pic, bmiddle_pic, original_pic', 'length', 'max'=>150),
			array('source, profile_image_url', 'length', 'max'=>100),
			array('text, pic_urls', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('weibo_sys_id, idstr, user_id, screen_name, created_at, id, mid, retweeted_status, repost_status, url, text, source, favorited, truncated, thumbnail_pic, bmiddle_pic, original_pic, reposts_count, comments_count, attitudes_count, pic_urls, profile_image_url', 'safe', 'on'=>'search'),
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
			'weibostatuschild' => array(self::HAS_ONE,'WeiboStatusChild','parent_weibo_sys_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'weibo_sys_id' => 'Weibo Sys',
			'idstr' => 'Idstr',
			'user_id' => 'User',
			'screen_name' => 'Screen Name',
			'created_at' => 'Created At',
			'id' => 'ID',
			'mid' => 'Mid',
			'retweeted_status' => 'Retweeted Status',
			'repost_status' => 'Repost Status',
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
			'profile_image_url' => 'Profile Image Url',
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

		$criteria->compare('weibo_sys_id',$this->weibo_sys_id);
		$criteria->compare('idstr',$this->idstr,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('screen_name',$this->screen_name,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('retweeted_status',$this->retweeted_status);
		$criteria->compare('repost_status',$this->repost_status);
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
		$criteria->compare('profile_image_url',$this->profile_image_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WeiboStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * 获取校友会最近30天微博总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的活动总数
     * @example News::getAlumniRecentCount(array('alumni_id'=>1));
     */
    public static function getRecentCount($condition = array('user_id' => -1)) {
        return self::model()->count(array(
                'condition' => 'DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(created_at) AND user_id=' . $condition['user_id'],
        ));
    }

    /**
     * 获取校友会月微博总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的活动总数
     * @example News::getAlumniRecentCount(array('alumni_id'=>1));
     */
    public static function getMonthCount($condition = array('user_id' => -1, 'month' => '1970-01')) {
        return self::model()->count(array(
                'condition' => 'user_id=' . $condition['user_id'] . ' AND FROM_UNIXTIME(created_at) like "%' . $condition['month'] . '%"',
        ));
    }

    /**
     * 获取校友所有微博总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的活动总数
     * @example News::getAlumniAllCount(array('alumni_id'=>1));
     */
    public static function getAllCount($condition = array('user_id' => -1)) {
        return self::model()->count(array(
                'condition' => 'user_id=' . $condition['user_id'],
        ));
    }
}
