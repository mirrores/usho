<?php

class WeiboController extends Controller
{
	public function actionIndex()
	{            
            $record = array();
            $criteria = new CDbCriteria();
            $criteria->order = 'created_at DESC,comments_count DESC';
            if(isset($_REQUEST['id'])){
                $record = Weibo::model()->findByAttributes(array('weibo_sys_id'=>Yii::app()->request->getParam('id')));
                $record->pic_urls = unserialize($record->pic_urls);
                $criteria->addCondition('user_id = '.$record->user_id);
            }else{
                $criteria->addCondition('retweeted_status = 0');
                $criteria->addBetweenCondition('created_at',  date(time())-60*60*24*7,  date(time()));
            }
            $count = Weibo::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 20;
            $pages->applyLimit($criteria);
            $records = WeiboStatus::model()
                    ->findAll($criteria);
            
            foreach($records as $key=>$v){
                $records[$key]->pic_urls = unserialize($v->pic_urls);
                $records[$key]->text = preg_replace('/http:\/\/.*/', '<a href="'.substr($v->text,stripos($v->text,'http://')).'" target="_blank">'.substr($v->text,stripos($v->text,'http://')).'</a>',$v->text);
            }
            
            $this->render('index',array(
                'record' => $record,
                'records'=> $records,
                'pages' => $pages
            ));
	}
        
        public function actionCallback(){
            $o = new SaeTOAuthV2(Common::yiiparam('WB_AKEY') , Common::yiiparam('WB_SKEY') );
            if (isset($_REQUEST['code'])) {
                $keys = array();
                $keys['code'] = $_REQUEST['code'];
                $keys['redirect_uri'] = Common::yiiparam('WB_CALLBACK_URL');
                //try {
                    $token = $o->getAccessToken( 'code', $keys ) ;
                //}
            }

            if ($token) {
                setcookie('weibojs_'.$o->client_id, http_build_query($token));
                
                /** 等审核通过启用，不然受限
                $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token'] );
                $ms  = $c->home_timeline(); 
                $uid_get = $c->get_uid();
                $uid = $uid_get['uid'];
                $user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
                $token['name'] = $user_message['name'];
                $token['avatar_hd'] = $user_message['avatar_hd'];
                Yii::app()->session['weibouser'] = $token;
                //var_dump(Yii::app()->session['weibouser']);exit;
                //将用户TOKEN保存数据库
                $record = WeiboToken::model()->findAll("uid={$token['uid']}");
                if(!$record){
                    $model = new WeiboToken();
                    $model->uid = $token['uid'];
                    $model->name = $token['name'];
                    $model->access_token = $token['access_token'];
                    $model->remind_in = $token['remind_in'];
                    $model->expires_in = $token['expires_in'];
                    $model->save();
                }**/
                
                /** 等审核通过禁用 START*/
                Yii::app()->session['weibouser'] = $token;
                //将用户TOKEN保存数据库
                $record = WeiboToken::model()->findAll("uid={$token['uid']}");
                if(!$record){
                    $model = new WeiboToken();
                    $model->uid = $token['uid'];
                    $model->access_token = $token['access_token'];
                    $model->remind_in = $token['remind_in'];
                    $model->expires_in = $token['expires_in'];
                    $model->save();
                }
                /**END*/
                
                $this->redirect('/weibo/index');
                //echo('授权完成OK'.Yii::app()->session['token']);
            } else {
                echo('授权失败。NO');
            }
            exit('callback');
        }
        
        /**
         * URL示例 http://usho.cn/weibo/crontab/type/capture/sign/a82ls09re1dj63lsaz
         * 
         */
	public function actionCrontab(){
            $type = Yii::app()->request->getParam('type');
            $sign = Yii::app()->request->getParam('sign');
            
            if($sign != 'a82ls09re1dj63lsaz') Yii::app()->end('ERROR');
            switch($type){
                case 'capture':
                    $this->CrontabCapture();
                    Yii::app()->end('capture OK');
                    break;
                case 'repost':
                    $this->CrontabRepost();
                    Yii::app()->end('repost OK');
                    break;
            }
            
            
        }
        
        /**
         * 计划任务－自动抓取
         * 每次抓取 100条
         */
        public function CrontabCapture(){
            $c = new SaeTClientV2(Common::yiiparam('WB_AKEY'),  Common::yiiparam('WB_SKEY'),  Common::yiiparam('ACCESS_TOKEN'));
            $output = $c->friends_timeline(1,100);
            $output = $output['statuses'];
            
            $w = new WeiboGlobal();
            for($i=0;$i<count($output);$i++){
                if(in_array($output[$i]['user']['idstr'], $this->getAllAaumni()))//2014-06-13 增加过滤非后台绑定微博的功能
                    $w->addRecord($output,$i);
            }
        }
        
        /**
         * 统计并返回所有校友会微博ID,返回类型Array
         */
        public function getAllAaumni(){
            $criteria = new CDbCriteria();
            $criteria->select ='weibo';
            $criteria->addCondition("weibo!=0");
            $criteria->addCondition("weibo is NOT NULL");
            $records = Alumni::model()->findAll($criteria);
            $arr = array();
            foreach($records as $v){
                $arr[] = $v['weibo'];
            }
            
            return $arr;
        }

        /**
         * 计划任务－自动转发
         * 每次转发1条
         */
        public function CrontabRepost(){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->addCondition("repost_status=0");
            $criteria->addNotInCondition('user_id',array(Common::yiiparam('USHO_USER_ID')));
            $criteria->addCondition("retweeted_status=0"); //原创
            $criteria->order = 'comments_count DESC'; //评论数最多排序
            $criteria->limit = 1;
            $records = WeiboStatus::model()
                    ->findAll($criteria);
            if(!empty($records)){
                $w = new WeiboGlobal();
                $w->addRepost($records,0);
            }
        }
}