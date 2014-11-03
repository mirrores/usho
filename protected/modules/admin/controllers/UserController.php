<?php

/*
 * 用户控制
 * 作者：徐斌
 * 时间：14/2/28  
 */

class UserController extends AdminController {

    /**
     * Lists all models.
     */
    function actionIndex() {        
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->alias='u';
        $criteria->order = 'u.id DESC';
        if ($keyword) {
            $_GET['keyword'] = $keyword;//给分页链接添加参数
            $criteria->join = 'LEFT JOIN alumni a ON a.id=u.alumni_id';
            $criteria->condition = '( u.name LIKE "%' . trim($keyword) . '%" OR a.name LIKE "%' . trim($keyword) . '%" OR u.account LIKE "%' . trim($keyword) . '%")';
        }
        $count = User::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = User::model()
            ->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword'=> $keyword,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
          $user=  User::model()->findByPk($id);
		$this->render('show',array(
			'user'=>$user,
		));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    function actionCreate() {
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $_POST['User']['password'] = '123456';
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->save();
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
    function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param News $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function actionAjaxSearchSchool() {
        if ($_POST['name'] === '')
            echo '';
        else {
            $data = '';
            $schools = CHtml::listData(School::model()->findAllBySql("SELECT * FROM school WHERE name like '%" . $_POST['name'] . "%' LIMIT 0,10"), 'school_id', 'name');
            foreach ($schools as $key => $value) {
                if ($data)
                    $data.='<option value="' . $key . '">' . $value . '</option>';
                else
                    $data = '<option value="' . $key . '" selected>' . $value . '</option>';
            }
            echo $data;
        }
    }
    
        
    /**
     * 切换布尔类型字段值
     * @access public
     * @param string $field 参数名称
     * @example
     */
    public function actionSwitchBoolean($id,$field){
        $this->layout=false;
        $model= $this->loadModel($id);
        $model->$field=$model->$field==0?1:0;
        $model->save();
    }
    
     //潜在用户
    public function actionPotentialUser(){
        $criteria = new CDbCriteria();
        $criteria->select = 't.id,t.name,a.name as alumni_id,t.position,t.tel';
        $criteria->join='Left join alumni as a on a.id=t.alumni_id';
        $criteria->condition='t.id not in (select user_id from user_trace GROUP BY user_id) and t.is_subscription=1';
        $criteria->group = 't.name';
        $criteria->order='t.id desc';

        $count = User::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = User::model()->findAll($criteria);
        $this->render('potentialuser', array('records' => $records, 'pages' => $pages));
    }

}
