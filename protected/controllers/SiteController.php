<?php

class SiteController extends Controller {

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($return_url = null) {
        $view['return_url'] = $return_url;

        //获取首页新闻列表中置顶的一条
        $news_top = News::model()->findBySql('SELECT * From news WHERE category_id=1 AND is_fixed=1 ORDER BY create_date DESC');
        $view['news_top'] = $news_top;

        //获取首页新闻列表(推荐3条)
        $news_is_recommend_list = Yii::app()->db->createCommand()
                ->select('n.*,a.name')
                ->from('news n')
                ->leftJoin('alumni as a', 'a.id=n.alumni_id');
        if ($news_top) {
            $news_is_recommend_list->where('n.is_recommend=1 AND n.category_id=1 AND n.id!=' . $news_top->id);
        } else {
            $news_is_recommend_list->where('n.is_recommend=1 AND n.category_id=1');
        }
        $news_is_recommend_list = $news_is_recommend_list->limit(3)
                ->order('n.create_date DESC')
                ->queryAll();
        //获取首页新闻列表(非推荐最新7条)
        $news_list = Yii::app()->db->createCommand()
                ->select('n.*,a.name')
                ->from('news n')
                ->leftJoin('alumni as a', 'a.id=n.alumni_id');
        if ($news_top) {
            $news_list->where('n.is_recommend!=1 AND n.category_id=1 AND n.id!=' . $news_top->id);
        } else {
            $news_list->where('n.is_recommend!=1 AND n.category_id=1');
        }
        $news_list = $news_list->limit(7)
                ->order('n.create_date DESC')
                ->queryAll();

        $view['news_list'] = array_merge($news_is_recommend_list, $news_list);

        //获取首页推荐校友会
        $alumni_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('alumni')
                ->where('is_recommend=1 AND website != "" AND logo_path != ""')
                ->limit(4)
                ->order('id DESC')
                ->queryAll();
        $view['alumni_list'] = $alumni_list;

        //近期活动
        /* $event_list = Yii::app()->db->createCommand()
          ->select('e.*,a.name')
          ->from('event e')
          ->leftJoin('alumni as a', 'a.id=e.alumni_id')
          ->where('e.start_date >"' . date('Y-m-d H:i:s') . '"')
          ->limit(9)
          ->order('e.start_date ASC')
          ->queryAll(); */

        $event_list = Event::model()->findAllBySql('SELECT * FROM event AS e WHERE 2>(SELECT count(*) from event where alumni_id=e.alumni_id and id>e.id) order by e.id desc limit 0,9');

        $view['event_list'] = $event_list;

        //政策法规
        $laws_list = Yii::app()->db->createCommand()
                ->select('n.*,a.name')
                ->from('news n')
                ->leftJoin('alumni as a', 'a.id=n.alumni_id')
                ->where('category_id=4')
                ->limit(9)
                ->order('create_date DESC')
                ->queryAll();
        $view['laws_list'] = $laws_list;

        //地方校友会
        $alumnic_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('alumnic')
                ->where('is_recommend=1 AND website != ""')
                ->limit(8)
                ->order('id DESC')
                ->queryAll();
        $view['alumnic_list'] = $alumnic_list;


        $this->render('index', $view);
    }

    //全站搜索
    public function actionSearchSite() {
        $model = Yii::app()->request->getParam('model');
        if ($model != 'monthly' && $model != 'event' && $model != 'weibo')
            $model = 'news';
        $keyword = CHtml::encode(Yii::app()->request->getParam('keyword'));
        $view['keyword'] = $keyword;

        //设置查询条件
        $criteria = new CDbCriteria();
        $criteria->select = '*';

        if ($model == 'monthly') {
            if ($keyword) {
                $_GET['keyword'] = $keyword;
                $criteria->condition = 'name LIKE "%' . trim($keyword) . '%"';
            }
            $criteria->order = 'id DESC';
            $count = Monthly::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 15;
            $pages->applyLimit($criteria);
            $records = Monthly::model()->findAll($criteria);
        } else if ($model == 'weibo') {
            if (!empty($keyword)) {
                $criteria->addCondition("text LIKE '%{$keyword}%'");
            }
            //
            $criteria->order = "created_at DESC";
            $count = Weibo::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 15;
            $pages->applyLimit($criteria);
            $records = Weibo::model()->findAll($criteria);
        } else {
            if ($keyword) {
                $_GET['keyword'] = $keyword;
                $condition = 'title LIKE "%' . trim($keyword) . '%"';

                $provinces_arr = Provinces::model()->findAll('name LIKE "%' . trim($keyword) . '%"');
                if ($provinces_arr) {
                    $provinces_ids = CHtml::listData($provinces_arr, 'id', 'id');
                    $provinces_ids = implode(',', $provinces_ids);

                    $school_arr = School::model()->findAll('provinces_id IN (' . $provinces_ids . ')');
                    if ($school_arr) {
                        $school_ids = CHtml::listData($school_arr, 'id', 'id');
                        $school_ids = implode(',', $school_ids);

                        $alumni_arr = Alumni::model()->findAll('school_id IN (' . $school_ids . ') OR name LIKE "%' . trim($keyword) . '%"');
                    }
                } else {
                    $alumni_arr = Alumni::model()->findAll('name LIKE "%' . trim($keyword) . '%"');
                }

                if ($alumni_arr) {
                    $alumni_ids = CHtml::listData($alumni_arr, 'id', 'id');
                    $alumni_ids = implode(',', $alumni_ids);

                    $condition .= ' OR alumni_id IN (' . $alumni_ids . ')';
                }

                $criteria->condition = $condition;
            }
            if ($model == 'news') {
                $criteria->order = 'create_date DESC';
                $count = News::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = 15;
                $pages->applyLimit($criteria);
                $records = News::model()->findAll($criteria);
            } else {
                $criteria->order = 'start_date DESC';
                $count = Event::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = 15;
                $pages->applyLimit($criteria);
                $records = Event::model()->findAll($criteria);
            }
        }

        $view['model'] = $model;
        $view['count'] = $count;

        $view['list'] = $records;
        $view['pages'] = $pages;
        $this->pageTitle = '全站搜索';
        $this->render('search_site', $view);
    }

    //用户登录
    public function actionLogin() {
        $return_url = Yii::app()->request->urlReferrer;

        // collect user input data
        if (!empty($_POST)) {
            $model = new LoginForm;
            $model->attributes = $_POST;

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                if ($_POST['return_url'])
                    $this->redirect($_POST['return_url']);
                $this->redirect(Yii::app()->user->returnUrl);
            } else {
                Yii::app()->user->setFlash('error', "很抱歉，用户名或密码错误，请重新输入！");
            }
        }

        $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : $return_url;
        $this->actionIndex($return_url);
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    //订阅
    public function actionSubscibe() {
        if (Yii::app()->user->id) {
            $user_info = User::model()->findByPk(Yii::app()->user->id);

            if ($user_info->is_subscription) {
                echo '已订阅';
            } else {
                $user_info->is_subscription = 1;
                $user_info->save();
                echo '订阅成功';
            }
        } else {
            echo '登陆用户才能订阅！请先登录';
        }
    }

}
