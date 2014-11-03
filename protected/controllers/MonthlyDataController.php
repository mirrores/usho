<?php

class MonthlyDataController extends Controller {
    
    public function actionIndex() {
        
    }

    //查看月报文章详细
    public function actionView($id) {
        //获取月报文章详细,更新新闻点击数
        $result = $this->loadModel($id);
        $result->hit_num = $result->hit_num + 1;
        $view['data'] = $result;
        $result->save();

        //判断用户是否登陆
        if (Yii::app()->user->id) {//已登录用户
            $user_info = User::model()->findByPk(Yii::app()->user->id); //用户信息
            $alumni_info = Alumni::model()->findByPk($user_info->alumni_id); //用户所属校友会信息
            $view['alumni_info'] = $alumni_info;
            $school_info = School::model()->findByPk($alumni_info->school_id); //用户所属学校信息
            $view['school_info'] = $school_info;

            //获取在所有校友会中的排名
            $ranknum_in_all = Yii::app()->db->createCommand()
                ->select("count(*)")
                ->from('alumni')
                ->where('month_news_count>' . $alumni_info->month_news_count . ' or (month_news_count=' . $alumni_info->month_news_count . ' and baidu_index>' . $alumni_info->baidu_index . ')')
                ->queryScalar();
            $view['ranknum_in_all'] = $ranknum_in_all;

            $all_alumni_list = Yii::app()->db->createCommand('select id,name from alumni order by month_news_count DESC,baidu_index DESC')->queryAll();
            $view['all_alumni_list'] = $all_alumni_list;

            //获取在所有同类校友会中的排名
            $kind_all = CHtml::listData(School::model()->findAll('nature_code=' . $school_info->nature_code), 'id', 'id');
            $ranknum_in_kind = Yii::app()->db->createCommand()
                ->select("count(*)")
                ->from('alumni')
                ->where('school_id in (' . implode(',', $kind_all) . ') and (month_news_count>' . $alumni_info->month_news_count . ' or (month_news_count=' . $alumni_info->month_news_count . ' and news_count>' . $alumni_info->news_count . '))')
                ->queryScalar();
            $view['ranknum_in_kind'] = $ranknum_in_kind;

            $kind_alumni_list = Yii::app()->db->createCommand('select id,name from alumni where school_id in (' . implode(',', $kind_all) . ') order by month_news_count DESC,news_count DESC')->queryAll();
            $view['kind_alumni_list'] = $kind_alumni_list;

            //获取在同省份所有校友会中的排名
            $city_all = CHtml::listData(School::model()->findAll('provinces_id=' . $school_info->provinces_id), 'id', 'id');
            $ranknum_in_city = Yii::app()->db->createCommand()
                ->select("count(*)")
                ->from('alumni')
                ->where('school_id in (' . implode(',', $city_all) . ') and (month_news_count>' . $alumni_info->month_news_count . ' or (month_news_count=' . $alumni_info->month_news_count . ' and baidu_index>' . $alumni_info->baidu_index . '))')
                ->queryScalar();
            $view['ranknum_in_city'] = $ranknum_in_city;

            $city_alumni_list = Yii::app()->db->createCommand('select id,name from alumni where school_id in (' . implode(',', $city_all) . ') order by month_news_count DESC,baidu_index DESC')->queryAll();
            $view['city_alumni_list'] = $city_alumni_list;

            //我校校友会新闻
            $my_school_news_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('news')
                ->where('category_id=1 AND alumni_id = ' . $user_info->alumni_id)
                ->limit(6)
                ->order('id DESC')
                ->queryAll();
            $view['my_school_news_list'] = $my_school_news_list;

            //我关注的校友会的新闻
            $my_mark_alumnis = Yii::app()->db->createCommand()
                ->select('alumni_id')
                ->from('user_mark')
                ->where('user_id = ' . Yii::app()->user->id)
                ->queryColumn();
            $view['my_mark_alumnis'] = implode(',', $my_mark_alumnis);
            if ($my_mark_alumnis) {
                $my_mark_school_news_list = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('news')
                    ->where('category_id=1 AND alumni_id IN (' . implode(',', $my_mark_alumnis) . ')')
                    ->limit(6)
                    ->order('id DESC')
                    ->queryAll();
            } else {
                $my_mark_school_news_list = '';
            }
            $view['my_mark_school_news_list'] = $my_mark_school_news_list;

            //同城校友会新闻
            $city_alumni_list_ids = CHtml::listData($city_alumni_list, 'id', 'id');
            unset($city_alumni_list_ids[$user_info->alumni_id]);
            $view['city_alumni_list_ids'] = implode(',', $city_alumni_list_ids);
            if ($city_alumni_list_ids) {
                $city_news_list = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('news')
                    ->where('category_id=1 AND alumni_id IN (' . implode(',', $city_alumni_list_ids) . ')')
                    ->limit(6)
                    ->order('id DESC')
                    ->queryAll();
            } else {
                $city_news_list = '';
            }
            $view['city_news_list'] = $city_news_list;

            $this->render('data_view_loginer', $view);
        } else {//未登录用户
            //获取栏目下其他新闻
            $related_news_list = Yii::app()->db->createCommand()
                ->select('*')
                ->from('monthly_data')
                ->where('column_id ='.$view['data']->column_id.' AND id != ' . $view['data']->id)
                ->limit(10)
                ->order('id DESC')
                ->queryAll();
            $view['related_news_list'] = $related_news_list;

            $this->render('data_view_nologin', $view);
        }
    }
    
    public function loadModel($id) {
        $model = MonthlyData::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

}
