<?php

class UserTraceController extends AdminController {

    /**
     * Lists all models.
     */
    //用户浏览记录
    public function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->select = ' t.*';
        $criteria->join = 'left join user as u on u.id=t.user_id left join alumni as a on a.id=u.alumni_id ';
        if ($keyword) {
            $_GET['keyword'] = $keyword;
            $criteria->condition = '(u.name like :keyword or a.name like :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $criteria->order = 'create_date DESC';
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()
                ->findAll($criteria);


        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword
        ));
    }

    //新闻统计
    public function actionCountNews() {
        $type = Yii::app()->request->getParam('type');
        $_GET['type'] = $type;
        $criteria = new CDbCriteria();
        if ($type == 0) {
            $keyword = Yii::app()->request->getParam('keyword');
            $_GET['keyword'] = $keyword;
            $criteria->select = 't.*';
            $criteria->join = 'LEFT JOIN news as n ON n.id=t.data_id';
            if ($keyword == 0) {
                $criteria->condition = '(To_DAYS(t.create_date)=TO_DAYS(now()))';
                $criteria->params = array(':keyword' => $keyword);
            } else {
                $criteria->condition = '(TO_DAYS(now())-To_DAYS(t.create_date)<=:keyword)';
                $criteria->params = array(':keyword' => $keyword);
            }
            $criteria->addCondition('t.controller="news" and t.action="view"');
            $criteria->group = 'n.title';
            $criteria->having = 'count(n.title)>0';
            $criteria->order = 'count(n.title) DESC';
        } else {
            $criteria->select = 't.*';
            $criteria->join = 'LEFT JOIN news as n ON n.id=t.data_id';
            $criteria->addCondition('t.controller="news" and t.action="view"');
            $criteria->group = 'n.title';
            $criteria->having = 'count(n.title)>0';
            $criteria->order = 'count(n.title) DESC';
        }
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countnews', array('records' => $records, 'pages' => $pages));
    }

    //活动统计
    public function actionCountEvent() {
        $type = Yii::app()->request->getParam('type');
        $_GET['type'] = $type;
        $criteria = new CDbCriteria();
        if ($type == 0) {
            $keyword = Yii::app()->request->getParam('keyword');
            $_GET['keyword'] = $keyword;
            $criteria->select = 'e.title,t.*';
            $criteria->join = 'LEFT JOIN event as e ON e.id=t.data_id';
            if ($keyword == 0) {
                $criteria->condition = '(To_DAYS(t.create_date)=TO_DAYS(now()))';
                $criteria->params = array(':keyword' => $keyword);
            } else {
                $criteria->condition = '(TO_DAYS(now())-To_DAYS(t.create_date)<=:keyword)';
                $criteria->params = array(':keyword' => $keyword);
            }
            $criteria->addCondition('t.controller="event" and t.action="view"');
            $criteria->group = 'e.title';
            $criteria->order = 't.create_date DESC';
        } else {
            $criteria->select = 'e.title,t.*';
            $criteria->join = 'LEFT JOIN event as e ON e.id=t.data_id';
            $criteria->addCondition('t.controller="event" and t.action="view"');
            $criteria->group = 'e.title';
            $criteria->order = 't.create_date DESC';
        }
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countevent', array('records' => $records, 'pages' => $pages));
    }

    //用户统计
    public function actionCountUser() {
        $type = Yii::app()->request->getParam('type');
        $_GET['type'] = $type;
        $criteria = new CDbCriteria();
        if ($type == 0) {
            $keyword = Yii::app()->request->getParam('keyword');
            $_GET['keyword'] = $keyword;
            $criteria->select = ' us.name as name,t.user_id,count(us.name) as zs,max(t.create_date) as create_date,us.position';
            $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id';
            if ($keyword == 0) {
                $criteria->condition = '(To_DAYS(t.create_date)=TO_DAYS(now()))';
                $criteria->params = array(':keyword' => $keyword);
            } else {
                $criteria->condition = '(TO_DAYS(now())-To_DAYS(t.create_date)<=:keyword)';
                $criteria->params = array(':keyword' => $keyword);
            }
            $criteria->group = 't.user_id';
            $criteria->order = 'max(t.create_date) DESC';
        } else {
            $criteria->select = 'us.name as name,t.user_id,count(us.name) as zs,max(t.create_date) as create_date,us.position';
            $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id';
            $criteria->group = 't.user_id';
            $criteria->order = 'count(us.name) DESC';
        }
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);

        $this->render('countuser', array('records' => $records, 'pages' => $pages));
    }

    //模块统计
    public function actionCountModel() {

        $criteria = new CDbCriteria();
        $criteria->select = 't.controller,t.action,count(t.action) as id';
        $criteria->group = 't.action,t.controller';
        $criteria->having = 'count(t.action)>0';
        $criteria->order = 'count(t.action) DESC';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countmodel', array('records' => $records, 'pages' => $pages));
    }

    //校友会统计
    public function actionCountAlumni() {
        $type = Yii::app()->request->getParam('type');
        $_GET['type'] = $type;
        $criteria = new CDbCriteria();
        if ($type == 0) {
            $keyword = Yii::app()->request->getParam('keyword');
            $_GET['keyword'] = $keyword;
            $criteria->select = ' a.name as name,t.user_id,a.id,count(a.name) as zs,max(t.create_date) as create_date,us.position';
            $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id  LEFT JOIN alumni as a on a.id=us.alumni_id';
            if ($keyword == 0) {
                $criteria->condition = '(To_DAYS(t.create_date)=TO_DAYS(now()))';
                $criteria->params = array(':keyword' => $keyword);
            } else {
                $criteria->condition = '(TO_DAYS(now())-To_DAYS(t.create_date)<=:keyword)';
                $criteria->params = array(':keyword' => $keyword);
            }
            $criteria->group = 'a.id';
            $criteria->having = 'count(a.name)>0';
            $criteria->order = 'max(t.create_date) DESC';
        } else {
            $criteria->select = ' a.name as name,t.user_id,a.id,count(a.name) as zs,max(t.create_date) as create_date,us.position';
            $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id  LEFT JOIN alumni as a on a.id=us.alumni_id';
            $criteria->group = 'a.id';
            $criteria->having = 'count(a.name)>0';
            $criteria->order = 'count(a.name) DESC';
        }
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countalumni', array('records' => $records, 'pages' => $pages));
    }

    //有话说统计
    public function actionCountTalk() {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->join = 'LEFT JOIN talk as ta ON ta.id=t.data_id';
        $criteria->condition = 't.controller="talk" and t.action="view"';
        $criteria->group = 'ta.title';
        $criteria->having = 'count(ta.title)>0';
        $criteria->order = 't.create_date DESC';
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('counttalk', array('records' => $records, 'pages' => $pages));
    }

    //搜索统计
    public function actionCountSearch() {
        $criteria = new CDbCriteria();
        $criteria->select = ' t.keyword ,count(t.keyword) as id ,MAX(t.create_date) as create_date';
        $criteria->group = 't.keyword';
        $criteria->having = 'count(t.keyword)>0';
        $criteria->order = 'MAX(t.create_date) DESC';
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countsearch', array('records' => $records, 'pages' => $pages));
    }
    
    public function actionEmail(){
        $criteria=new CDbCriteria();
        $criteria->select=' count(DISTINCT user_id) as id,m.issue as monthly_id,m.created_at as create_date';
        $criteria->join='left join usho_mail as m on m.id=t.monthly_id';
        $criteria->group='monthly_id';
        $criteria->order='monthly_id desc';
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('email', array('records' => $records, 'pages' => $pages));
    }
    
    public function actionRight(){
      $this->layout = false;
       $record = Yii::app()->db->createCommand()
            ->select('id,issue')
             ->from('usho_mail')
            ->order('id ASC')
            ->query();

        $xAixs = [];
        $data = [];
        foreach ($record as $area) {
            if ($area['id'] == '-1') {
                continue;
            }
            $xAixs[] = $area['id'];
            $data[] = $area['issue'];
        }
        $script = ' global.graph = '.json_encode(['xAixs'=>$xAixs, 'data'=>$data]);
        Yii::app()->getClientScript()->registerScript('data', $script, CClientScript::POS_BEGIN);
        $this->render('right');
    }

    //月报统计
    public function actionCountMonthly() {
        $type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : "news";
        $_GET['type'] = $type;
        $criteria = new CDbCriteria();
        if ($type == "news") {
            $criteria->select = 'n.title,t.*,count(n.title) as zs';
            $criteria->join = 'LEFT JOIN news as n ON n.id=t.data_id';
            $criteria->addCondition('t.controller="news"and monthly_id=(select max(id) from monthly)');
            $criteria->group = 'n.title';
            $criteria->having = 'count(n.title)>0';
            $criteria->order = 'COUNT(n.title) DESC';
        } else {
            $criteria->select = 'e.title,t.*,count(e.title) as zs';
            $criteria->join = 'LEFT JOIN event as e ON e.id=t.data_id';
            $criteria->addCondition('t.monthly_id=(select max(id) from monthly) and t.controller="event"');
            $criteria->group = 'e.title';
            $criteria->having = 'count(e.title)>0';
            $criteria->order = 'COUNT(e.title) DESC';
        }
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countmonthly', array('records' => $records, 'pages' => $pages));
    }

    //每日,每周，每月，每年统计
    public function actionMonthlyDay() {
        $type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : "day";
        $_GET['type'] = $type;
        $criteria = new CDbCriteria();
        if ($type == "day") {
            $criteria->select = 'count(user_id)as user_id,DATE_FORMAT(create_date, "%Y%m%d") as create_date';
            $criteria->group = 'DATE_FORMAT(create_date, "%Y%m%d")';
            $criteria->order = 'DATE_FORMAT(create_date, "%Y%m%d") DESC';
        } elseif ($type == "week") {
            $criteria->select = 'count(user_id) as user_id,week(create_date) as create_date';
            $criteria->addCondition('year(create_date)=DATE_FORMAT(create_date, "%Y")');
            $criteria->group = 'week(create_date)';
            $criteria->order = 'week(create_date) DESC';
        } elseif ($type == "month") {
            $criteria->select = 'count(user_id) as user_id,DATE_FORMAT(create_date, "%Y%m") as create_date';
            $criteria->group = 'DATE_FORMAT(create_date, "%Y%m")';
            $criteria->order = 'DATE_FORMAT(create_date, "%Y%m") DESC';
        } else {
            $criteria->select = 'count(user_id) as user_id,DATE_FORMAT(create_date, "%Y") as create_date';
            $criteria->group = 'DATE_FORMAT(create_date, "%Y")';
            $criteria->order = 'DATE_FORMAT(create_date, "%Y") DESC';
        }
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('countmonthlyday', array('records' => $records, 'pages' => $pages));
    }

    //新闻详细统计
    public function actionNewsShow() {
        $data_id = Yii::app()->request->getParam('id');
        $criteria = new CDbCriteria();
        $criteria->select = 't.*,u.name';
        $criteria->join = 'left join user as u on t.user_id=u.id left join alumni as a on u.alumni_id=a.id LEFT JOIN school as s on s.id=a.school_id LEFT JOIN provinces as p on p.id=s.provinces_id';
        $criteria->addCondition('t.data_id=' . $data_id);
        $criteria->group = 'u.name';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);

        $this->render('newsshow', array('records' => $records, 'pages' => $pages));
    }

    //活动详细统计
    public function actionEventShow() {
        $data_id = Yii::app()->request->getParam('id');
        $criteria = new CDbCriteria();
        $criteria->select = ' t.*,u.name';
        $criteria->join = 'left join user as u on t.user_id=u.id left join alumni as a on u.alumni_id=a.id LEFT JOIN school as s on s.id=a.school_id LEFT JOIN provinces as p on p.id=s.provinces_id';
        $criteria->addCondition('t.data_id=' . $data_id);
        $criteria->group = 'u.name';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('eventshow', array('records' => $records, 'pages' => $pages));
    }

    //有话说详细统计
    public function actionTalkShow() {
        $data_id = Yii::app()->request->getParam('id');
        $criteria = new CDbCriteria();
        $criteria->select = ' t.*,u.name';
        $criteria->join = 'left join user as u on t.user_id=u.id left join alumni as a on u.alumni_id=a.id LEFT JOIN school as s on s.id=a.school_id LEFT JOIN provinces as p on p.id=s.provinces_id';
        $criteria->addCondition('t.data_id=' . $data_id);
        $criteria->group = 'u.name';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('talkshow', array('records' => $records, 'pages' => $pages));
    }

    //用户详细统计
    public function actionUserShow() {
        $user_id = Yii::app()->request->getParam('id');
        $criteria = new CDbCriteria();
        $criteria->select = ' t.*,u.name';
        $criteria->join = 'left join user as u on t.user_id=u.id left join alumni as a on u.alumni_id=a.id LEFT JOIN news as n on n.id=t.data_id LEFT JOIN event as e on e.id=t.data_id left join talk as ta on ta.id=t.data_id ';
        $criteria->addCondition('t.user_id=' . $user_id);
        $criteria->order = 'create_date desc';
        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('usershow', array('records' => $records, 'pages' => $pages));
    }

    //活跃用户
    public function actionActiveUser() {
        $criteria = new CDbCriteria();
        $criteria->select = ' us.name as name,t.user_id,count(us.name) as zs,max(t.create_date) as create_date,us.position,COUNT(t.data_id)';
        $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id';
        $criteria->condition = 't.monthly_id=(select Max(id) from monthly)';
        $criteria->group = 'us.name';
        $criteria->having = 'count(t.data_id)>=5 and COUNT(t.user_id)>=10';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('activeuser', array('records' => $records, 'pages' => $pages));
    }

    //新用户中的流失用户
    public function actionNewUserLost() {
        $criteria = new CDbCriteria();
        $criteria->select = ' us.name as name,t.user_id,us.position,a.name as alumni_id';
        $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id LEFT JOIN alumni as a ON a.id=us.alumni_id';
        $criteria->condition = 't.user_id not in(select user_id from user_trace where monthly_id=(select max(id) from monthly)) and monthly_id=(select max(id)-1 from monthly)';
        $criteria->group = 'us.name';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('newuserlost', array('records' => $records, 'pages' => $pages));
    }

    //老用户
    public function actionOldUser() {
        $criteria = new CDbCriteria();
        $criteria->select = ' us.name as name,t.user_id,us.position,a.name as alumni_id,us.tel';
        $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id LEFT JOIN alumni as a ON a.id=us.alumni_id';
        $criteria->condition = 't.user_id in(select user_id from user_trace where monthly_id=(select max(id)-1 from monthly)) and monthly_id=(select max(id) from monthly)';
        $criteria->group = 'us.name';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('olduser', array('records' => $records, 'pages' => $pages));
    }

    //新用户
    public function actionNewUser() {
        $criteria = new CDbCriteria();
        $criteria->select = ' us.name as name,t.user_id,us.position,a.name as alumni_id,us.tel';
        $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id LEFT JOIN alumni as a ON a.id=us.alumni_id';
        $criteria->condition = 't.user_id not in(select user_id from user_trace where monthly_id=(select max(id)-1 from monthly)) and monthly_id=(select max(id) from monthly)';
        $criteria->group = 'us.name';

        $count = UserTrace::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = UserTrace::model()->findAll($criteria);
        $this->render('newuser', array('records' => $records, 'pages' => $pages));
    }

    //老用户中的流失用户
    public function actionOldUserLost() {
//        $criteria = new CDbCriteria();
//
//        $criteria->select = ' us.name as name,t.user_id,us.position,a.name as alumni_id';
//        $criteria->join = 'LEFT JOIN user as us ON us.id=t.user_id LEFT JOIN alumni as a ON a.id=us.alumni_id';
//        //$criteria->condition = 't.user_id not in(select user_id from user_trace where monthly_id=(select max(id) from monthly) and monthly_id=(select max(id)-1 from monthly) group by user_id) and monthly_id=(select max(id)-2 from monthly) and monthly_id=(select max(id)-3 from monthly)';
//        $criteria->addCondition('user_id in(select user_id from user_trace where monthly_id=(select max(id)-3 from monthly) GROUP BY user_id)
//and monthly_id=(select max(id)-2 from monthly) GROUP BY user_id
//not in(select user_id from user_trace where user_id in (select user_id from user_trace where monthly_id=(select max(id) from monthly) GROUP BY user_id)
//and monthly_id=(select max(id)-1 from monthly) GROUP BY user_id)'); 
//         //$criteria->group='t.user.id';
//
//        $count = UserTrace::model()->count($criteria);
//        $pages = new CPagination($count);
//        $pages->pageSize = 20;
//        $pages->applyLimit($criteria);
//        $records = UserTrace::model()->findAll($criteria);
        $this->render('olduserlost');
    }

    public function actionDiagram() {
        $this->render('countpic');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new UserTrace;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UserTrace'])) {
            $model->attributes = $_POST['UserTrace'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UserTrace'])) {
            $model->attributes = $_POST['UserTrace'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new UserTrace('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserTrace']))
            $model->attributes = $_GET['UserTrace'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserTrace the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserTrace::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserTrace $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-trace-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
