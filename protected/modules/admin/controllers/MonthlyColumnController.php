<?php

class MonthlyColumnController extends AdminController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($monthly_id) {
        $model = new MonthlyColumn();

        if (isset($_POST['MonthlyColumn'])) {
            $_POST['MonthlyColumn']['monthly_id']=$monthly_id;
            $model->attributes = $_POST['MonthlyColumn'];
            if ($model->save())
                $this->redirect(array('index', 'monthly_id' => $monthly_id));
        }
        
        $this->render('form', array(
            'model' => $model,
            'monthly_id' => $monthly_id,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id, $monthly_id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MonthlyColumn'])) {
            $model->attributes = $_POST['MonthlyColumn'];
            if ($model->save())
                $this->redirect(array('index', 'monthly_id' => $monthly_id,));
        }

        $this->render('form', array(
            'model' => $model,
            'imonthly_id' => $monthly_id,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id, $monthly_id) {
        $this->loadModel($id)->delete();
        MonthlyData::model()->deleteAll('column_id='.$id);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'monthly_id'=>$monthly_id));
    }

    /**
     * Lists all models.
     */
    public function actionIndex($monthly_id) {
        $keyword = Yii::app()->request->getParam('keyword');

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->order = 'id DESC';
        $criteria->condition = 'monthly_id='.$monthly_id;
        if ($keyword) {
            $criteria->condition .= ' AND ( name LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = MonthlyColumn::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = MonthlyColumn::model()
            ->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword, 'monthly_id' => $monthly_id,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Monthly the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MonthlyColumn::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Monthly $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'monthly-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
