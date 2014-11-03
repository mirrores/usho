<?php

class EventController extends AdminController {

    //内容首页
    public function actionIndex() {
        $alumni_id=  Yii::app()->request->getParam('alumni_id');
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->alias='e';
        $criteria->order = 'e.id DESC';
        if($alumni_id){
            $criteria->condition='(e.alumni_id=:alumni_id)';
            $criteria->params=array(':alumni_id'=>$alumni_id);
        }
        if ($keyword) {
            $_GET['keyword'] = $keyword;//给分页链接添加参数
            $criteria->join='left join alumni a on a.id=e.alumni_id';
            $criteria->condition = '( e.title LIKE :keyword OR a.name LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = Event::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = Event::model()->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword'=> $keyword,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * 添加内容
     * @access public
     * @param integer $sid 学校id
     * @example
     */
    public function actionCreate() {
        $model = new Event();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Event'])) {
            $model->attributes = $_POST['Event'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    //修改内容
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Event'])) {
            $model->attributes = $_POST['Event'];
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'keyword'=>Yii::app()->request->getParam('keyword')));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Event::model()->findByPk($id);
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

}
