<?php

/**
 * This is the model class for table "school".
 *
 * The followings are the available columns in table 'school':
 * @property integer $id
 * @property integer $code
 * @property string $name
 * @property string $short_name
 * @property integer $provinces_id
 * @property integer $cities_id
 * @property integer $nature_code
 * @property integer $genre_code
 * @property integer $company_code
 * @property integer $is_star
 * @property integer $is_fixed
 * @property integer $is_verify
 * @property integer $is_recommend
 * @property string $logo_path
 * @property string $introduction
 * @property string $website
 * @property string $remark
 * @property string $create_date
 * @property string $update_date
 * @property string $keyword
 * @property string $weixin
 * @property string $erweima_path
 * @property string $weibo
 * @property string $celebration
 */
class School extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'school';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, provinces_id, cities_id, nature_code, genre_code, company_code, is_211,is_985,is_star, is_fixed, is_verify, is_recommend', 'numerical', 'integerOnly' => true),
            array('name, short_name, weixin, weibo', 'length', 'max' => 100),
            array('logo_path, website, keyword, erweima_path', 'length', 'max' => 255),
            array('introduction, remark, create_date, update_date, celebration', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, name, short_name, provinces_id, cities_id, nature_code, genre_code, company_code, is_star, is_fixed, is_verify, is_recommend, logo_path, introduction, website, remark, create_date, update_date, keyword, weixin, erweima_path, weibo, celebration', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'provinces' => array(self::BELONGS_TO, 'Provinces', 'provinces_id'),
            'cities' => array(self::BELONGS_TO, 'Cities', 'cities_id'),
            'nature' => array(self::BELONGS_TO, 'Nature', 'nature_code'),
            'genre' => array(self::BELONGS_TO, 'Genre', 'genre_code'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_code'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '学校编号',
            'name' => '学校名称',
            'short_name' => '简称',
            'provinces_id' => '省编码（外键）',
            'cities_id' => '所在城市id(外键)',
            'nature_code' => '学校性质（外键）',
            'genre_code' => '办学类型（外键）',
            'company_code' => '举办单位（外键）',
            'is_211' => '211学校',
            'is_985' => '985学校',
            'is_star' => '是否为重点关注对象',
            'is_fixed' => '是否制定',
            'is_verify' => '是否审核',
            'is_recommend' => '是否为推荐学校',
            'logo_path' => '学校logo',
            'introduction' => '学校简介',
            'website' => '学校网站',
            'remark' => '备注（备注里可以放建设单位等等其他一切相关信息）',
            'create_date' => '创建日期',
            'update_date' => '修改日期',
            'keyword' => '关键字',
            'weixin' => 'Weixin',
            'erweima_path' => '二维码图片',
            'weibo' => '微博帐号',
            'celebration' => '校庆日期',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('short_name', $this->short_name, true);
        $criteria->compare('provinces_id', $this->provinces_id);
        $criteria->compare('cities_id', $this->cities_id);
        $criteria->compare('nature_code', $this->nature_code);
        $criteria->compare('genre_code', $this->genre_code);
        $criteria->compare('company_code', $this->company_code);
        $criteria->compare('is_star', $this->is_star);
        $criteria->compare('is_fixed', $this->is_fixed);
        $criteria->compare('is_verify', $this->is_verify);
        $criteria->compare('is_recommend', $this->is_recommend);
        $criteria->compare('logo_path', $this->logo_path, true);
        $criteria->compare('introduction', $this->introduction, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('update_date', $this->update_date, true);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('weixin', $this->weixin, true);
        $criteria->compare('erweima_path', $this->erweima_path, true);
        $criteria->compare('weibo', $this->weibo, true);
        $criteria->compare('celebration', $this->celebration, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return School the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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

}
