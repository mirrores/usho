<?php

//邮件控制器
//该控制器仅用于管理邮件、模板及栏目，调用使用PersonalizedEmail类


class MailController extends AdminController {

    //全局邮件对象
    public $mail_model;
    //全局用户对象
    public $user_model;

    /**
     * 邮件首页
     */
    public function actionIndex() {


        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        if ($keyword) {
            $criteria->condition = '( name LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = Mail::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = Mail::model()
                ->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => trim($keyword),
        ));
    }

    /**
     * 创建邮件
     */
    public function actionCreate() {
        $model = new Mail;
        $model->content_type = 'custom';
        if (isset($_POST['Mail'])) {
            $_POST['Mail']['created_at'] = date('Y-m-d H:i:s');
            $model->attributes = $_POST['Mail'];
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * 复制邮件
     * 从原有邮件复制出一份新的邮件，包含栏目，发送对象，模板等，但不包含邮件内容
     * @static
     * @access public
     * @param int $id 邮件id
     * @example
     */
    public function actionCopy($id) {
        $mail = $this->loadModel($id)->attributes;
        if ($mail) {
            $new = new Mail;
            $new->attributes = $mail;
            $new->subject = $mail['subject'] . '(拷贝)';
            $new->created_at = date('Y-m-d H:i:s');
            if ($new->save()) {
                $this->copyColumns($id, $new->id);
            }
            $this->redirect(array('index'));
        }
    }

    /**
     * 复制某一邮件下设栏目到新邮件下
     * 但不包含栏目下的内容
     * @access public
     * @param int $mail_id 原邮件id
     * @param int $new_id  新邮件id
     * @example
     */
    public function copyColumns($mail_id, $new_id) {
        $columns = Yii::app()->db->createCommand()
                ->select('*')
                ->from('usho_mail_column')
                ->where('mail_id=' . $mail_id)
                ->queryAll();

        foreach ($columns as $column) {
            unset($column['id']);
            $new = new MailColumn;
            $new->attributes = $column;
            $new->mail_id = $new_id;
            $new->save();
        }
    }

    //修改邮件
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Mail'])) {
            $model->attributes = $_POST['Mail'];
            $model->update_at = date('Y-m-d H:i:s');
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    //删除邮件及下属所有栏目和内容
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    //载入邮件model，存在加入成员变量，避免重复查询
    public function loadModel($id) {
        if (!$this->mail_model) {
            $this->mail_model = Mail::model()->findByPk($id);
            if ($this->mail_model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        return $this->mail_model;
    }

    /**
     * 预览邮件内容
     * 以当前管理员身份进行测试
     * @static
     * @access public
     * @param int $id 邮件id
     * @example
     */
    public function actionPreview($id) {
        $this->layout = false;
        $self_id = Yii::app()->user->id;
        $user_id = Yii::app()->request->getParam('user_id', $self_id);
        $mail = PersonalizedEmail::create($id);
        $mail->setUid($user_id);
        $body = $mail->getBody();
        $total_count = $mail->getUserListCount();
        $this->render('preview', array(
            'mail' => $this->loadModel($id),
            'total_count' => $total_count,
            'user_id' => $user_id,
            'body' => $body
        ));
    }

    /**
     * 发送邮件
     * @static
     * @access public
     * @param int $id 邮件id
     * @param boolean $test 是否为测试邮件
     * @example
     */
    public function actionSend($id) {
        $this->layout = false;
        $user_id = Yii::app()->request->getParam('user_id');
        $mail = PersonalizedEmail::create($id);
        //指定某一用户发送
        //email格式
        if (filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
            $user = User::model()->find('account=:account', array(':account' => trim($user_id)));
            if ($user) {
                $mail->setUid($user->id);
            } else {
                echo 'not user';
                exit;
            }
        }
        //邮件
        elseif (is_numeric($user_id)) {
            $mail->setUid($user_id);
        }
        echo $mail->send();
    }

    /* --------------------------------------------------------------------------------
     * 栏目管理
     * --------------------------------------------------------------------------------
     */

    /**
     * 邮件下属栏目管理首页
     * @static
     * @access public
     * @param int $mail_id 所属邮件id
     * @example
     */
    public function actionColumns($mail_id) {

        $mail = $this->loadModel($mail_id);
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,intro,mail_id,style_id,order_num,title_img_path';
        $criteria->order = 'order_num ASC';
        $criteria->condition = '( mail_id=:mail_id)';
        $criteria->params = array(':mail_id' => $mail_id);
        $count = MailColumn::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = MailColumn::model()
                ->findAll($criteria);

        $this->render('columns', array(
            'mail' => $mail,
            'records' => $records,
            'pages' => $pages
        ));
    }

    //创建栏目
    public function actionCreate_column($mail_id) {
        $mail = $this->loadModel($mail_id);
        $model = new MailColumn;
        $model->style_id = 1;
        if (isset($_POST['MailColumn'])) {
            $model->mail_id = $mail_id;
            $model->order_num = (MailColumn::model()->count('mail_id=' . $mail_id)) + 1;
            $model->attributes = $_POST['MailColumn'];
            if ($model->save())
                $this->redirect(array('columns', 'mail_id' => $mail_id));
        }
        $this->render('column_form', array(
            'mail' => $mail,
            'mail_id' => $mail_id,
            'model' => $model,
        ));
    }

    //修改栏目
    public function actionUpdate_column($id, $mail_id) {
        $model = $this->loadColumn($id);
        $mail = $this->loadModel($mail_id);
        if (isset($_POST['MailColumn'])) {
            $model->attributes = $_POST['MailColumn'];
            if ($model->save())
                $this->redirect(array('columns', 'mail_id' => $mail_id));
        }
        $this->render('column_form', array(
            'mail' => $mail,
            'mail_id' => $mail_id,
            'model' => $model,
        ));
    }

    /**
     * 修改栏目排序
     * @static
     * @access public
     * @param int $id 栏目id
     * @param string $order 操作类型，up或down
     * @example
     */
    public function actionOrder_column($id, $order = 'up') {
        $model = $this->loadColumn($id);
        $criteria = new CDbCriteria();
        $criteria->limit = 1;
        if ($order == 'up') {
            $criteria->order = 'order_num DESC,id DESC';
            $criteria->condition = 'mail_id=' . $model->mail_id . ' AND order_num<' . $model->order_num;
            $previous = MailColumn::model()->find($criteria);
            if ($previous) {
                $previous->order_num = $previous->order_num + 1;
                $previous->save();
            }
            $model->order_num = $model->order_num - 1;
            $model->save();
        } elseif ($order == 'down') {
            $criteria->order = 'order_num ASC,id ASC';
            $criteria->condition = 'mail_id=' . $model->mail_id . ' AND order_num>' . $model->order_num;
            $previous = MailColumn::model()->find($criteria);
            if ($previous) {
                $previous->order_num = $previous->order_num - 1;
                $previous->save();
            }
            $model->order_num = $model->order_num + 1;
            $model->save();
        }
        if ($model)
            $this->redirect(array('columns', 'mail_id' => $model->mail_id));
    }

    public function loadColumn($id) {
        $model = MailColumn::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /* --------------------------------------------------------------------------------
     * 栏目样式管理
     * --------------------------------------------------------------------------------
     */

    //栏目样式首页
    public function actionColumn_style() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name,created_at,is_system';
        $criteria->order = 'id ASC';
        $count = MailColumnStyle::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = MailColumnStyle::model()
                ->findAll($criteria);

        $this->render('style', array(
            'records' => $records,
            'pages' => $pages
        ));
    }

    //添加栏目样式
    public function actionCreate_style() {
        $model = new MailColumnStyle;
        if (isset($_POST['MailColumnStyle'])) {
            $model->attributes = $_POST['MailColumnStyle'];
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                $html = Mail::compile($model->content);
                file_put_contents($this->getGenerateStylePath($model->id), $html);
                $this->redirect(array('column_style'));
            }
        }
        $this->render('style_form', array(
            'model' => $model,
        ));
    }

    //复制栏目样式
    public function actionCopy_style($id) {
        $style = $this->loadStyle($id)->attributes;
        if ($style) {
            $new = new MailColumnStyle;
            $new->attributes = $style;
            $new->name = $style['name'] . '(拷贝)';
            $new->is_system = false;
            $new->save();
        }
        $this->redirect(array('column_style'));
    }

    //修改栏目样式
    public function actionUpdate_style($id, $mail_id = null) {
        $model = $this->loadStyle($id);
        if (isset($_POST['MailColumnStyle'])) {
            $model->attributes = $_POST['MailColumnStyle'];
            if ($model->save()) {
                $html = Mail::compile($model->content);
                file_put_contents($this->getGenerateStylePath($model->id), $html);
                $this->redirect(array('column_style'));
            }
        }
        $this->render('style_form', array(
            'model' => $model,
            'mail_id' => $mail_id
        ));
    }

    //删除栏目样式
    public function actionDelete_style($id) {
        $this->loadStyle($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('column_style'));
    }

    //载入样式model
    public function loadStyle($id) {
        $model = MailColumnStyle::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    //删除栏目
    public function ActionDelete_column($id, $mail_id) {
        $model = $this->loadColumn($id);
        if ($model->delete()) {
            $this->redirect(array('columns', 'mail_id' => $mail_id));
        }
    }

    //获取样式生成地址
    private function getGenerateStylePath($id) {
        return Yii::app()->basePath . '/modules/admin/views/mail/column_style/style' . $id . '.php';
    }

    //预览模板渲染地址
    public function getStylePath($id) {
        return 'application.modules.admin.views.mail.column_style.style' . $id;
    }

    /* --------------------------------------------------------------------------------
     * 邮件模板（信纸）管理
     * --------------------------------------------------------------------------------
     */

    //模板首页
    public function actionTemplate() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name,intro,created_at,is_system';
        $count = MailTemplate::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = MailTemplate::model()
                ->findAll($criteria);
        $this->render('template', array(
            'records' => $records,
            'pages' => $pages
        ));
    }

    //添加模板
    public function actionCreate_template() {
        $model = new MailTemplate;
        if (isset($_POST['MailTemplate'])) {
            $model->attributes = $_POST['MailTemplate'];
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                //将html内容存储为模板文件
                $html = Mail::compile($model->content);
                file_put_contents($this->getGenerateTemplatePath($model->id), $html);
                $this->redirect(array('template'));
            }
        }
        $this->render('template_form', array(
            'model' => $model,
        ));
    }

    //复制模板
    public function actionCopy_template($id) {
        $template = $this->loadTemplate($id)->attributes;
        if ($template) {
            $new = new MailTemplate;
            $new->attributes = $template;
            $new->name = $template['name'] . '(拷贝)';
            $new->is_system = false;
            $new->save();
        }
        $this->redirect(array('template'));
    }

    //修改栏目样式
    public function actionUpdate_template($id) {
        $model = $this->loadTemplate($id);
        if (isset($_POST['MailTemplate'])) {
            $model->attributes = $_POST['MailTemplate'];
            if ($model->save()) {
                //将html内容存储为模板文件
                $html = Mail::compile($model->content);
                file_put_contents($this->getGenerateTemplatePath($model->id), $html);
                $this->redirect(array('template'));
            }
        }
        $this->render('template_form', array(
            'model' => $model
        ));
    }

    //删除模板
    public function actionDelete_template($id) {
        $this->loadTemplate($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(array('template'));
    }

    //载入模板model
    public function loadTemplate($id) {
        $model = MailTemplate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    //获取模板生成地址(模板id)
    private function getGenerateTemplatePath($id) {
        return Yii::app()->basePath . '/modules/admin/views/mail/templates/template' . $id . '.php';
    }

    //预览模板渲染地址
    public function getTemplatePath($id) {
        return 'application.modules.admin.views.mail.templates.template' . $id;
    }

    /* --------------------------------------------------------------------------------
     * 模板内容管理
     * --------------------------------------------------------------------------------
     */

    //添加文章或内容
    public function actionCreate_content($mail_id, $column_id) {
        $model = new MailColumnContent;
        $mail = $this->loadModel($mail_id);
        $model->column_id = $column_id;
        $model->order_num = (MailColumnContent::model()->count('column_id=' . $column_id)) + 1;
        if (isset($_POST['MailColumnContent'])) {
            $model->attributes = $_POST['MailColumnContent'];
            if ($model->save())
                $this->redirect(array('columns', 'mail_id' => $mail_id));
        }
        $this->render('content_form', array(
            'mail' => $mail,
            'mail_id' => $mail_id,
            'model' => $model,
        ));
    }

    //修改内容
    public function actionUpdate_content($id, $mail_id) {
        $model = $this->loadContent($id);
        $mail = $this->loadModel($mail_id);
        if (isset($_POST['MailColumnContent'])) {
            $model->attributes = $_POST['MailColumnContent'];
            if ($model->save())
                $this->redirect(array('columns', 'mail_id' => $mail_id));
        }
        $this->render('content_form', array(
            'model' => $model,
            'mail_id' => $mail_id,
            'mail' => $mail
        ));
    }

    //设置文章排序
    public function actionOrder_content($id, $mail_id, $order = 'up') {
        $model = $this->loadContent($id);
        $criteria = new CDbCriteria();
        $criteria->limit = 1;
        if ($order == 'up') {
            $criteria->order = 'order_num DESC,id DESC';
            $criteria->condition = 'column_id=' . $model->column_id . ' AND order_num<' . $model->order_num;
            $previous = MailColumnContent::model()->find($criteria);
            if ($previous) {
                $previous->order_num = $previous->order_num + 1;
                $previous->save();
            }
            $model->order_num = $model->order_num - 1;
            $model->save();
        } elseif ($order == 'down') {
            $criteria->order = 'order_num ASC,id ASC';
            $criteria->condition = 'column_id=' . $model->column_id . ' AND order_num>' . $model->order_num;
            $previous = MailColumnContent::model()->find($criteria);
            if ($previous) {
                $previous->order_num = $previous->order_num - 1;
                $previous->save();
            }
            $model->order_num = $model->order_num + 1;
            $model->save();
        }
        if ($model)
            $this->redirect(array('columns', 'mail_id' => $mail_id));
    }

    //载入收件人model，存在加入成员变量，避免重复查询
    public function loadUser($id) {
        if (!$this->user_model) {
            $this->user_model = User::model()->findByPk($id);
            if ($this->user_model === null) {
                throw new CHttpException(404, '用户不存在!');
            }
        }
        return $this->user_model;
    }

    //返回内容model
    public function loadContent($id) {
        $model = MailColumnContent::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, '内容不存在');
        return $model;
    }

    //判断是否为ajax
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'monthly-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 邮件首页
     */
    public function actionLogs() {
        $mail_id = Yii::app()->request->getParam('mail_id');
        $user_id = Yii::app()->request->getParam('user_id');
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        if ($mail_id) {
            $criteria->condition = '( mail_id= :mail_id)';
            $criteria->params = array(':mail_id' => $mail_id);
        }
        if ($user_id) {
            $criteria->condition = '( user_id= :user_id)';
            $criteria->params = array(':user_id' => $user_id);
        }
        $count = MailLog::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = MailLog::model()
                ->findAll($criteria);

        $this->render('logs', array(
            'records' => $records, 'pages' => $pages, 'mail_id' => trim($mail_id),
        ));
    }

}
