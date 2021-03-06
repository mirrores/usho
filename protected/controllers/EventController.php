<?php

class EventController extends Controller {

    //活动列表首页
    public function actionIndex() {
        //获取参数
        $alumni_id = Yii::app()->request->getParam('alumni_id');
        $view['alumni_id'] = $alumni_id;

        //搜索的条件
        $where = '';
        if ($alumni_id)
            $where.= 'alumni_id=' . trim($alumni_id);

        //设置查询条件
        $criteria = new CDbCriteria();
        $criteria->order = 'start_date DESC, id DESC';
        $criteria->select = '*';
        $criteria->condition = $where;

        $count = Event::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = Event::model()->findAll($criteria);

        $view['list'] = $records;
        $view['pages'] = $pages;
        $this->pageTitle = '校友活动';
        $this->render('index', $view);
    }

    //查看单条活动详细
    public function actionView($id, $uid = null) {
        //获取活动详细,
        $event = $this->loadModel($id);
        $view['event'] = $event;
        $this->pageTitle = $event['title'];

        //活动的评论列表
        $view['comments_list'] = Comment::model()->findAll('event_id=' . $id);
        
        //下一篇活动
        $next_event = Yii::app()->db->createCommand()
            ->select('id,title')
            ->from('event')
            //->where('id != ' . $id)
            ->where('start_date <= "' . $event->start_date . '" AND id != ' . $id)
            ->order('start_date DESC, id DESC')
            ->limit(1)
            ->queryRow();
        $view['next_event'] = $next_event;

        $user_info = $this->getUserInfo();
        if ($user_info) {
            $view['user_info'] = $user_info;
            $alumni_info = Alumni::model()->findByPk($user_info->alumni_id); //用户所属校友会信息
            $view['alumni_info'] = $alumni_info;
            $school_info = School::model()->findByPk($alumni_info->school_id); //用户所属学校信息
            $view['school_info'] = $school_info;

            //判断用户是否已关注新闻所属校友会
            $is_marked = UserMark::model()->find('user_id = ' . $user_info->id . ' AND alumni_id=' . $event->alumni_id);
            $view['is_marked'] = $is_marked;

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
            $city_alumni_list_ids = CHtml::listData(Alumni::model()->findAll('id in ('.implode(',', $city_school_list_ids).')'), 'id', 'id');
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
            //获取相关活动
            if($view['event']->keyword){
                $where = 'e.keyword like "%' . $view['event']->keyword . '%" AND n.id != ' . $view['event']->id;
            }else{
                $where = 'e.id != ' . $view['event']->id;
            }
            $related_event_list = Yii::app()->db->createCommand()
                ->select('e.*, a.name as name')
                ->from('event as e')
                ->leftJoin('alumni as a', 'e.alumni_id=a.id')
                ->where($where)
                ->limit(10)
                ->order('rand()')
                ->queryAll();
            $view['related_event_list'] = $related_event_list;

            $this->render('view_nologin', $view);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Event the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Event::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Event $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //后台输入学校名称自动完成提示
    public function actionAutocomplete() {
        $this->layout = false;
        $q = Yii::app()->request->getParam('searchDbInforItem');
        $record = Yii::app()->db->createCommand()
            ->select('id as value,title as label')
            ->from('event')
            ->where('title like "%' . $q . '%"')
            ->order('id ASC')
            ->limit(30)
            ->queryAll();
        echo json_encode($record);
    }

}
