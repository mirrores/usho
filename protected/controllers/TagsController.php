<?php

//标签
class TagsController extends Controller {

    public function actionIndex() {

        $criteria = new CDbCriteria();
        
        //查找包含“校庆”tag的新闻
        $criteria->join = "LEFT JOIN news_tags on news_tags.news_id=t.id LEFT JOIN tags on tags.id=news_tags.tag_id";
        //如果"校庆"tag id
        $criteria->condition = "news_tags.tag_id=6";
        //不知道"校庆" tag id
        //$criteria->condition = "tags.tag='校庆'";
        //end
        
        $count = News::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $records = News::model()
                ->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages
        ));

    }

}
