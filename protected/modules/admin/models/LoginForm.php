<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginForm extends CFormModel{
    public $account;
    public $password;
    private $_identity;
    
    
    public function rules(){
        return array(
                array('account','required','message'=>'用户名必填'),
                array('password','required','message'=>'密码必填'),
                array('password','authenticate'),
                );
    }
    public function authenticate($attribute,$params){
        if(!$this->hasErrors()){
            $this->_identity=new UserIdentity($this->account,$this->password);
            if(!$this->_identity->authenticate())
                $this->addError ('password','用户名或密码不存在');
        }
    }
    public function attributeLabels() {
        return array(
            'account'=>'用户名',
            'password'=>'密码',
        );
    } 
    public function login(){
        if($this->_identity===null){
            $this->_identity=new UserIdentity($this->account,  $this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE){
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }  else {
            return false;    
        }
    }
}