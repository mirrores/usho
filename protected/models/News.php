<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property integer $alumni_id
 * @property integer $alumnic_id
 * @property integer $foundation_id
 * @property string $title
 * @property string $title_color
 * @property string $subtitle
 * @property string $intro
 * @property string $content
 * @property string $authod_name
 * @property string $create_date
 * @property string $update_date
 * @property integer $category_id
 * @property string $keyword
 * @property string $source
 * @property string $redirect
 * @property string $recommend_path
 * @property string $images
 * @property integer $is_fixed
 * @property integer $is_recommend
 * @property integer $is_release
 * @property integer $hit_num
 * @property string $collection_key
 */
class News extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('alumni_id,category_id,title,content', 'required'),
            array('alumni_id, alumnic_id, foundation_id, category_id, is_fixed, is_recommend, is_release, hit_num', 'numerical', 'integerOnly' => true),
            array('title, subtitle, keyword, source', 'length', 'max' => 150),
            array('title_color, intro, redirect, images', 'length', 'max' => 255),
            array('authod_name', 'length', 'max' => 100),
            array('recommend_path', 'length', 'max' => 200),
            array('collection_key', 'length', 'max' => 50),
            array('content, create_date, update_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, alumni_id, alumnic_id, foundation_id, title, title_color, subtitle, intro, content, authod_name, create_date, update_date, category_id, keyword, source, redirect, recommend_path, images, is_fixed, is_recommend, is_release, hit_num, collection_key', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'alumni' => array(self::BELONGS_TO, 'Alumni', 'alumni_id'),
            'alumnic' => array(self::BELONGS_TO, 'Alumnic', 'alumnic_id'),
            'foundation' => array(self::BELONGS_TO, 'Foundation', 'foundation_id'),
            'tags' => array(
                self::MANY_MANY,
                'Tags',
                'news_tags(news_id,tag_id)'
            )
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
            'foundation_id' => '基金会',
            'title' => '标题',
            'title_color' => '标题颜色',
            'subtitle' => '副标题',
            'intro' => '介绍',
            'content' => '内容',
            'authod_name' => '作者',
            'create_date' => '创建日期',
            'update_date' => '修改日期',
            'category_id' => '新闻分类',
            'keyword' => '关键字',
            'source' => '文章来源',
            'redirect' => '跳转地址',
            'recommend_path' => 'Recommend Path',
            'images' => '新闻图片',
            'is_fixed' => '置顶',
            'is_recommend' => '推荐',
            'is_release' => '审核',
            'hit_num' => '击点数',
            'collection_key' => '集采key，验证是否采集过',
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
        $criteria->compare('foundation_id', $this->foundation_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('title_color', $this->title_color, true);
        $criteria->compare('subtitle', $this->subtitle, true);
        $criteria->compare('intro', $this->intro, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('authod_name', $this->authod_name, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('update_date', $this->update_date, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('source', $this->source, true);
        $criteria->compare('redirect', $this->redirect, true);
        $criteria->compare('recommend_path', $this->recommend_path, true);
        $criteria->compare('images', $this->images, true);
        $criteria->compare('is_fixed', $this->is_fixed);
        $criteria->compare('is_recommend', $this->is_recommend);
        $criteria->compare('is_release', $this->is_release);
        $criteria->compare('hit_num', $this->hit_num);
        $criteria->compare('collection_key', $this->collection_key, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * 基本查询字段
     * @static
     * @access public
     * @param string $alias 表别名
     * @param array $other_fields 其他字段
     * @return array 字段字符串
     * @example
     */
    public static function baseFields() {
        return array('id', 'title', 'recommend_path', 'is_fixed', 'category_id', 'alumni_id');
    }

    /**
     * 基本查询字段
     * @static
     * @access public
     * @param string $alias 表别名
     * @param array $other_fields 其他字段
     * @return string 字段字符串
     * @example
     */
    public static function baseSelectFields($alias = null, $other_fields = array()) {
        $base_field = self::baseFields();
        $base_field = array_merge($base_field, $other_fields);
        $fields = '';
        foreach ($base_field as $f) {
            $fields = $fields ? $fields . ',' . $alias . $f : $alias . $f;
        }
        return $fields;
    }

    /**
     * 获取校友会最近30天新闻总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的新闻总数
     * @example News::getAlumniRecentCount(array('alumni_id'=>1));
     */
    public static function getRecentCount($condition = array('alumni_id' => -1)) {
        return self::model()->count(array(
                    'condition' => 'DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(create_date) AND alumni_id=' . $condition['alumni_id'],
        ));
    }

    /**
     * 获取校友会月新闻总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的新闻总数
     * @example News::getAlumniRecentCount(array('alumni_id'=>1));
     */
    public static function getMonthCount($condition = array('alumni_id' => -1, 'month' => '1970-01')) {
        return self::model()->count(array(
                    'condition' => 'alumni_id=' . $condition['alumni_id'] . ' AND create_date like "%' . $condition['month'] . '%"',
        ));
    }

    /**
     * 获取校友所有新闻总数
     * @static
     * @access public
     * @param array $condition 查询条件
     * @return integer 符合条件的新闻总数
     * @example News::getAlumniAllCount(array('alumni_id'=>1));
     */
    public static function getAllCount($condition = array('alumni_id' => -1)) {
        return self::model()->count(array(
                    'condition' => 'alumni_id=' . $condition['alumni_id'],
        ));
    }

    /**
     * 待添加功能
     * @static
     * @access public
     * @param string $name 参数名称
     * @param mixed $default 参数名称
     * @return mixed 返回值说明
     * @example
     */
    public function afterFind() {
        parent::afterFind();
    }

}
