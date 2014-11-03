<?php

class AlumnicController extends AdminController {

      /**
     * Lists all models.
     */
    public function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        if ($keyword) {
            $_GET['keyword'] = $keyword;
            $criteria->condition = '(name like :keyword or introduction like :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = Alumnic::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = Alumnic::model()->findAll($criteria);
        $this->render('index', array('records' => $records, 'pages' => $pages, 'keyword' => $keyword));
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
         $model = new Alumnic;
        if (isset($_POST['Alumnic'])) {
            $model->attributes = $_POST['Alumnic'];
            $model->create_date = date('Y-m-d H:i:s');
            $model->update_date = date('Y-m-d H:i:s');
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }
        $this->render('form', array('model' => $model));
        }



    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
         $model = $this->loadModel($id);
        if (isset($_POST['Alumnic'])) {
            $model->attributes = $_POST['Alumnic'];
            $model->update_date = date('Y-m-d H:i:s');
            $model->save();
        }
        $this->render('form', array('model' => $model));
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
            $this->redirect(array('index'));
    }

  
  

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Alumnic the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Alumnic::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Alumnic $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'alumnic-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
