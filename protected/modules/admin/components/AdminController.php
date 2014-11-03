<?php

//后台基础类
class AdminController extends Controller {

    public $layout = 'application.modules.admin.views.layouts.main';

    //初始化，判断是否为管理员，不是返回登录
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, "很抱歉，您还没有登录，请先登录!");
        } elseif (Yii::app()->user->role != '管理员') {
            throw new CHttpException(403, "很抱歉，您没有权限访问该页面！");
        }
    }

}
