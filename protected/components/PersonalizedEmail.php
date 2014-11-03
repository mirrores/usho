<?php

/**
 * 个性邮件类
 * 
 * @static
 * @access public
 * @param string $name 参数名称
 * @param mixed $default 参数名称
 * @return mixed 返回值说明
 * @example
 * @ date
 */
class PersonalizedEmail extends Controller {

    public $layout = false;
    //邮件id
    private $_id;
    //邮件model
    private $_mail;
    //发送对象
    //0为所有订阅用户
    private $_object_id;
    //发送用户对象
    private $_user;
    //手动指定用户id
    private $_uid;
    //邮件正文
    private $_body;
    //测试模式
    private $_test = false;
    //邮件标题
    private $_subject;
    //smtp邮件账号
    private $_sender;
    //发送smtp服务商
    public $smtp_server = 'smtp_sohu';

    //创建一个个性邮件
    public static function create($id) {
        return new PersonalizedEmail($id);
    }

    /**
     * 初始化邮件默认内容
     * @static
     * @access public
     * @param int $id 邮件id
     * @param int $object_id 发送队列
     * @return void
     */
    public function __construct($id) {
        $mail = Mail::model()->findByPk($id);
        if ($mail === null) {
            throw new CHttpException(404, '邮件不存在!');
        }
        $this->_id = $id;
        $this->_mail = $mail;
        $this->_object_id = $mail->object_id ? $mail->object_id : 0;
        $this->_subject = $this->_mail->subject;
        $this->_body = $this->_getBody();
    }

    /**
     * 获取系统下一个发送用户信息
     * @static
     * @access private
     * @param boolean $to_array 是否转换为数组
     * @return mixed 用户model
     * @example
     */
    private function _getNextUser() {

        //已经查询过
        if ($this->_user) {
            return $this->_user;
        }
        //手动指定过用户id
        if ($this->_uid) {
            $this->_user = User::model()->findByPk($this->_uid);
            return $this->_user;
        }
        //指定名单中的下一个订阅用户
        elseif ($this->_object_id) {
            $sql = "select uls.user_id as id from usho_users_lists uls left join `user` u on u.id=uls.user_id where uls.list_id=" . $this->_object_id . " AND uls.user_id not in(select usho_mail_log.user_id from usho_mail_log where usho_mail_log.mail_id=$this->_id) and u.is_subscription=1 order by uls.id limit 1";
        }
        //全部订阅用户中的下一个用户
        else {
            $sql = "select u.id from user u where u.id not in(select usho_mail_log.user_id from usho_mail_log where usho_mail_log.mail_id=$this->_id) and u.is_subscription=1 order by u.id limit 1";
        }
        $user = Yii::app()->db->createCommand($sql)->queryRow();
        $this->_user = $user ? User::model()->findByPk($user['id']) : $user;
        return $this->_user;
    }

    /**
     * 获取邮件下属所有栏目渲染结果
     * @access public
     * @return string 返回渲染后的视图html代码
     * @example
     */
    private function _getColumnsBody() {
        $view = array();
        $view['mail'] = $this->_mail;
        $view['art_record'] = array();
        $body = '';
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->order = 'order_num ASC';
        $view['style'] = $this->_mail->template;
        //循环栏目
        foreach ($this->_mail->columns as $column) {
            //最多50条记录
            $criteria->limit = 50;
            //图片新闻
            $criteria->condition = '(column_id=' . $column->id . ')';
            $view['art_record'] = MailColumnContent::model()->findAll($criteria);
            //图片新闻
            $criteria->condition = '(column_id=' . $column->id . ' AND img_path<>"")';
            $criteria->limit = 10;
            $view['img_art_record'] = MailColumnContent::model()->findAll($criteria);
            $view['column'] = $column;
            $body.= "\n<!--$column->title-->\n" . $this->render($this->_getColumnTemplatePath($column->style_id), $view, true);
        }
        return $body;
    }

    //获取邮件真文
    private function _getBody() {
        if ($this->_mail->content_type == 'column') {
            $body = $this->_getColumnsBody();
        } else {
            $body = $this->_mail->content;
        }
        $view['mail'] = $this->_mail;
        $view['body'] = $body;
        $view['style'] = $this->_mail->template;
        $template_path = $this->_getTemplatePath($this->_mail->template->id);
        $body = $this->render($template_path, $view, true);
        return $body;
    }

    //获取邮件模板地址
    private function _getTemplatePath($id) {
        return 'application.modules.admin.views.mail.templates.template' . $id;
    }

    //获取栏目样式模板地址
    private function _getColumnTemplatePath($id) {
        return 'application.modules.admin.views.mail.column_style.style' . $id;
    }

    /**
     * 重新设置发送对象
     * @static
     * @access public
     * @param int $id  对于user_list表id
     * @return void
     * @example
     */
    public function setObject($id) {
        $this->_object_id = $id;
    }

    /**
     * 手动指定单个发送用户id
     * @static
     * @access public
     * @param int $id 用户id
     * @example
     */
    public function setUid($id = 0) {
        $this->_uid = $id;
    }

    //返回邮件正文
    public function getBody() {
        $this->addUshoInfo();

        return $this->_body;
    }

    /**
     * 获取返回邮件信息
     * @static
     * @access public
     * @return ActiveRecord 返回邮件对象
     * @example
     */
    public function getMail() {
        return $this->_mail;
    }

    /**
     * 获取返回邮件信息
     * @static
     * @access public
     * @return ActiveRecord 返回邮件对象
     * @example
     */
    public function getUser() {
        return $this->_getNextUser();
    }

    /**
     * 替换一个标签为定制的内容
     * @static
     * @access public
     * @param string $tag 标签
     * @param string $content 要替换的内容
     * @return mixed $this->_body
     * @example
     */
    public function addContent($tag = '{}', $content = null) {
        if (strpos($body, $tag)) {
            $this->_body = str_replace($tag, $content, $this->_body);
            return $this->_body;
        }
    }

    /**
     * 名单实际订阅人数
     * @static
     * @access public
     * @return array 用户列表
     * @example
     */
    public function getUserListCount() {
        if ($this->_object_id) {
            $sql = "select count(uls.user_id) as total from usho_users_lists uls left join `user` u on u.id=uls.user_id where  uls.list_id=$this->_object_id  AND u.is_subscription=1";
        } else {
            $sql = "select count(u.id) as total from user u where u.is_subscription=1";
        }
        $count = Yii::app()->db->createCommand($sql)->queryRow();
        return $count['total'];
    }

    /**
     * 发送邮件
     * @static
     * @access public
     * @return mixed 发送结果 finish:发送完毕
     * @example
     */
    public function send() {

        //获取发送用户
        $user = $this->_getNextUser();
        //无手动指定用户
        if ($this->_uid AND ! $user) {
            $status = 'not user';
        }
        //无下一个自动发送用户
        elseif (!$user) {
            $status = 'complete';
        }
        //邮件地址错误
        elseif (!filter_var($user->account, FILTER_VALIDATE_EMAIL)) {
            $status = 'invalid email';
        }
        //发送邮件
        else {

            //添加友笑信息
            $this->addUshoInfo();

            //发送邮件
            $message = new YiiMailMessage;
            $message->subject = $this->_subject;
            $message->setBody($this->_body, 'text/html');

            //收件人
            $message->addTo($user->account);

            //特别之处:友笑有些邮件需要其他邮箱发送
            if ($this->smtp_server == 'smtp_163' OR $this->_user->is_failed_send) {
                $mail_server = Common::yiiparam('smtp_163');
                $message->from = $mail_server['from'];
                $this->_sender = $mail_server['sender'];
                $status = Yii::app()->mail163->send($message);
            } else {
                $mail_server = Common::yiiparam('smtp_sohu');
                $message->from = $mail_server['from'];
                $this->_sender = $mail_server['sender'];
                $status = Yii::app()->mail->send($message);
            }

            //单独指定一个用户在发送完成后直接返回完成状态
            $status = $status ? $user->id : $status;
            $status = $this->_uid ? 'complete' : $status;
        }

        $this->_saveLog();
        return $status;
    }

    /**
     * 保存发送日志
     * 包括邮件地址错误的用户记录
     * @static
     * @access private
     * @example
     */
    private function _saveLog() {
        if ($this->_user) {
            $model = new MailLog;
            $model->mail_id = $this->_id;
            $model->user_id = $this->_user->id;
            $model->email = $this->_user->account;
            $model->subject = $this->_subject;
            $model->sender = $this->_sender;
            $model->send_at = date('Y-m-d H:i:s');
            $model->save();
        }
    }

    //个性化信息
    public function addUshoInfo() {

        $user_title = $this->getUserTitle();
        $user_name = $this->getUserName();

        //个性称谓
        if (strpos($this->_subject, 'user_title')) {
            $this->_subject = str_replace('{user_title}', $user_title, $this->_subject);
        }
        if (strpos($this->_body, 'user_title')) {
            $this->_body = str_replace('{user_title}', $user_title, $this->_body);
        }
        //真实名称
        if (strpos($this->_subject, 'user_name')) {
            $this->_subject = str_replace('{user_name}', $user_name, $this->_subject);
        }
        if (strpos($this->_body, 'user_name')) {
            $this->_body = str_replace('{user_name}', $user_name, $this->_body);
        }
        //个性推荐新闻
        if (strpos($this->_body, 'personalized_news')) {
            $this->_body = str_replace('{personalized_news}', $this->personalized_news(), $this->_body);
        }

        //我们自己的新闻
        if (strpos($this->_body, 'our_news')) {
            $our_news = $this->our_news();
            $this->_body = str_replace('{our_news}', $our_news, $this->_body);
        }

        //所有排名
        if (strpos($this->_body, 'rank_in_all')) {
            $this->_body = str_replace('{rank_in_all}', $this->getRankInAll(), $this->_body);
        }

        //同省排名
        if (strpos($this->_body, 'rank_in_province')) {
            $this->_body = str_replace('{rank_in_province}', $this->getRankInProvince(), $this->_body);
        }

        //同类排名
        if (strpos($this->_body, 'rank_in_genre')) {
            $this->_body = str_replace('{rank_in_genre}', $this->getRankInGenre(), $this->_body);
        }

        //邮件追踪
        $pattern = '/http:\/\/www.usho.cn\/([\w]+)\/([\d]{1,6})\.html/';
        $replacement = 'http://www.usho.cn/$1/$2.html?uid=' . $this->_user->id . '&mid=' . $this->_mail->id;
        $this->_body = preg_replace($pattern, $replacement, $this->_body, -1);
        $pattern = '/http:\/\/www.usho.cn\/([\w]+)\.html/';
        $replacement = 'http://www.usho.cn/$1.html?uid=' . $this->_user->id . '&mid=' . $this->_mail->id;
        $this->_body = preg_replace($pattern, $replacement, $this->_body, -1);
        $pattern = '/http:\/\/www.usho.cn\/([\w]+)\/index/';
        $replacement = 'http://www.usho.cn/$1/index?uid=' . $this->_user->id . '&mid=' . $this->_mail->id;
        $this->_body = preg_replace($pattern, $replacement, $this->_body, -1);

        //清除标记
        $this->_subject = preg_replace('/\{.*\}/U', '', $this->_subject, -1);
        $this->_body = preg_replace('/\{.*\}/U', '', $this->_body, -1);
    }

    //获取在所有校友会中的排名
    private function getRankInAll() {
        $user = $this->_getNextUser();
        $alumni = $user->alumni ? $user->alumni : null;
        $rank = 0;
        $month = date("m", strtotime("-1 month"));
        if ($alumni AND $alumni->month_rank) {
            $rank = Alumni::model()->count('month_rank>' . $alumni->month_rank . ' or (month_rank=' . $alumni->month_rank . ' AND id<=' . $alumni->id . ')');
        }
        return $rank ? $month . '月份贵校在友笑网的活跃度排名为第' . $rank . '名，积分为' . $alumni->month_rank : '暂无排名';
    }

    //获取在所有校友会中的排名
    private function getRankInProvince() {
        $user = $this->_getNextUser();
        $alumni = $user->alumni ? $user->alumni : null;
        $school = $alumni && $alumni->school ? $alumni->school : null;
        $rank = 0;
        if ($alumni AND $alumni->month_rank AND $school) {
            $criteria = new CDbCriteria();
            $criteria->select = 't.id';
            $criteria->order = 't.month_rank DESC,t.id ASC';
            $criteria->join = 'left join school s on s.id=t.school_id';
            $criteria->condition = 'month_rank>' . $alumni->month_rank . ' or (month_rank=' . $alumni->month_rank . ' AND t.id<=' . $alumni->id . ')';
            $criteria->addCondition('s.provinces_id=:provinces_id');
            $criteria->params = array(
                ':provinces_id' => $school->provinces_id
            );
            $rank = Alumni::model()->count($criteria);
        }
        return $rank ? '在同省高校中排名为第' . $rank . '名' : '';
    }

    //获取在所有校友会中的排名
    private function getRankInGenre() {
        $user = $this->_getNextUser();
        $alumni = $user->alumni ? $user->alumni : null;
        $school = $alumni && $alumni->school ? $alumni->school : null;
        $rank = 0;
        if ($alumni AND $alumni->month_rank AND $school) {
            $criteria = new CDbCriteria();
            $criteria->select = 't.id';
            $criteria->order = 't.month_rank DESC,t.id ASC';
            $criteria->join = 'left join school s on s.id=t.school_id';
            $criteria->condition = 'month_rank>' . $alumni->month_rank . ' or (month_rank=' . $alumni->month_rank . ' AND t.id<=' . $alumni->id . ')';
            $criteria->addCondition('s.genre_code=:genre_code AND s.nature_code=:nature_code');
            $criteria->params = array(
                ':genre_code' => $school->genre_code,
                ':nature_code' => $school->nature_code,
            );
            $rank = Alumni::model()->count($criteria);
        }
        return $rank ? '在同类高校中排名为第' . $rank . '名' : '';
    }

    //获取用户个性化称呼
    private function getUserTitle() {
        $user = $this->_getNextUser();
        //姓名
        $name = $user->name;
        //校友会名称
        $alumni = $user->alumni ? $user->alumni : null;
        $alumni_name = $alumni ? $alumni->name : null;
        //学校名称
        $school_name = ($alumni && $alumni->school) ? $alumni->school->name : null;
        //姓名简称
        $short_name = Helper::truncateUtf8String($name, 1, '') . '老师';
        //是否订阅
        $is_subscription = $user->is_subscription;
        //未订阅用户只显示姓
        $short_name = !$is_subscription ? '老师' : $short_name;
        //用户称呼
        $title = '';
        if ($name == '校友会' AND $school_name) {
            $title = $school_name . '校友会老师';
        } elseif ($school_name AND $alumni_name AND $name) {
            $title = $school_name . '校友会' . $short_name;
        } elseif ($alumni_name AND $name) {
            $title = $alumni_name . '校友会' . $short_name;
        } elseif ($alumni_name) {
            $title = $alumni_name . '老师';
        } elseif ($name) {
            $title = '校友会' . $short_name;
        } else {
            $title = '校友会老师';
        }
        return $title;
    }

    //获取用户真实称呼
    private function getUserName() {
        $user = $this->_getNextUser();
        $name = $user->name;
        $alumni = $user->alumni ? $user->alumni : null;
        $alumni_name = $alumni ? $alumni->name : null;
        $school_name = ($alumni && $alumni->school) ? $alumni->school->name : null;
        if ($name == '校友会' AND $school_name) {
            $title = $school_name . '校友会老师';
        } elseif ($school_name AND $alumni_name AND $name) {
            $title = $school_name . '校友会' . $name;
        } elseif ($alumni_name AND $name) {
            $title = $alumni_name . '校友会' . $name;
        } elseif ($alumni_name) {
            $title = $alumni_name . '老师';
        } elseif ($name) {
            $title = '校友会' . $name;
        } else {
            $title = '校友会老师';
        }
        return $title;
    }

    //个性推荐新闻
    private function personalized_news() {
        $user = $this->_getNextUser();
        $criteria = new CDbCriteria();
        $criteria->select = 't.id,t.title,t.create_date,t.alumni_id,RAND() AS rand_ids';
        $criteria->limit = 10;
        $criteria->join = 'left join alumni a on a.id=t.alumni_id left join school s on s.id=a.school_id';
        $criteria->order = 'rand_ids';
        //985学校
        if ($user->alumni && $user->alumni->school && $user->alumni->school->is_985) {
            $criteria->condition = 's.is_985=1 AND s.id<>:self_sid AND t.create_date between :start_date and :end_date';
            $criteria->params = array(
                ':self_sid' => $user->alumni->school_id,
                ':start_date' => date('Y-m-d H:i:s', strtotime('-8 day')),
                ':end_date' => date('Y-m-d H:i:s', strtotime('-1 day')),
            );
        }
        //同省学校
        elseif ($user->alumni && $user->alumni->school && $user->alumni->school->provinces_id) {
            $criteria->condition = 's.provinces_id=:provinces_id AND s.id<>:self_sid AND t.create_date between :start_date and :end_date';
            $criteria->params = array(
                ':self_sid' => $user->alumni->school_id,
                ':start_date' => date('Y-m-d H:i:s', strtotime('-8 day')),
                ':end_date' => date('Y-m-d H:i:s', strtotime('-1 day')),
                ':provinces_id' => $user->alumni->school->provinces_id
            );
        }

        $view['record'] = News::model()->findAll($criteria);
        if ($view['record']) {
            $view['user'] = $user;
            $view['mail'] = $this->_mail;
            $view['style'] = $this->_mail->template;
            return "\n<!--个性推荐-->\n" . $this->render($this->_getColumnTemplatePath('_personalized_news'), $view, true);
        } else {
            return '';
        }
    }

    //自己学校新闻
    private function our_news() {
        $user = $this->_getNextUser();
        $criteria = new CDbCriteria();
        $criteria->select = 't.id,t.title,t.create_date,t.alumni_id';
        $criteria->limit = 10;
        $criteria->join = 'left join alumni a on a.id=t.alumni_id left join school s on s.id=a.school_id';
        $criteria->order = 't.id DESC';
        //985学校
        if ($user->alumni && $user->alumni->school) {
            $criteria->condition = ' s.id=:self_sid';
            $criteria->params = array(
                ':self_sid' => $user->alumni->school_id
            );
        }
        $view['record'] = News::model()->findAll($criteria);
        if ($view['record']) {
            $view['user'] = $user;
            $view['mail'] = $this->_mail;
            $view['style'] = $this->_mail->template;
            return $this->render($this->_getColumnTemplatePath('_our_news'), $view, true);
        } else {
            return '';
        }
    }

}
