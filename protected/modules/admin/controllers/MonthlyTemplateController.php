<?php

//刊物发送系统
class MonthlyTemplateController extends AdminController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $count = MonthlyTemplate::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = MonthlyTemplate::model()
                ->findAll($criteria);
        $this->render('index', array(
            'records' => $records, 'pages' => $pages
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new MonthlyTemplate;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MonthlyTemplate'])) {
            $model->attributes = $_POST['MonthlyTemplate'];
            $model->content= $model->content;
            if ($model->save())
                $template=MonthlyTemplate::compile($model->content);
                file_put_contents($this->templatePath($model->id), $template);
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MonthlyTemplate'])) {
            $model->attributes = $_POST['MonthlyTemplate'];
            $model->content= $model->content;
            if ($model->save())
                $template=MonthlyTemplate::compile($model->content);
                file_put_contents($this->templatePath($model->id), $template);
            $this->redirect(array('index', 'id' => $model->id));
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MonthlyTemplate the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MonthlyTemplate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MonthlyTemplate $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'monthly-template-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //获取模板地址
    private function templatePath($id) {
        return Yii::app()->basePath . '/modules/admin/views/monthlyTemplate/uploads/body' . $id . '.php';
    }

    //预览模板
    public function actionPreview($id) {
        $this->layout = 'application.modules.admin.views.layouts.monthlyTemplate';
        $this->render('application.modules.admin.views.monthlyTemplate.uploads.body' . $id,  MonthlyTemplate::previewTestDate());
    }

}
