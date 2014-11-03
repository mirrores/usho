<?php

class TalkController extends Controller {

    public function actionIndex() {
        //设置查询条件
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->select = '*';
        $criteria->condition = 'is_public = 1';

        $count = Talk::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = Talk::model()->findAll($criteria);

        $view['list'] = $records;
        $view['pages'] = $pages;

        $this->pageTitle = '有问必答';
        $this->render('index', $view);
    }
    
    public function actionTalk(){
        $this->render('talk');
    }
    //每隔一分钟获取15分钟内访问人
    public function actionData(){
        $user_list = Yii::app()->db->createCommand()
                    ->select('u.name as user_id, a.name as name')
                    ->from('user_trace as ut')
                    ->leftJoin('user as u', 'ut.user_id=u.id')
                    ->leftJoin('alumni as a', 'u.alumni_id=a.id')
                    ->where('UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(ut.create_date)<900 AND ut.action!="count"')
                    ->group('user_id')
                    ->order('ut.create_date DESC')
                    ->queryAll();
          echo json_encode($user_list);
    }
    public function actionCount(){
         $this->layout = false; 
         $list = Yii::app()->db->createCommand()
                    ->select('count(distinct ut.user_id) as user_id')
                    ->from('user_trace as ut')
                    ->where('UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(ut.create_date)<900 AND ut.action!="count"')
                    ->queryAll();
         echo json_encode($list);
    }
    public function actionCreate() {
        if (!Yii::app()->user->id) {
            throw new CHttpException(403, "很抱歉，您还没有登录，请先登录!");
        }
        $model = new Talk;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Talk'])) {
            $model->attributes = $_POST['Talk'];
            $model->user_id = Yii::app()->user->id;
            $model->create_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                if (isset($_POST['alumni_id'])) {
                    foreach ($_POST['alumni_id'] as $value) {
                        $talk_invite = new TalkInvite();
                        $talk_invite->talk_id = $model->id;
                        $talk_invite->alumni_id = $value;
                        $talk_invite->user_id = Yii::app()->user->id;
                        $talk_invite->create_date = date('Y-m-d H:m:s');
                        $talk_invite->save();
                    }
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        if (!Yii::app()->user->id) {
            throw new CHttpException(403, "很抱歉，您还没有登录，请先登录!");
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Talk'])) {
            $model->attributes = $_POST['Talk'];

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $model->hit_num = $model->hit_num + 1;
        $model->save();
        $view['model'] = $model;
        $this->pageTitle = $model->title;

        //评论列表
        $view['comments_list'] = TalkReply::model()->findAll('talk_id=' . $id);

        $user_info = $this->getUserInfo();
        if ($user_info) {
            $view['user_info'] = $user_info;
            $alumni_info = Alumni::model()->findByPk($user_info->alumni_id); //用户所属校友会信息
            $view['alumni_info'] = $alumni_info;
            $school_info = School::model()->findByPk($alumni_info->school_id); //用户所属学校信息
            $view['school_info'] = $school_info;

            //获取在所有校友会中的排名  
            $rank_in_all = $this->getRankBy($alumni_info->month_rank, $alumni_info->id);
            $view['rank_in_all'] = $rank_in_all;

            //获取在所有同类校友会中的排名
            $rank_in_kind = $this->getRankBy($alumni_info->month_rank, $alumni_info->id, 'select id from school where nature_code=' . $school_info->nature_code . ' AND genre_code=' . $school_info->genre_code);
            $view['rank_in_kind'] = $rank_in_kind;

            //获取在同省份所有校友会中的排名
            $rank_in_province = $this->getRankBy($alumni_info->month_rank, $alumni_info->id, 'select id from school where provinces_id=' . $school_info->provinces_id);
            $view['rank_in_province'] = $rank_in_province;

            //我校校友会新闻
            $my_school_news_list = Yii::app()->db->createCommand()
                ->select('n.*, a.name as name')
                ->from('news as n')
                ->leftJoin('alumni as a', 'n.alumni_id=a.id')
                ->where('n.category_id=1 AND n.alumni_id = ' . $user_info->alumni_id)
                ->limit(6)
                ->order('id DESC')
                ->queryAll();
            $view['my_school_news_list'] = $my_school_news_list;

            //我关注的校友会的新闻
            $my_mark_alumnis = Yii::app()->db->createCommand()
                ->select('alumni_id')
                ->from('user_mark')
                ->where('user_id = ' . $user_info->id)
                ->queryColumn();
            $view['my_mark_alumnis'] = implode(',', $my_mark_alumnis);
            if ($my_mark_alumnis) {
                $my_mark_school_news_list = Yii::app()->db->createCommand()
                    ->select('n.*, a.name as name')
                    ->from('news as n')
                    ->leftJoin('alumni as a', 'n.alumni_id=a.id')
                    ->where('n.category_id=1 AND n.alumni_id IN (' . implode(',', $my_mark_alumnis) . ')')
                    ->limit(6)
                    ->order('id DESC')
                    ->queryAll();
            } else {
                $my_mark_school_news_list = '';
            }
            $view['my_mark_school_news_list'] = $my_mark_school_news_list;

            //同城校友会新闻
            $city_school_list_ids = Yii::app()->db->createCommand('select id from school where provinces_id=' . $school_info->provinces_id)->queryColumn();
            $city_alumni_list_ids = CHtml::listData(Alumni::model()->findAll('id in (' . implode(',', $city_school_list_ids) . ')'), 'id', 'id');
            unset($city_alumni_list_ids[$user_info->alumni_id]);
            $view['city_alumni_list_ids'] = implode(',', $city_alumni_list_ids);
            if ($city_alumni_list_ids) {
                $city_news_list = Yii::app()->db->createCommand()
                    ->select('n.*, a.name as name')
                    ->from('news as n')
                    ->leftJoin('alumni as a', 'n.alumni_id=a.id')
                    ->where('n.category_id=1 AND n.alumni_id IN (' . implode(',', $city_alumni_list_ids) . ')')
                    ->limit(6)
                    ->order('id DESC')
                    ->queryAll();
            } else {
                $city_news_list = '';
            }

            $view['city_news_list'] = $city_news_list;
            $this->render('view_loginer', $view);
        } else {//未登录用户
            //推荐新闻
            $related_news_list = Yii::app()->db->createCommand()
                ->select('n.*, a.name as name')
                ->from('news as n')
                ->leftJoin('alumni as a', 'n.alumni_id=a.id')
                ->limit(10)
                ->order('hit_num DESC')
                ->queryAll();
            $view['related_news_list'] = $related_news_list;

            $this->render('view_nologin', $view);
        }
    }

    public function loadModel($id) {
        $model = Talk::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

}
