<?php

/*
 * 关于我们控制
 * 作者：徐斌
 * 时间： 14/2/28 上午午
 */

class AboutController extends AdminController {

    function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        if ($keyword) {
            $criteria->condition = '(title like :keyword or content like :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = About::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = About::model()->findAll($criteria);
        $this->render('index', array('records' => $records, 'pages' => $pages));
    }

    public function actionView($id) {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    function actionCreate() {
        $model = new About;
        if (isset($_POST['About'])) {
            $model->attributes = $_POST['About'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }
        $this->render('form', array('model' => $model));
    }

    function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['About'])) {
            $model->attributes = $_POST['About'];
            $model->save();
        }
        $this->render('form', array('model' => $model));
    }

    function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function loadModel($id) {
        $model = About::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'about-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
