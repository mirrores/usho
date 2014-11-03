<?php

class TagsController extends AdminController {

    //内容首页
    public function actionIndex() {
        $keyword = Yii::app()->request->getParam('keyword');
        $len = Yii::app()->request->getParam('len');
        $attr = Yii::app()->request->getParam('attr');
        $attent = Yii::app()->request->getParam('attent');
        $criteria = new CDbCriteria();
        $criteria->select = 't.*,(select count(n.id) from news_tags n where n.tag_id=t.id) as tag_count';
        $criteria->alias = 't';
        $criteria->order = 'tag_count DESC';
        if ($keyword) {
            $_GET['keyword'] = $keyword;
            $criteria->condition = '( tag LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        } elseif ($len) {
            $criteria->condition = ' len =' . $len;
        } elseif ($attr) {
            $criteria->condition = ' attr ="' . $attr . '"';
        } elseif (!empty($attent)) {
            $criteria->condition = ' attent =' . $attent;
        }
        //dump($criteria);die;
        $count = Tags::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = Tags::model()->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword
        ));
    }
    
    public function actionChangeAttent(){
        $id = Yii::app()->request->getParam('id');
        $attent = Yii::app()->request->getParam('attent');
        
        $tags = Tags::model()->findByPk($id);
        if($tags){
            $tags->attent = $attent;
            $tags->save();
        }
    }

}
