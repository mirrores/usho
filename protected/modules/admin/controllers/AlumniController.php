<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AlumniController extends AdminController {

    function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $criteria = new CDbCriteria();
        $criteria->join = 'left join school as s on s.id=t.school_id left join provinces as p on p.id=s.provinces_id';
        if ($keyword) {
            $_GET['keyword'] = $keyword;
            $criteria->condition = '(t.name like :keyword or p.name like :keyword)';
            //$criteria->condition = '(t.name like :keyword or t.introduction like :keyword or p.name like :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        $count = Alumni::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = Alumni::model()->findAll($criteria);
        $this->render('index', array('records' => $records, 'pages' => $pages, 'keyword' => $keyword));
    }

    function actionCreate() {
        $model = new Alumni;
        if (isset($_POST['Alumni'])) {
            $model->attributes = $_POST['Alumni'];
            $model->create_date = date('Y-m-d H:i:s');
            $model->update_date = date('Y-m-d H:i:s');
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }
        $this->render('form', array('model' => $model));
    }

    function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Alumni'])) {
            
            /*START 2014-06-18 入加自动关注微博*/
            $wArr = Yii::app()->request->getParam('Alumni');
            if(!empty($wArr['weibo'])){
                $c = new SaeTClientV2(Common::yiiparam('WB_AKEY'), Common::yiiparam('WB_SKEY'), Common::yiiparam('ACCESS_TOKEN'));
                $c->follow_by_id($wArr['weibo']);
            }
            /*END*/
            
            $model->attributes = $_POST['Alumni'];
            $model->update_date = date('Y-m-d H:i:s');
            $model->save();
        }

        $this->render('form', array('model' => $model));
    }

    function actionDelete($id) {
        $this->loadModel($id)->delete();
        News::model()->deleteAll('alumni_id=' . $id);

        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    public function loadModel($id) {
        $model = Alumni::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'alumni-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionMonthRank() {
        //获取所有校友会ID
        $alumni_id_arr = Yii::app()->db->createCommand()
            ->select("id")
            ->from('alumni')
            ->where('website != "" or weibo > 0')
            ->queryColumn();
        $view['amount'] = count($alumni_id_arr);

        if (isset($_POST['month'])) {
            $month = trim($_POST['month']);
            $view['month'] = $month;
            $key = $_POST['key'];
            if (isset($alumni_id_arr[$key])) {
                $alumni_id = $alumni_id_arr[$key];

                $alumni = Alumni::model()->findByPk($alumni_id);
                if ($alumni) {
                    $alumni->month_news_count = News::model()->getMonthCount(array('alumni_id' => $alumni_id, 'month' => $month));
                    $alumni->news_count = News::model()->getAllCount(array('alumni_id' => $alumni_id));
                    $alumni->month_event_count = Event::model()->getMonthCount(array('alumni_id' => $alumni_id, 'month' => $month));
                    $alumni->event_count = Event::model()->getAllCount(array('alumni_id' => $alumni_id));

                    if ($alumni->weibo) {
                        $alumni->month_weibo_count = WeiboStatus::model()->getMonthCount(array('user_id' => $alumni->weibo, 'month' => $month));
                        $alumni->weibo_count = WeiboStatus::model()->getAllCount(array('user_id' => $alumni->weibo));
                    } else {
                        $alumni->month_weibo_count = 0;
                        $alumni->weibo_count = 0;
                    }

                    $alumni->month_rank = ($alumni->month_news_count * 10) + ($alumni->month_event_count * 10) + $alumni->month_weibo_count;
                    $alumni->save();

                    $month_rank_record = MonthRankRecord::model()->findBySql('select * from month_rank_record where alumni_id=' . $alumni->id . ' and month="' . $month . '"');

                    if (!$month_rank_record) {
                        $month_rank_record = new MonthRankRecord();
                        $month_rank_record->create_date = date('Y-m-d H:m:s');
                    }else{
                        $month_rank_record->update_date = date('Y-m-d H:m:s');
                    }
                    $month_rank_record->alumni_id = $alumni->id;
                    $month_rank_record->month = $month;
                    $month_rank_record->month_news_count = $alumni->month_news_count;
                    $month_rank_record->news_count = $alumni->news_count;
                    $month_rank_record->month_event_count = $alumni->month_event_count;
                    $month_rank_record->event_count = $alumni->event_count;
                    $month_rank_record->month_weibo_count = $alumni->month_weibo_count;
                    $month_rank_record->weibo_count = $alumni->weibo_count;
                    $month_rank_record->month_rank = $alumni->month_rank;
                    $month_rank_record->save();

                    $view['alumni'] = $alumni;
                }
                $key++;
                $view['key'] = $key;
            } else {
                $view['finish'] = 1;
            }
        }
        $this->render('month_rank', $view);
    }

    public function actionBaiduIndex($id = 1, $max_id = 0, $start = 0) {
        $view['id'] = $id;
        $view['max_id'] = $max_id;
        $view['start'] = $start;
        if ($start && $max_id) {
            if ($id <= $max_id) {
                $result = Alumni::model()->findByPk($id);
                if (!empty($result)) {
                    $website = $result->website;

                    if (empty($website)) {
                        $result->baidu_index = 0;
                        $result->last_collection_date = "1970-01-01";
                        $result->save();
                    } else {
                        if (substr($website, 0, 7) == 'http://') {
                            $website = substr($website, 7);
                            $explode1 = explode('/', $website);
                            $explode2 = explode(':', $explode1[0]);
                            $website = $explode2[0];
                        } else {
                            $explode1 = explode('/', $website);
                            $explode2 = explode(':', $explode1[0]);
                            $website = $explode2[0];
                        }

                        $site_url = "http://www.baidu.com/s?wd=site%3A" . $website;
                        $utf_pattern = "/找到相关结果数(.*)个/";
                        $kz_pattern = "/<span class=\"g\">(.*)<\/span>/";
                        $times = "/\d{4}-\d{1,2}-\d{1,2}/";
                        $baidu = file_get_contents($site_url);

                        preg_match($utf_pattern, $baidu, $all_num);
                        preg_match($kz_pattern, $baidu, $temp);
                        if (empty($temp))
                            $temp[0] = '';
                        preg_match($times, $temp[0], $screenshot);

                        if (!isset($all_num[1]) || $all_num[1] == "")
                            $all_num[1] = 0;
                        if (!isset($screenshot[0]) || $screenshot[0] == "")
                            $screenshot[0] = "1970-01-01";

                        $result->baidu_index = str_replace(",", "", $all_num[1]);
                        $result->last_collection_date = $screenshot[0];
                        $result->save();
                    }

                    $view['alumni'] = $result;
                }else {
                    $view['alumni'] = array('id' => $id, 'name' => '', 'website' => '', 'baidu_index' => '', 'last_collection_date' => '');
                }
                $this->render('baidu', $view);
            } else {
                $view['start'] = 0;
                $view['finish'] = 1;
                $this->render('baidu', $view);
            }
        } else {
            $view['max_id'] = Yii::app()->db->createCommand()
                ->select('MAX(id)')
                ->from('alumni')
                ->queryScalar();

            $view['finish'] = 0;
            $this->render('baidu', $view);
        }
    }

}
