<?php

class NewsController extends AdminController {

    //内容首页
    public function actionIndex() {
        $alumni_id = Yii::app()->request->getParam('alumni_id');
        $keyword = Yii::app()->request->getParam('keyword');
        $tag_id = Yii::app()->request->getParam('tag_id');
        $criteria = new CDbCriteria();
        $criteria->alias = 'n';
        $criteria->order = 'n.create_date DESC';
        if ($alumni_id) {
            $criteria->condition = '( n.alumni_id =:alumni_id)';
            $criteria->params = array(':alumni_id' => $alumni_id);
        }
        if ($keyword) {
            $_GET['keyword'] = $keyword;
            $criteria->join = 'LEFT JOIN alumni a ON a.id=n.alumni_id';
            $criteria->condition = '( n.title LIKE :keyword OR a.name LIKE :keyword)';
            $criteria->params = array(':keyword' => '%' . trim($keyword) . '%');
        }
        if ($tag_id) {
            $_GET['tag_id'] = $tag_id;
            $criteria->join = 'LEFT JOIN news_tags tg ON tg.news_id=n.id';
            $criteria->condition = 'tg.tag_id=:tag_id';
            $criteria->params = array(':tag_id' =>$tag_id);

        }
        $count = News::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = News::model()
            ->findAll($criteria);

        $this->render('index', array(
            'records' => $records, 'pages' => $pages, 'keyword' => $keyword
        ));
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
     * 添加内容
     * @access public
     * @param integer $sid 学校id
     * @example
     */
    public function actionCreate($sid = null) {
        $model = new News;
        $model->alumni_id = $sid;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            //$model->create_date = date('Y-m-d H:i:s');
            if ($model->save()){
                $this->createTag($model->id, $model->title);
                $this->redirect(array('index', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    //修改内容
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            $model->update_date = date('Y-m-d H:i:s');
            if ($model->save()){
                NewsTags::model()->deleteAll('news_id='.$id);
                $this->createTag($model->id, $model->title);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('form', array(
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
        NewsTags::model()->deleteAll('news_id=' . $id);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'keyword' => Yii::app()->request->getParam('keyword')));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = News::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param News $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //所有信息进行分词
    public function actionDoAll() {
        $id = Yii::app()->request->getParam('id');
        if (empty($id)) {
            $id = Yii::app()->db->createCommand()
                ->select('id')
                ->from('news')
                ->order('id DESC')
                ->limit(1)
                ->queryScalar();
        }
        $title = Yii::app()->db->createCommand()
            ->select('title')
            ->from('news')
            ->where('id=' . $id)
            ->queryScalar();
        $view['title'] = $title;
        //dump($title);die;
        if (!empty($title)) {
            //开始分词
            $so = scws_new();
            $so->set_charset('utf8');
            //忽略标点符号
            $so->set_ignore(true);
            //设定是否将闲散文字自动以二字分词法聚合
            $so->set_duality(true);
            $so->set_multi(0);
            //返回一系列切好的词汇
            $so->send_text($title);
            while ($tmp = $so->get_result()) {
                if (!empty($tmp)) {
                    foreach ($tmp as $value) {
                        if ($value['len'] > 3) {
                            $tags = Tags::model()->find('tag="' . $value['word'] . '"');
                            if (empty($tags)) {
                                $tags = new Tags();
                                $tags->tag = $value['word'];
                                $tags->len = $value['len'];
                                $tags->attr = $value['attr'];
                                $tags->save();
                                //dump($value['word']);
                            }
                            $news_tags = NewsTags::model()->find('news_id=' . $id . ' and tag_id=' . $tags->id);
                            if (empty($news_tags)) {
                                $news_tags = new NewsTags();
                                $news_tags->news_id = $id;
                                $news_tags->tag_id = $tags->id;
                                $news_tags->save();
                            }
                        }
                    }
                }
            }
            //关闭释放资源，使用结束后可以手工调用该函数或等系统自动回收
            $so->close();
        }
        //dump($id);die;
        if ($id > 1) {
            $view['id'] = $id - 1;
        } else {
            $view['finish'] = 1;
        }
        
        $this->render('tags', $view);
    }

}
