<?php

class NewsController extends Controller {
    
    //新闻列表首页
    public function actionIndex() {
        //获取参数
        $category_id = Yii::app()->request->getParam('category_id') ? Yii::app()->request->getParam('category_id') : 1;
        $view['category_id'] = $category_id;
        $alumni_id = Yii::app()->request->getParam('alumni_id');
        $view['alumni_id'] = $alumni_id;

        //搜索的条件
        $where = 'category_id=' . trim($category_id);
        if ($alumni_id)
            $where.= ' AND alumni_id IN (' . trim($alumni_id) . ')';

        //设置查询条件
        $criteria = new CDbCriteria();
        $criteria->order = 'create_date DESC, id DESC';
        $criteria->select = '*';
        $criteria->condition = $where;

        $count = News::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = News::model()->findAll($criteria);

        $view['list'] = $records;
        $view['pages'] = $pages;

        $this->pageTitle = '新闻动态';
        $this->render('index', $view);
    }

    //查看单条新闻详细
    public function actionView($id, $uid = null) {
        //获取新闻详细,更新新闻点击数
        $news = $this->loadModel($id);
        $news->hit_num = $news->hit_num + 1;
        $view['news'] = $news;
        $news->save();

        //新闻的评论列表
        $view['comments_list'] = Comment::model()->findAll('news_id=' . $id);

        //下一篇新闻
        $next_news = Yii::app()->db->createCommand()
            ->select('id,title')
            ->from('news')
            ->where('category_id=' . $news->category_id . ' AND create_date <= "' . $news->create_date . '" AND id != ' . $id)
            ->order('create_date DESC, id DESC')
            ->limit(1)
            ->queryRow();
        $view['next_news'] = $next_news;
        $this->pageTitle = $news['title'];

        $user_info = $this->getUserInfo();
        if ($user_info) {
            $view['user_info'] = $user_info;
            $alumni_info = Alumni::model()->findByPk($user_info->alumni_id); //用户所属校友会信息
            $view['alumni_info'] = $alumni_info;
            $school_info = School::model()->findByPk($alumni_info->school_id); //用户所属学校信息
            $view['school_info'] = $school_info;

            //判断用户是否已关注新闻所属校友会
            $is_marked = UserMark::model()->find('user_id = ' . $user_info->id . ' AND alumni_id=' . $news->alumni_id);
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
            //获取相关新闻
            if ($view['news']->keyword) {
                $where = 'n.category_id=1 AND n.keyword like "%' . $view['news']->keyword . '%" AND n.id != ' . $view['news']->id;
            } else {
                $where = 'n.category_id=1 AND n.id != ' . $view['news']->id;
            }
            $related_news_list = Yii::app()->db->createCommand()
                ->select('n.*, a.name as name')
                ->from('news as n')
                ->leftJoin('alumni as a', 'n.alumni_id=a.id')
                ->where($where)
                ->limit(10)
                ->order('rand()')
                ->queryAll();
            $view['related_news_list'] = $related_news_list;

            $this->render('view_nologin', $view);
        }
    }

    //后台输入新闻标题自动完成提示
    public function actionAutocomplete() {
        $this->layout = false;
        $q = Yii::app()->request->getParam('searchDbInforItem');
        $record = Yii::app()->db->createCommand()
            ->select('id as value,title as label')
            ->from('news')
            ->where('title like "%' . $q . '%"')
            ->order('id ASC')
            ->limit(30)
            ->queryAll();
        echo json_encode($record);
    }

    public function loadModel($id) {
        $model = News::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

}
