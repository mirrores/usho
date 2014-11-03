<?php

/**
 * This is the model class for table "monthly_template".
 *
 * The followings are the available columns in table 'monthly_template':
 * @property integer $id
 * @property string $name
 * @property integer $monthly_id
 * @property string $content
 * @property integer $sended_num
 * @property integer $is_sended
 */
class MonthlyTemplate extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MonthlyTemplate the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'monthly_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('monthly_id, sended_num, is_sended', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 150),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, monthly_id, content, sended_num, is_sended', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => '名称',
            'monthly_id' => '所属期刊',
            'content' => '模板内容',
            'sended_num' => '发送总数',
            'is_sended' => '是否已发送',
        );
    }

    //获得下拉列表
    public function getCategoryList() {
        $returnArr = $this->findAll();
        return CHtml::listData($returnArr, 'id', 'name');
    }

    //预览测试数据
    public static function previewTestDate() {
        return array(
            'monthly_id' => 1,
            'monthly_name' => '友笑月刊测试刊',
            'user_id' => 1,
            'user_name' => '张',
            'school_id' => 22,
            'school_name' => '浙江大学',
            'user_title' => '杭州校友会牛老师',
            'usho_site' => 'http://test.usho.cn',
            'login_url' => 'http://test.usho.cn'
        );
    }

    //编译模板便签
    public static function compile($content) {
        if (!$content) {
            return false;
        }
        $content = str_replace('{monthly_id}', '<?=$monthly_id?>', $content);
        $content = str_replace('{monthly_name}', '<?=$monthly_name?>', $content);
        $content = str_replace('{user_title}', '<?=$user_title?>', $content);
        $content = str_replace('{user_id}', '<?=$user_id?>', $content);
        $content = str_replace('{user_name}', '<?=$user_name?>', $content);
        $content = str_replace('{school_name}', '<?=$school_name?>', $content);
        $content = str_replace('{school_id}', '<?=$school_id?>', $content);
        $content = str_replace('{usho_site}', '<?=$usho_site?>', $content);
        $content = str_replace('{site_name}', '<?=$site_name?>', $content);
        $content = str_replace('{login_url}', '<?=$login_url?>', $content);
        $content = str_replace('{login_url}', '<?=$login_url?>', $content);
        $pattern = '/http:\/\/www.usho.cn\/([\w]+)\/([\d]{1,6})\.html/';
        $replacement = 'http://www.usho.cn/$1/$2.html?uid=<?=$user_id?>&mid=<?=$monthly_id?>';
        $content = preg_replace($pattern, $replacement, $content,-1);
        $pattern = '/http:\/\/www.usho.cn\/([\w]+)\.html/';
        $replacement = 'http://www.usho.cn/$1.html?uid=<?=$user_id?>&mid=<?=$monthly_id?>';
        $content = preg_replace($pattern, $replacement, $content,-1);
        return $content;
    }

}
