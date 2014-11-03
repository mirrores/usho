<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property integer $alumni_id
 * @property integer $alumnic_id
 * @property integer $category_id
 * @property string $title
 * @property string $img_path
 * @property string $promoter
 * @property string $address
 * @property integer $sign_limit
 * @property integer $sign_num
 * @property string $sponsor
 * @property string $organise
 * @property string $start_date
 * @property string $finish_date
 * @property string $content
 * @property string $intro
 * @property string $keyword
 * @property string $source
 * @property string $redirect
 * @property integer $is_fixed
 * @property integer $is_recommend
 * @property integer $is_closed
 * @property string $create_date
 * @property string $update_date
 * @property integer $hit_num
 */
class Event extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Event the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'event';
    }

    /**
     * @return array event_category 
     */
    public function getCategory() {
        return array('全部活动', '运动健身', '吃饭逛街', '座谈沙龙', '室内娱乐', '户外旅游', '周年聚会', '艺术欣赏', '爱心互助', '创业大赛', '其他');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('alumni_id, alumnic_id, category_id, sign_limit, sign_num, is_fixed, is_recommend, is_closed, hit_num', 'numerical', 'integerOnly' => true),
            array('title, address, sponsor, organise', 'length', 'max' => 255),
            array('img_path, keyword', 'length', 'max' => 150),
            array('promoter', 'length', 'max' => 100),
            array('intro', 'length', 'max' => 250),
            array('source, redirect', 'length', 'max' => 200),
            array('start_date, finish_date, content, create_date, update_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, alumni_id, alumnic_id, category_id, title, img_path, promoter, address, sign_limit, sign_num, sponsor, organise, start_date, finish_date, content, intro, keyword, source, redirect, is_fixed, is_recommend, is_closed, create_date, update_date, hit_num', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'alumni' => array(self::BELONGS_TO, 'Alumni', 'alumni_id'),
            'alumnic' => array(self::BELONGS_TO, 'Alumnic', 'alumnic_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'alumni_id' => '校友会',
            'alumnic_id' => '校友分会',
            'category_id' => '动活分类',
            'title' => '标题',
            'img_path' => '相关图片',
            'promoter' => '发起人',
            'address' => '活动地址',
            'sign_limit' => '限制人数',
            'sign_num' => '报名人数',
            'sponsor' => '主办方',
            'organise' => '协办方',
            'start_date' => '开始时间',
            'finish_date' => '结束时间',
            'content' => '活动详情',
            'intro' => '活动概述',
            'keyword' => '关键字',
            'source' => '活动来源',
            'redirect' => '跳转地址',
            'is_fixed' => '是否置顶',
            'is_recommend' => '是否推荐',
            'is_closed' => '是否审核',
            'create_date' => '发布时间',
            'update_date' => '修改时间',
            'hit_num' => '点击数',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('alumni_id', $this->alumni_id);
        $criteria->compare('alumnic_id', $this->alumnic_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('img_path', $this->img_path, true);
        $criteria->compare('promoter', $this->promoter, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('sign_limit', $this->sign_limit);
        $criteria->compare('sign_num', $this->sign_num);
        $criteria->compare('sponsor', $this->sponsor, true);
        $criteria->compare('organise', $this->organise, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('finish_date', $this->finish_date, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('intro', $this->intro, true);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('source', $this->source, true);
        $criteria->compare('redirect', $this->redirect, true);
        $criteria->compare('is_fixed', $this->is_fixed);
        $criteria->compare('is_recommend', $this->is_recommend);
        $criteria->compare('is_closed', $this->is_closed);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('update_date', $this->update_date, true);
        $criteria->compare('hit_num', $this->hit_num);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 获取校友会最近30天活动总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的活动总数
     * @example News::getAlumniRecentCount(array('alumni_id'=>1));
     */
    public static function getRecentCount($condition = array('alumni_id' => -1)) {
        return self::model()->count(array(
                'condition' => 'DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(create_date) AND alumni_id=' . $condition['alumni_id'],
        ));
    }

    /**
     * 获取校友会月活动总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的活动总数
     * @example News::getAlumniRecentCount(array('alumni_id'=>1));
     */
    public static function getMonthCount($condition = array('alumni_id' => -1, 'month' => '1970-01')) {
        return self::model()->count(array(
                'condition' => 'alumni_id=' . $condition['alumni_id'] . ' AND start_date like "%' . $condition['month'] . '%"',
        ));
    }

    /**
     * 获取校友所有活动总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的活动总数
     * @example News::getAlumniAllCount(array('alumni_id'=>1));
     */
    public static function getAllCount($condition = array('alumni_id' => -1)) {
        return self::model()->count(array(
                'condition' => 'alumni_id=' . $condition['alumni_id'],
        ));
    }

}
