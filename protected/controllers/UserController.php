<?php

class UserController extends Controller {
    
    //初始化，判断是否为管理员，不是返回登录
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, "很抱歉，您还没有登录，请先登录!");
        }
        $this->pageTitle = '会员中心';
    }

    //会员中心首页(我的信息)
    public function actionIndex() {
        //读取登录用户信息
        $user_info = User::model()->findByPk(Yii::app()->user->id);

        //更新数据
        if ($_POST) {
            $user_info->address = $_POST['address'];
            $user_info->tel = $_POST['tel'];
            $user_info->mobile = $_POST['mobile'];
            $user_info->fax = $_POST['fax'];
            $user_info->qq = $_POST['qq'];
            $user_info->save();
        }

        $view['user_info'] = $user_info;
        $this->render('index', $view);
    }

    //会员中心(我的关注)
    public function actionMark() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'user_id=' . Yii::app()->user->id;
        $criteria->order = 'id DESC';

        $count = UserMark::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 12;
        $pages->applyLimit($criteria);
        $records = UserMark::model()
                ->findAll($criteria);

        $view['pages'] = $pages;
        $view['mark_list'] = $records;
        $this->render('mark', $view);
    }

    //会员中心(修改密码)
    public function actionChangePassword() {
        //读取登录用户信息
        $user_info = User::model()->findByPk(Yii::app()->user->id);
        if ($_POST) {
            $user_info->password = $_POST['password'];
            $user_info->save();
        }

        $view['user_info'] = $user_info;
        $this->render('change_password', $view);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('user/mark'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserMark::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

    public function actionMessage() {
        $type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : 1;
        $view['type'] = $type;
        $user_id = Yii::app()->request->getParam('user_id');
        $view['user_id'] = $user_id;
        $page = Yii::app()->request->getParam('page') ? Yii::app()->request->getParam('page') : 1;
        $view['page'] = $page;
        $id = Yii::app()->request->getParam('id');
        $view['id'] = $id;
        $page_show_num = 15;

        $where = 'type=' . trim($type);
        if ($type)
            $where.=' and user_id=' . Yii::app()->user->id;
        $count = Message::model()->count($where);
        $view['count'] = $count;
        $pages = ceil($count / $page_show_num);
        $view['pages'] = $pages;

        $list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('message')
                ->where($where)
                ->limit($page_show_num, ($page - 1) * $page_show_num)
                ->order('id desc')
                ->queryAll();

        $view['list'] = $list;
        $this->render('message', $view);
    }

    public function actionMessagereply($id) {


        $user_id = Yii::app()->request->getParam('user_id');
        $view['user_id'] = $user_id;
        $id = Yii::app()->request->getParam('id');
        $view['id'] = $id;

        $page = Yii::app()->request->getParam('page') ? Yii::app()->request->getParam('page') : 1;
        $view['page'] = $page;
        $page_show_num = 15;

        $where = 'message_id=' . trim($id);




        $count = Message::model()->count($where);
        $view['count'] = $count;
        $pages = ceil($count / $page_show_num);
        $view['pages'] = $pages;

        $list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('message')
                ->where($where)
                ->limit($page_show_num, ($page - 1) * $page_show_num)
                ->order('id desc')
                ->queryAll();

        $view['list'] = $list;
        $this->render('user/message_reply', $view);
    }
    public function actionMessageshow(){
                  $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Message']))
		{
			$model->attributes=$_POST['Message'];
			if($model->save())
				$this->redirect(array('user/message','id'=>$model->id));
		}
                $this->render('user/message_show',array(
		'model'=>$model,
		));
    }
    
    
    //后台输入自动完成提示
    public function actionAutocomplete() {
        $this->layout = false;
        $q = Yii::app()->request->getParam('searchDbInforItem');
        $record = Yii::app()->db->createCommand()
                ->select('id as value, name as label')
                ->from('user')
                ->where('name like "%' . $q . '%"')
                ->order('id ASC')
                ->limit(30)
                ->queryAll();
        if(!$record){
            $record = array(array('value'=>'', 'label'=>'无此用户,请先添加用户'));
        }
        echo json_encode($record);
    }
}
