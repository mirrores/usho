<?php

class MonthlyController extends Controller {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //设置查询条件
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->select = '*';

        $count = Monthly::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 12;
        $pages->applyLimit($criteria);
        $records = Monthly::model()->findAll($criteria);

        $view['list'] = $records;
        $view['pages'] = $pages;
        $this->pageTitle = '友笑周报';
        $this->render('index', $view);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $monthly_info = $this->loadModel($id);
        if (!$monthly_info->template_id) {
            $this->notFound();
        }
        
        $template = MonthlyTemplate::model()->findByPk($monthly_info->template_id);
        if(!$template){
            $this->notFound();
        }
        
        $view['name'] = $monthly_info->name;
        $view['template'] = $template;
        $this->render('view', $view);
    }

    public function loadModel($id) {
        $model = Monthly::model()->findByPk($id);
        if ($model === null)
            $this->notFound();
        return $model;
    }

}
