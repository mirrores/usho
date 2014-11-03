<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        //在数据库查找用户
        $user = User::model()->find('account=:account', array(':account' => $this->username));
        if (count($user) == 1) {
            if ($user->password == $this->password) {
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $user->id;
                $this->username = $user->name;
                $this->setState('last_login_date', $user->last_login_date?$user->last_login_date:date('Y-m-d H:i:s'));
                $this->setState('role', $user->role?$user->role:'游客');
                //更新登录次数及最后登录时间
                $user->last_login_date = date('Y-m-d H:i:s');
                $user->logins_num = $user->logins_num + 1;
                $user->save();
            } else {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        return !$this->errorCode;
    }

    //获取当前登陆用户的ID
    public function getId() {
        return $this->_id;
    }

}
