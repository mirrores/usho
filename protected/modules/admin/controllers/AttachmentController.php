<?php
//附件管理
class AttachmentController extends AdminController {

    //内容首页
    public function actionIndex() {

        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        if ($keyword) {
            $criteria->condition = '( title LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = Attachment::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = Attachment::model()
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
     * 添加内容
     * @access public
     * @example
     */
    public function actionCreate() {
        $model = new Attachment;
        $model->title='none';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Attachment'])) {
            $model->attributes = $_POST['Attachment'];
            $model->created_date = date('Y-m-d H:i:s');
            $model->user_id = Yii::app()->user->id;
            if ($model->save())
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
     * @return Attachment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Attachment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Attachment $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
