<?php

class ClientLogController extends AdminController {

    //首页
    public function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $client_id = Yii::app()->request->getParam('client_id');
        $alumni_id = Yii::app()->request->getParam('alumni_id');

        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';

        if ($client_id) {
            $_GET['client_id'] = $client_id;
            $criteria->condition = 'client_id=' . $client_id;
        } elseif ($alumni_id) {
            $_GET['alumni_id'] = $alumni_id;
            $criteria->condition = 'alumni_id=' . $alumni_id;
        } elseif ($keyword) {
            $alumni_arr = Yii::app()->db->createCommand()
                ->select('id')
                ->from('alumni')
                ->where('name LIKE "%' . trim($keyword) . '%"')
                ->queryColumn();

            $user_arr = Yii::app()->db->createCommand()
                ->select('id')
                ->from('user')
                ->where('name LIKE "%' . trim($keyword) . '%"')
                ->queryColumn();
            $_GET['keyword'] = $keyword;
            $criteria->condition = 'content LIKE  "%' . trim($keyword) . '%"';

            if (isset($alumni_arr) && $alumni_arr) {
                $criteria->condition = 'alumni_id IN (' . implode(',', $alumni_arr) . ')';
            }
            if (isset($user_arr) && $user_arr) {
                $criteria->condition .= ' OR user_id IN (' . implode(',', $user_arr) . ') OR client_id IN (' . implode(',', $user_arr) . ')';
            }
        }

        $count = ClientLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = ClientLog::model()->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword,
        ));
    }

    /**
     * 添加
     */
    public function actionCreate() {
        $model = new ClientLog;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['ClientLog'])) {
            $model->attributes = $_POST['ClientLog'];
            $model->alumni_id = User::model()->findByPk($_POST['ClientLog']['client_id'])->alumni_id;
            $model->user_id = Yii::app()->user->id;
            $model->create_date = date('Y-m-d H:i:s');
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

        if (isset($_POST['ClientLog'])) {
            $model->attributes = $_POST['ClientLog'];
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
        $model = ClientLog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
