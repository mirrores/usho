<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $pageTitle = '友笑网';
    public $userInfo;

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * 微博登陆
     */
    public function getWeiboCodeUrl() {
        $code_url = null;
        if (!isset(Yii::app()->session['token'])) {
            $o = new SaeTOAuthV2(Common::yiiparam('WB_AKEY'), Common::yiiparam('WB_SKEY'));
            $code_url = $o->getAuthorizeURL(Common::yiiparam('WB_CALLBACK_URL'));
        }

        return $code_url;
    }

    /**
     * 粉丝数排名
     */
    public function followersRank() {
        $result = Yii::app()->db->createCommand('select * from weibo_member order by followers_count DESC limit 0,10')->queryAll();
        $view['data'] = $result;

        $this->renderPartial('//weibo/followers_rank', $view);
    }

    /**
     * 微博数排名
     */
    public function statusesRank() {
        $result = Yii::app()->db->createCommand('select * from weibo_member order by statuses_count DESC limit 0,10')->queryAll();
        $view['data'] = $result;

        $this->renderPartial('//weibo/statuses_rank', $view);
    }

    /**
     * 同城最新微博
     */
    public function cityWide() {
        $result = array();
        $user_info = $this->getUserInfo();
        if (!empty($user_info)) {
            $sql = "SELECT a.weibo_sys_id,a.screen_name,a.text,b.`name` as alumni_name,a.user_id,c.`name` as school_name,c.provinces_id 
	                FROM weibo_status a LEFT JOIN alumni b ON a.user_id=b.weibo 
	                LEFT JOIN school c ON b.school_id=c.id
	                WHERE b.weibo!=0 AND b.weibo is NOT NULL AND c.provinces_id = {$user_info->provinces_id}
	                ORDER BY a.created_at DESC
	                LIMIT 10";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
        }
        $view['data'] = $result;

        $this->renderPartial('//weibo/cityWide', $view);
    }

    /**
     * 我校最新微博
     */
    public function mySchoolWeibo() {
        $result = array();
        $user_info = $this->getUserInfo();
        if (!empty($user_info)) {
            $sql = "SELECT a.weibo_sys_id,a.screen_name,a.text,b.`name` as alumni_name,a.user_id,c.`name` as school_name,c.provinces_id 
	                FROM weibo_status a LEFT JOIN alumni b ON a.user_id=b.weibo 
	                LEFT JOIN school c ON b.school_id=c.id
	                WHERE b.weibo!=0 AND b.weibo is NOT NULL AND c.id = {$user_info->school_id}
	                ORDER BY a.created_at DESC
	                LIMIT 10";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
        }
        $view['data'] = $result;

        $this->renderPartial('//weibo/mySchoolWeibo', $view);
    }

    /**
     * 我关注校友会的最新微博
     */
    public function iFocusAlumniWeibo() {
        $result = array();
        $user_info = $this->getUserInfo();
        if (!empty($user_info)) {
            $sql = "SELECT * FROM weibo_status a LEFT JOIN alumni b ON a.user_id=b.weibo
	                LEFT JOIN user_mark c ON c.alumni_id=b.id
	                WHERE c.user_id={$user_info->id}
	                ORDER BY a.created_at DESC
	                LIMIT 10";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
        }
        $view['data'] = $result;

        $this->renderPartial('//weibo/iFocusAlumniWeibo', $view);
    }

    //首页月排名
    public function actionGetRanking() {
        if (Yii::app()->cache->get('all_rank')) {
            $top_alumnis = Yii::app()->cache->get('all_rank');
        } else {
            $top_alumnis = Yii::app()->db->createCommand('select * from alumni order by month_rank DESC limit 0,13')->queryAll();
            Yii::app()->cache->add('all_rank', $top_alumnis, 3600);
        }

        $view['top_alumnis'] = $top_alumnis;

        $this->renderPartial('//site/rank', $view);
    }

    /**
     * return array(学校排名在自己前面的数量, 自己学校的前后学校排名);
     * $month_rank  学校的月活跃度
     * $alumni_id   校友会ID
     * $sql   查询学校的语句
     */
    public function getRankBy($month_rank, $alumni_id, $sql = '') {
        //有新闻或活动的校友会总数
        $totle_num = Yii::app()->db->createCommand()
            ->select("count(*)")
            ->from('alumni');
        //活跃度指数大于自己或者活跃度指数一样、id<=自己的校友会总数
        $ranking_in_all = Yii::app()->db->createCommand()
            ->select("count(*)")
            ->from('alumni');

        if ($sql) {
            $school_ids_arr = Yii::app()->db->createCommand($sql)->queryColumn();
            if (!empty($school_ids_arr)) {
                $totle_num->where('school_id in (' . implode(',', $school_ids_arr) . ')');
                $ranking_in_all->where('school_id in (' . implode(',', $school_ids_arr) . ') and (month_rank>' . $month_rank . ' or (month_rank=' . $month_rank . ' AND id<=' . $alumni_id . '))');
            }
        } else {
            $ranking_in_all->where('month_rank>' . $month_rank . ' or (month_rank=' . $month_rank . ' AND id<=' . $alumni_id . ')');
        }

        $totle_num = $totle_num->queryScalar();
        $ranking_in_all = $ranking_in_all->queryScalar();

        //判断是否为友笑
        if ($alumni_id == 1) {
            $list_sql = 'select * from alumni where id != 2042';
        } else {
            $list_sql = 'select * from alumni where id != 1 AND id != 2042';
        }

        if (isset($school_ids_arr) && !empty($school_ids_arr)) {
            $list_sql .= ' AND school_id in (' . implode(',', $school_ids_arr) . ')';
        }
        if ($ranking_in_all < 4) {
            $ranking_list = Yii::app()->db->createCommand($list_sql . ' order by month_rank DESC, id ASC limit 0,5')->queryAll();
            $ranking = 1;
        } elseif ($totle_num - $ranking_in_all < 3) {
            $ranking_list = Yii::app()->db->createCommand($list_sql . ' order by month_rank DESC, id ASC limit ' . ($totle_num - 5) . ',5')->queryAll();
            $ranking = $totle_num - 4;
        } else {
            $ranking_list = Yii::app()->db->createCommand($list_sql . ' order by month_rank DESC, id ASC limit ' . ($ranking_in_all - 3) . ',5')->queryAll();
            $ranking = $ranking_in_all - 2;
        }

        return array($ranking, $ranking_list);
    }

    //404
    public function notFound() {
        throw new CHttpException(404, '很抱歉，内容不存在或者已经被删除！');
    }

    //用户通过邮件附带uid登陆网站
    public function getUserInfo() {
        $uid = 0;
        if (Yii::app()->user->id) {
            $uid = Yii::app()->user->id;
        } else {
            $cookie = Yii::app()->request->getCookies();
            if (isset($cookie['uid'])) {
                $uid = $cookie['uid']->value;
            }
        }

        if ($uid) {
            $this->userInfo = User::model()->findByPk($uid);
            if ($this->userInfo === null)
                $this->notFound();

            //2014-06-11加入城市ID,学校ID
            $sql = "SELECT c.provinces_id,c.id FROM `user` a LEFT JOIN alumni b ON a.alumni_id=b.id
                    LEFT JOIN school c ON b.school_id=c.id
                    WHERE a.id = {$uid}";
            $tmpArr = Yii::app()->db->createCommand($sql)->queryRow();
            $this->userInfo->provinces_id = $tmpArr['provinces_id'];
            $this->userInfo->school_id = $tmpArr['id'];
        }

        return $this->userInfo;
    }

    //AJAX登录
    public function actionAjaxLogin() {
        if (isset($_POST['account'])) {
            $model = new LoginForm;
            $model->attributes = $_POST;

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                echo '<script type="text/javascript">var i = parent.layer.getFrameIndex(window.name);parent.layer.close(i);</script>';
            } else {
                Yii::app()->user->setFlash('error', "很抱歉，用户名或密码错误，请重新输入！");
            }
        }
        $this->layout = FALSE;
        $uid = Yii::app()->request->getParam('uid');
        $user_info = User::model()->findByPk($uid);
        $view['user_info'] = $user_info;

        $this->render('//site/ajax_login', $view);
    }

    /**
     * 通过所有过滤器后运行
     * @static
     * @access public
     * @example
     */
    function run($actionID) {
        parent::run($actionID);
    }

    /**
     * 在调用控制器action之前调用
     * 结果返回true才会进行下一步
     * @access private
     * @example
     */
    function beforeAction($action) {
        $uid = Yii::app()->user->id ? Yii::app()->user->id : Yii::app()->getRequest()->getQuery('uid');
        if ($uid && User::model()->findByPk($uid)) {
            $cookie = new CHttpCookie('uid', (int) $uid);
            $cookie->expire = time() + 60 * 60 * 24 * 7;  //有限期7天 
            Yii::app()->request->cookies['uid'] = $cookie;
        }

        $cookie = Yii::app()->request->getCookies();
        if (isset($cookie['uid'])) {
            $this->userInfo = User::model()->findByPk($cookie['uid']->value);
        }
        parent::beforeAction($action);
        /* echo Yii::app()->request->userHost;
          //当前控制器名称
          echo $this->getId();
          echo '<br>';
          //当前动作名称
          echo $action->getId();
          echo '<br>';
          //获取查询参数
          echo Yii::app()->getRequest()->getQuery('id');
          echo '<br>';
          echo Yii::app()->getRequest()->getQuery('uid'); */
        return true;
    }

    /**
     * 在调用控制器action之后调用
     * @private
     * @access private
     * @example
     */
    function afterAction($action) {
        if (Yii::app()->user->id) {
            $uid = Yii::app()->user->id;
        } else {
            $cookie = Yii::app()->request->getCookies();
            if (isset($cookie['uid'])) {
                $uid = $cookie['uid']->value;
            }
        }

        if (isset($uid) && is_numeric($uid)) {
            if (!array_search($uid, array(-1, 1, 151, 875, 876, 878, 890, 891))) {
                $UserTrace = new UserTrace;
                $UserTrace->attributes = array(
                    'user_id' => $uid,
                    'controller' => $this->getId(), //当前控制器名称
                    'action' => $action->getId(), //当前动作名称
                    'keyword' => Yii::app()->getRequest()->getQuery('keyword'), //获取查询参数
                    'data_id' => Yii::app()->getRequest()->getQuery('id'),
                    'monthly_id' => Yii::app()->getRequest()->getQuery('mid'),
                    'ip' => Yii::app()->request->userHostAddress,
                    'explorer' => Yii::app()->request->userAgent,
                    'create_date' => date('Y-m-d H:i:s')
                );
                $UserTrace->save();
            }

            $user = User::model()->findByPk($uid);
            $user->last_login_date = date('Y-m-d H:m:s');
            $user->save();
        }

        parent::afterAction($action);
    }

    /**
     * 标题分词
     * @static
     * @access public
     * @param string $id 标题所属新闻的id
     * @param string $title 新闻的标题
     * @param string $model 模型,默认新闻模型
     * @example
     */
    public function createTag($id, $title, $model = 'news') {
        //开始分词
        $so = scws_new();
        $so->set_charset('utf8');
        //忽略标点符号
        $so->set_ignore(true);
        //设定是否将闲散文字自动以二字分词法聚合
        $so->set_duality(true);
        $so->set_multi(0);
        //返回一系列切好的词汇
        $so->send_text($title);

        while ($tmp = $so->get_result()) {
            if (!empty($tmp)) {
                foreach ($tmp as $value) {
                    if ($value['len'] > 3) {
                        $tags = Tags::model()->find('tag="' . $value['word'] . '"');
                        if (empty($tags)) {
                            $tags = new Tags();
                            $tags->tag = $value['word'];
                            $tags->len = $value['len'];
                            $tags->attr = $value['attr'];
                            $tags->save();
                        }

                        if ($model == 'news') {
                            $news_tags = NewsTags::model()->find('news_id=' . $id . ' and tag_id=' . $tags->id);
                            if (empty($news_tags)) {
                                $news_tags = new NewsTags();
                                $news_tags->news_id = $id;
                                $news_tags->tag_id = $tags->id;
                                $news_tags->save();
                            }
                        }
                    }
                }
            }
        }
        //关闭释放资源，使用结束后可以手工调用该函数或等系统自动回收
        $so->close();
    }

}
