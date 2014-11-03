<?php

class WeibostatusController extends AdminController
{
    public function actionIndex()
    {   
        $criteria = new CDbCriteria();
        $criteria ->with = 'weibostatuschild';
        $count = WeiboStatus::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);
        $records = WeiboStatus::model()
                ->findAll($criteria);
        
        $this->render('index',array(
            'records' => $records, 'pages' => $pages
        ));
    }

    public function actionDelete($id) {
        //$model = WeiboStatus::model()->findByPk($id)->delete();
        //临时处理，同时删除2表记录
        $sql = 'delete a,b from weibo_status a left join weibo_status_child b on a.weibo_sys_id=b.parent_weibo_sys_id where a.weibo_sys_id='.$id;
        Yii::app()->db->createCommand($sql)->execute();
        
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionCapture(){
        
        $this->render('capture',array(
        ));
    }
    
    /*
     * 一键转发微博
     */
    public function actionAjaxRepost(){
        $number = Yii::app()->request->getParam('number');
        $retweeted_status = Yii::app()->request->getParam('retweeted_status');
        $comments_count = Yii::app()->request->getParam('comments_count');
        $repost_start = strtotime(Yii::app()->request->getParam('repost_start'));
        $repost_end = strtotime(Yii::app()->request->getParam('repost_end'));
        
        if(isset(Yii::app()->session['repost_data'])){
            //销毁SESSION
            if(Yii::app()->session['repost_num'] >= $number || Yii::app()->session['repost_num'] >= Yii::app()->session['repost_data_count']){
                $cr = Yii::app()->session['repost_repetition'];
                unset(Yii::app()->session['repost_data_count']);
                unset(Yii::app()->session['repost_data']);
                unset(Yii::app()->session['repost_num']);
                unset(Yii::app()->session['repost_repetition']);
                Yii::app()->end('{"status":"finish","repetition":"'.$cr.'"}');
            }
            
            //第NUM条记录转发至微博
            $w = new WeiboGlobal();
            $w->addRepost(Yii::app()->session['repost_data'],Yii::app()->session['repost_num']);
            Yii::app()->session['repost_num'] += 1;
            Yii::app()->end('{"status":"underway","number":"'.Yii::app()->session['repost_num'].'"}');
        }else{
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->addCondition("repost_status=0");
            $criteria->addNotInCondition('user_id',array(Common::yiiparam('USHO_USER_ID')));
            $criteria->addBetweenCondition('created_at',$repost_start,$repost_end);
            !empty($retweeted_status)?$criteria->addCondition("retweeted_status=0"):'';
            !empty($comments_count)?$criteria->order = 'comments_count DESC':'';
            $criteria->limit = $number;
            $records = WeiboStatus::model()
                    ->findAll($criteria);
            
            if(empty($records)) Yii::app()->end('{"status":"finish","not_find":"yes"}');
            Yii::app()->session['repost_data_count'] = count($records);
            Yii::app()->session['repost_data'] = $records;
            Yii::app()->session['repost_num'] = 0;
            Yii::app()->session['repost_repetition'] = 0;

            Yii::app()->end('{"status":"repost-over"}');
        }
    }
    
    /*
     * 一键抓取微博
     */
    public function actionAjaxCapture(){
        $count = 50;//单页返回(抓取)的记录条数，最大不超过100

        if(isset(Yii::app()->session['capture_data'])){

            //销毁SESSION
            if(Yii::app()->session['capture_num'] >= $count-1){
                $cr = Yii::app()->session['capture_repetition'];
                unset(Yii::app()->session['capture_data']);
                unset(Yii::app()->session['capture_num']);
                unset(Yii::app()->session['capture_repetition']);
                Yii::app()->end('{"status":"finish","repetition":"'.$cr.'"}');
            }
            Yii::app()->session['capture_num'] += 1;

            //第NUM条记录写入数据库
            $w = new WeiboGlobal();
            $w->addRecord(Yii::app()->session['capture_data'],Yii::app()->session['capture_num']);
            Yii::app()->end('{"status":"underway","number":"'.Yii::app()->session['capture_num'].'"}');
        }else{

            $c = new SaeTClientV2(Common::yiiparam(WB_AKEY),  Common::yiiparam('WB_SKEY'),  Common::yiiparam('ACCESS_TOKEN'));
            $output = $c->friends_timeline(1,$count);
            Yii::app()->session['capture_data'] = $output['statuses'];
            Yii::app()->session['capture_num'] = 0;
            Yii::app()->session['capture_repetition'] = 0;

            Yii::app()->end('{"status":"capture-over"}');

        }
    }
}