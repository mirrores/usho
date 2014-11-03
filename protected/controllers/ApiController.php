<?php

//接口
class ApiController extends Controller {

    //保存采集到的新闻
    public function actionCollectionNews() {
        $this->layout = false;
        $model = new News;
        if (isset($_POST['title']) AND isset($_POST['alumni_id']) AND isset($_POST['redirect']) AND $_POST['title'] AND $_POST['alumni_id'] AND $_POST['redirect']) {
            $model->attributes = $_POST;
            if (!$this->checkDuplicate($_POST['alumni_id'], $_POST['redirect'])) {
                if ($model->save()) {
                    $modelAlumni = Alumni::model()->findByPk($_POST['alumni_id']);
                    $modelAlumni->news_count = $modelAlumni->news_count + 1;
                    $modelAlumni->save();
                    echo 'ok';
                    $this->createTag($model->id, $model->title);
                } else {
                    echo 'error';
                }
            }
        } else {
            echo 'error';
        }
    }

    /**
     * 检查重复的新闻
     * @static
     * @access public
     * @param string $alumni_id 校友会id
     * @param mixed $redirect 跳转网址
     * @return boolean 是否重复
     * @example
     */
    public function checkDuplicate($alumni_id, $redirect = null) {
        $news = News::model()->findBySql('SELECT * From news WHERE alumni_id=' . $alumni_id . ' AND redirect="' . $redirect . '"');
        if ($news) {
            return true;
        } else {
            return false;
        }
    }

    //保存采集到的活动
    public function actionCollectionEvent() {
        $this->layout = false;
        $model = new Event;
        if (isset($_POST['title']) AND isset($_POST['alumni_id']) AND isset($_POST['redirect']) AND $_POST['title'] AND $_POST['alumni_id'] AND $_POST['redirect']) {
            $model->attributes = $_POST;
            if (!$this->checkEventDuplicate($_POST['alumni_id'], $_POST['redirect'])) {
                if ($model->save()) {
                    $modelAlumni = Alumni::model()->findByPk($_POST['alumni_id']);
                    $modelAlumni->event_count = $modelAlumni->event_count + 1;
                    $modelAlumni->save();
                    echo 'ok';
                } else {
                    echo 'error';
                }
            }
        } else {
            echo 'error';
        }
    }

    /**
     * 检查重复的活动
     * @static
     * @access public
     * @param string $alumni_id 校友会id
     * @param mixed $redirect 跳转网址
     * @return boolean 是否重复
     * @example
     */
    public function checkEventDuplicate($alumni_id, $redirect = null) {
        $news = News::model()->findBySql('SELECT * From event WHERE alumni_id=' . $alumni_id . ' AND redirect="' . $redirect . '"');
        if ($news) {
            return true;
        } else {
            return false;
        }
    }

    //搜狐邮件发送状态回执
    public function actionWebhook() {
        $this->layout = false;
        //事件类型
        $event = $this->getParam('event');
        //收件人
        $recipient = $this->getParam('recipient');
        //原始日志
        $criteria = new CDbCriteria();
        $criteria->condition = 'email=:email AND sender=:sender AND to_days(send_at)=to_days(now())';
        $criteria->params = array(':email' => $recipient, ':sender' => 'service@mail.usho.cn');
        $criteria->order = 'id DESC';
        $log = MailLog::model()->find($criteria);

        //记录sohu发送日志
        if ($event AND $log) {
            $log->status = $event;
            $log->message = $this->getParam('message');
            $log->save();
        }

        //发送失败的，尝试使用163邮局发送
        if (in_array($event, array('unsubscribe', 'bounce', 'spam', 'report_spam', 'invalid')) AND $log) {
            $mail = PersonalizedEmail::create($log->mail_id);
            $mail->smtp_server = 'smtp_163';
            $mail->setUid($log->user_id);
            $mail->send();
        }
    }

    public function actionTest() {
        $mail = PersonalizedEmail::create(47);
        $mail->smtp_server = 'smtp_163';
        $mail->setUid(876);
        $mail->send();
    }

    public function getParam($name, $default = false) {
        return Yii::app()->request->getParam($name, $default);
    }

}
