<?php

class WorkLogController extends AdminController {

    //首页
    public function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->alias = 'w';
        $criteria->order = 'w.id DESC';
        if ($keyword) {
            $_GET['keyword'] = $keyword; //给分页链接添加参数
            $criteria->join = 'LEFT JOIN user u ON w.user_id=u.id';
            $criteria->condition = '( w.content LIKE "%' . trim($keyword) . '%" OR u.name LIKE "%' . trim($keyword) . '%")';
        }
        $count = WorkLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = WorkLog::model()->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword,
        ));
    }
    
    
    //某人的单独日志列表
    public function actionList(){
        $id=  Yii::app()->request->getParam('id');
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->alias = 'w';
        $criteria->condition='w.user_id=:id';
        $criteria->params=array(':id'=>(int)$id);
        $criteria->order = 'w.id DESC';
        if ($keyword) {
            $_GET['keyword'] = $keyword; //给分页链接添加参数
            $criteria->join = 'LEFT JOIN user u ON w.user_id=u.id';
            $criteria->condition = '( w.content LIKE :keyword and user_id= :id)';
            $criteria->params=array(':keyword'=>"%".trim($keyword)."%", ":id"=>(int)$id);
        }
        $count = WorkLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = WorkLog::model()->findAll($criteria);

        $this->render('list', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword,
        ));
    }
    
    
    /**
     * 添加
     */
    public function actionCreate() {
        $model = new WorkLog;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['WorkLog'])) {
            $model->attributes = $_POST['WorkLog'];
            $model->user_id = Yii::app()->user->id;
            $model->create_date = date('Y-m-d H:i:s');
            if ($model->save()) {
                //发送
//                $message = new YiiMailMessage;
//                $message->view = "workLog";
//                $message->subject = Yii::app()->user->name . date('m月d日') . '工作日志';
//                $message->setBody($model, 'text/html');
//                $message->addTo('37294812@qq.com');
//                $message->addTo('120181530@qq.com');
//                $message->from = array('service@mail.usho.cn' => '友笑网络');
//                Yii::app()->mail->send($message);
                $this->redirect(array('index', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }

    //修改内容
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['WorkLog'])) {
            $model->attributes = $_POST['WorkLog'];
            if ($model->save())
                $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'keyword' => Yii::app()->request->getParam('keyword')));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = WorkLog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
