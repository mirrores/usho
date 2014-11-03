<?php

/**
 * This is the model class for table "weixin".
 *
 * The followings are the available columns in table 'weixin':
 * @property string $id
 * @property integer $category_id
 * @property integer $alumni_id
 * @property string $title
 * @property string $intro
 * @property string $content
 * @property string $created_at
 * @property string $url_key
 * @property string $url
 * @property integer $hits_num
 * @property integer $is_recommend
 * @property string $img_path
 * @property string $keywords
 */
class Weixin extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Weixin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'weixin';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, alumni_id, hits_num, is_recommend', 'numerical', 'integerOnly' => true),
            array('title, keywords', 'length', 'max' => 150),
            array('intro, url, img_path', 'length', 'max' => 255),
            array('url_key', 'length', 'max' => 32),
            array('content, created_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, alumni_id, title, intro, content, created_at, url_key, url, hits_num, is_recommend, img_path, keywords', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'category_id' => 'Category',
            'alumni_id' => 'Alumni',
            'title' => 'Title',
            'intro' => 'Intro',
            'content' => 'Content',
            'created_at' => 'Created At',
            'url_key' => 'Url Key',
            'url' => 'Url',
            'hits_num' => 'Hits Num',
            'is_recommend' => 'Is Recommend',
            'img_path' => 'Img Path',
            'keywords' => 'Keywords',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('alumni_id', $this->alumni_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('intro', $this->intro, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('url_key', $this->url_key, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('hits_num', $this->hits_num);
        $criteria->compare('is_recommend', $this->is_recommend);
        $criteria->compare('img_path', $this->img_path, true);
        $criteria->compare('keywords', $this->keywords, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
