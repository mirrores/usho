<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $role
 * @property string $account
 * @property string $password
 * @property string $name
 * @property string $sex
 * @property integer $alumni_id
 * @property integer $foundation_id
 * @property string $department
 * @property string $position
 * @property string $player
 * @property string $address
 * @property string $tel
 * @property string $mobile
 * @property string $fax
 * @property string $qq
 * @property integer $look
 * @property string $note
 * @property integer $is_subscription
 * @property string $last_login_date
 * @property string $last_send_date
 * @property integer $logins_num
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('account, name', 'required'),
            array('alumni_id, foundation_id, look, is_subscription,is_public_email,is_failed_send,logins_num', 'numerical', 'integerOnly' => true),
            array('role, sex', 'length', 'max' => 50),
            array('account, password, name, position, player, tel, mobile, fax, qq', 'length', 'max' => 100),
            array('department, address,title', 'length', 'max' => 255),
            array('note, last_login_date, last_send_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, role, account, password, name, sex, alumni_id, foundation_id, department, position, player, address, tel, mobile, fax, qq, look, note, is_subscription, last_login_date, last_send_date, logins_num', 'safe', 'on' => 'search'),
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
            'foundation' => array(self::BELONGS_TO, 'Foundation', 'foundation_id'),
            'lists' => array(
                self::MANY_MANY,
                'UserList',
                'usho_users_lists(user_id,list_id)'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'role' => '角色',
            'account' => '邮箱',
            'password' => '密码',
            'name' => '姓名',
            'title'=>'邮件称呼',
            'sex' => '性别',
            'alumni_id' => '所属校友会',
            'foundation_id' => '所属基金会',
            'department' => '部门',
            'position' => '职务',
            'player' => '身份类别',
            'address' => '地址',
            'tel' => '电话',
            'mobile' => '电话',
            'fax' => '传真',
            'qq' => 'QQ',
            'look' => '邮箱是否查到',
            'note' => '备注',
            'is_subscription' => '是否订阅',
            'is_public_email'=>'是否为公开邮件地址',
            'is_failed_send'=>'邮件发送失败的',
            'last_login_date' => '最后登录时间',
            'last_send_date' => '最后发送邮件日期',
            'logins_num' => '登录次数',
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
        $criteria->compare('role', $this->role, true);
        $criteria->compare('account', $this->account, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('alumni_id', $this->alumni_id);
        $criteria->compare('foundation_id', $this->foundation_id);
        $criteria->compare('department', $this->department, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('player', $this->player, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('tel', $this->tel, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('qq', $this->qq, true);
        $criteria->compare('look', $this->look);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_subscription', $this->is_subscription);
        $criteria->compare('is_public_email', $this->is_public_email);
        $criteria->compare('last_login_date', $this->last_login_date, true);
        $criteria->compare('last_send_date', $this->last_send_date, true);
        $criteria->compare('logins_num', $this->logins_num);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
