<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SchoolController extends AdminController {

    function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->join = 'LEFT JOIN provinces as p on p.id=t.provinces_id';
        if ($keyword) {
            $_GET['keyword'] = $keyword;
            $criteria->condition = '(t.name like :keyword or t.introduction like :keyword or p.name like :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }

        $count = School::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = School::model()->findAll($criteria);
        $this->render('index', array('records' => $records, 'pages' => $pages, 'keyword' => $keyword));
    }

    public function actionView($id) {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    function actionCreate() {
        $model = new School;
        if (isset($_POST['School'])) {
            $model->attributes = $_POST['School'];
            $model->create_date = date('Y-m-d H:i:s');
            $model->update_date = date('Y-m-d H:i:s');
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }
        $this->render('form', array('model' => $model));
    }

    function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['School'])) {
            $model->attributes = $_POST['School'];
            $model->update_date = date('Y-m-d H:i:s');
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
        $model = School::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'school-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 切换布尔类型字段值
     * @access public
     * @param string $field 参数名称
     * @example
     */
    public function actionSwitchBoolean($id, $field) {
        $this->layout = false;
        $model = $this->loadModel($id);
        $model->$field = $model->$field == 0 ? 1 : 0;
        $model->save();
    }

}
