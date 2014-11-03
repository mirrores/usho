<?php

class MonthlyController extends AdminController {

    /**
     * 刊物首页
     */
    public function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->order = 'id DESC';
        if ($keyword) {
            $criteria->condition = '( name LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = Monthly::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = Monthly::model()
                ->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => trim($keyword),
        ));
    }

    /**
     * 添加期刊
     */
    public function actionCreate() {
        $model = new Monthly;

        if (isset($_POST['Monthly'])) {
            $_POST['Monthly']['create_date'] = date('Y-m-d');
            $model->attributes = $_POST['Monthly'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * 修改刊物
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Monthly'])) {
            $model->attributes = $_POST['Monthly'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    /**
     * 删除期刊
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        $column_ids = Yii::app()->db->createCommand()
                ->select('id')
                ->from('monthly_column')
                ->where('monthly_id=' . $id)
                ->order('id DESC')
                ->queryColumn();

        MonthlyColumn::model()->deleteAll('monthly_id=' . $id);
        if ($column_ids)
            MonthlyData::model()->deleteAll('column_id in (' . implode(',', $column_ids) . ')');

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * 载入期刊model
     */
    public function loadModel($id) {
        $model = Monthly::model()->findByPk($id);
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

    //获取模板
    public function loadTemplate($id) {
        $model = MonthlyTemplate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    //期刊预览
    public function actionPreview($id) {
        $this->layout = 'application.modules.admin.views.layouts.monthlyTemplate';
        $monthly = $this->loadModel($id);
        if (!$monthly->template_id) {
            exit('您还没有选择模板，请先选择！');
        }

        //应发邮件数量
        $criteria = new CDbCriteria();
        $criteria->condition = 'is_subscription=1 AND account is not NULL';
        $user_count = User::model()->count($criteria);

        //获取邮件预览
        $view['monthly'] = $monthly;
        $view = array_merge($view, MonthlyTemplate::previewTestDate());
        $content = $this->render('application.modules.admin.views.monthlyTemplate.uploads.body' . $monthly->template_id, $view, true);

        //获取发送设置
        $send_seetting = $this->renderPartial('send', array(
            'monthly' => $monthly,
            'user_count' => $user_count
                ), true);
        echo $content . $send_seetting;
    }

    /**
     * 发送全部邮件列表，并根据成功率自动选择发送邮局
     * @static
     * @access public
     * @param integer $id 刊物id
     * @param integer $test 是否发给为测试
     * @example
     */
    public function actionSendmail($id, $test = null) {
        $this->layout = false;
        $monthly = $this->loadModel($id);
        
        //最后一次发送用户id
        $last_uid = $monthly->send_progress ? $monthly->send_progress : 0;

        //发送测试，从用户表第一行开始（现在为管理员）
        $last_uid = $test ? 878 : $last_uid;

        //根据发送进程获取下一个用户信息
        $criteria = new CDbCriteria;
        $criteria->alias = 'u';
        $criteria->condition = 'u.is_subscription=1 AND u.id>' . $last_uid . '  AND u.account is not NULL';
        $user = User::model()->find($criteria);

        //没有用户
        if (!$user) {
            if ($monthly->sent_num <= 0) {
                exit('no user');
            } else {
                $monthly->send_completed_date = date('Y-m-d H:i:s');
                $monthly->is_send_completed = true;
                $monthly->save();
                exit('complete');
            }
        } else {

            //默认值
            $user_id = $user->id;
            $user_name = $user->name;
            $email = $user->account;
            $alumni_id = $user->alumni_id;
            $alumni_name = null;
            $alumni = null;
            $school = null;
            $school_id = null;
            $school_name = null;
            $is_subscription = $user->is_subscription;

            //属于校友会
            if ($alumni_id) {
                $alumni = Alumni::model()->findByPk($alumni_id);
                $alumni_name = $alumni ? $alumni->name : null;
            }

            //属于学校
            if ($alumni AND $alumni->school_id) {
                $school = School::model()->findByPk($alumni->school_id);
                $school_id = $school ? $school->id : null;
                $school_name = $school ? $school->name : null;
            }

            //错误的邮件地址，转发下一份
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $monthly->send_progress = $user_id;
                $monthly->save();
                exit('invalid email');
            }
            //姓名包含校友会的没有简称
            $user_title = $this->getUserTitle($user_name, $school_name, $alumni_name, $is_subscription);

            //模板变量
            $view = array(
                'monthly_id' => $monthly->id,
                'monthly_name' => $monthly->name,
                'user_id' => $user_id,
                'user_title' => $user_title,
                'user_name' => $user_name,
                'school_id' => $school_id,
                'school_name' => $school_name,
                'alumni_id' => $alumni_id,
                'alumni_name' => $alumni_name,
                'usho_site' => 'http://www.usho.cn',
                'login_url' => 'http://www.usho.cn/'
            );

            //发送
            $message = new YiiMailMessage;
            //邮件模板
            $message->view = "body" . $monthly->template_id;
            
            //邮件主题
            $subject = $monthly->subject?$monthly->subject:$user_title;
            $subject=  str_replace('{user_title}',$user_title, $subject);
            $message->subject = $subject;
            
            //设置并渲染邮件正文
            $message->setBody($view, 'text/html');
            //发送给测试人员
            if ($test) {
                $message->addTo('120181530@qq.com');
                $message->addTo('37294812@qq.com');
            }
            //正式发送地址
            else {
                $message->addTo($email);
            }
            
            //添加附件
            //$swiftAttachment = Swift_Attachment::fromPath('./static/uploads/attached/invitation.doc');
            //$message->attach($swiftAttachment);

            //发送状态
            $start = false;

            //使用163邮局发送
            if ($user->is_failed_send) {
                $message->from = array('ushosales@163.com' => '友笑网络');
                $start = Yii::app()->mail163->send($message);
            }
            //使用sohu邮局发送
            else {
                $message->from = array('service@mail.usho.cn' => '友笑网络');
                $start = Yii::app()->mail->send($message);
            }

            //测试不保存发送进度
            if ($start AND $test) {
                echo 'success';
            }
            //发送成功，保存发送进程
            elseif ($start) {
                $monthly->sent_num = $monthly->sent_num + 1;
                $monthly->send_progress = $user->id;
                $monthly->save();
                $user->last_send_date = date('Y-m-d H:i:s');
                $user->save();
                echo $monthly->sent_num;
            } else {
                exit('failure');
            }
        }
    }

    /**
     * 获取用户称谓
     * @static
     * @access public
     * @param boolean $is_subscription 是否公开邮件
     * @param mixed $default 参数名称
     * @return mixed 返回值说明
     * @example
     */
    function getUserTitle($user_name, $school_name, $alumni_name, $is_subscription) {

        //简称
        $short_name = Helper::truncateUtf8String($user_name, 1, '') . '老师';

        //未公开邮件地址的不显示姓
        $short_name = !$is_subscription ? '老师' : $short_name;

        //姓名包含校友会的没有简称
        if ($user_name == '校友会' AND $school_name) {
            $user_title = $school_name . '校友会老师';
        } elseif ($school_name AND $alumni_name AND $user_name) {
            $user_title = $school_name . '校友会' . $short_name;
        } elseif ($alumni_name AND $user_name) {
            $user_title = $alumni_name . '校友会' . $short_name;
        } elseif ($alumni_name) {
            $user_title = $alumni_name . '老师';
        } elseif ($user_name) {
            $user_title = '校友会' . $short_name;
        } else {
            $user_title = '校友会老师';
        }
        return $user_title;
    }

}
