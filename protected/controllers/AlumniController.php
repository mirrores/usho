<?php

class AlumniController extends Controller {

    //校友会导航首页
    public function actionIndex() {
        //最新加入到校友会
        $view['new_school_alumni'] = Yii::app()->db->createCommand()
            ->select('*')
            ->from('alumni')
            ->where('website !="" AND logo_path !=""')
            ->limit(4)
            ->order('id DESC')
            ->queryAll();

        $view['genre_list'] = Genre::model()->findAll(); //获取所有办学类型列表
        $view['nature_list'] = Nature::model()->findAll(); //获取所有性质类别列表
        $view['provinces_list'] = Provinces::model()->findAll(); //获取所有地区列表
        //获取参数
        $keyword = Yii::app()->request->getParam('keyword');
        $keyword=CHtml::encode($keyword);
        $view['keyword'] = $keyword;
        $nature_code = Yii::app()->request->getParam('nature_code');
        $view['nature_code'] = $nature_code;
        $genre_code = Yii::app()->request->getParam('genre_code');
        $view['genre_code'] = $genre_code;
        $provinces_id = Yii::app()->request->getParam('provinces_id');
        $view['provinces_id'] = $provinces_id;
        $page = Yii::app()->request->getParam('page') ? Yii::app()->request->getParam('page') : 1;
        $view['page'] = $page;

        //搜索的条件
        $where = 't.id != 1 AND t.id != 2042';
        if ($nature_code)
            $where.=' AND s.nature_code=' . $nature_code;
        if ($genre_code)
            $where.=' AND s.genre_code=' . $genre_code;
        if ($provinces_id)
            $where.=' AND s.provinces_id=' . $provinces_id;
        if ($keyword && $keyword != '关键字')
            $where.=' AND t.name LIKE "%' . $keyword . '%"';

        //设置查询条件
        $criteria = new CDbCriteria();
        //$criteria->order = 's.code ASC';
        $criteria->order = 't.month_rank DESC, t.website DESC';
        $criteria->select = '*';
        $criteria->join = 'LEFT JOIN school s ON s.id=t.school_id';
        $criteria->condition = $where;

        $count = Alumni::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 100;
        $pages->applyLimit($criteria);
        $records = Alumni::model()->findAll($criteria);

        $view['pages'] = $pages;
        $view['list'] = $records;
        $this->pageTitle = '校友会导航';
        $this->render('index', $view);
    }

    //后台输入学校名称自动完成提示
    public function actionAutocomplete() {
        $this->layout = false;
        $q = Yii::app()->request->getParam('searchDbInforItem');
        $record = Yii::app()->db->createCommand()
            ->select('id as value,name as label')
            ->from('alumni')
            ->where('name like "%' . $q . '%"')
            ->order('id ASC')
            ->limit(30)
            ->queryAll();
        echo json_encode($record);
    }

    public function actionView($id) {
        //$alumni = Alumni::model()->findByPk($id);
        $alumni = $this->loadModel($id);
        $view['alumni'] = $alumni;
        
        //如果该校友会有网址，即跳转到该网址
        if($alumni->website){
            $this->redirect($alumni->website);
        }
        
        $this->pageTitle = $alumni['name'];
        //判断用户是否登陆
        if (Yii::app()->user->id) {//已登录用户
            //我的学校新闻
            $uid = Yii::app()->user->id;
            $view['uid'] = $uid;

            $alumni_lists = UserMark::model()->findBySql('select alumni_id from user_mark where user_id=' . $uid . ' and alumni_id=' . $id);
            $view['alumni_lists'] = $alumni_lists;
            $my_school_news_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('alumni_id=' . $alumni['id'])
                ->limit(6)
                ->order('create_date DESC')
                ->queryAll();
            $view['my_school_news_list'] = $my_school_news_list;
            $my_school_event_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('event')
                ->where('alumni_id=' . $alumni['id'])
                ->limit(6)
                ->order('create_date DESC')
                ->queryAll();
            $view['my_school_event_list'] = $my_school_event_list;
            $this->render('view', $view);
        } else {//未登录用户
            //获取相关新闻
            $related_news_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('alumni_id=' . $alumni['id'])
                ->limit(6)
                ->order('create_date DESC')
                ->queryAll();
            $view['related_news_list'] = $related_news_list;

            $related_event_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('event')
                ->where('alumni_id=' . $alumni['id'])
                ->limit(6)
                ->order('create_date DESC')
                ->queryAll();
            $view['related_event_list'] = $related_event_list;
            $this->render('alumni_nologin', $view);
        }
    }

    public function actionMark($id) {
        if (!UserMark::model()->find('user_id=' . Yii::app()->user->id . ' AND alumni_id=' . $id)) {
            $comment = $_POST;
            $comment['user_id'] = Yii::app()->user->id;
            $comment['alumni_id'] = $id;
            $comment['create_date'] = date('Y-m-d H:i:s');
            
            $model = new UserMark();
            $model->attributes = $comment;
            $model->save();
        }
    }

    public function actionMarkDelete($id) {
        $model = UserMark::model()->find('user_id=' . Yii::app()->user->id . ' AND alumni_id=' . $id);
        if ($model === null)
            $this->notFound();
        $model->delete();
    }

    public function loadModel($id) {
        $model = Alumni::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

}
