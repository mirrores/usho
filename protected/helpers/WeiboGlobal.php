<?php

class WeiboGlobal {

	private $pic_urls_arr = array();//微博配图地址。多图时返回多图链接。
        
        /**
         * 转发微博
         * @param type $source 数据源
         * @param type $num 下标
         */
	public function addRepost($source,$num){
        $source = $source[$num];
        $where = "idstr = '{$source['idstr']}' AND repost_status = 1";
        $fiend = WeiboStatus::model()->count($where);

        if(!$fiend){
        	$c = new SaeTClientV2(Common::yiiparam('WB_AKEY'),  Common::yiiparam('WB_SKEY'),  Common::yiiparam('ACCESS_TOKEN'));
	        $c->repost($source['idstr']);
                //转发异常暂不处理-短时间内不允许重复，已在表中排除

	        $model = WeiboStatus::model()->findByPk (array (
	        		'weibo_sys_id' => $source['weibo_sys_id'],
                                'idstr' => $source['idstr'] 
                        ));
	        $model->repost_status=1;
	        $model->update();
        }
    }

     /**
     * 抓取微博增加进库
     * @param type $source 来源
     * @param type $num 记录下标
     * @param type $auto 二种抓取方式，1自动，0一键
     */
    public function addRecord($source,$num,$auto=0){
        $obj = $source[$num];
        $where = "idstr = '{$obj['idstr']}'";
        $fiend = WeiboStatus::model()->count($where);

        if($fiend || $obj['user']['id']==  Common::yiiparam('USHO_USER_ID')){//存在重复OR属于友笑
            if(!$auto) Yii::app()->session['capture_repetition'] += 1;
        }else{
            if(isset($obj['retweeted_status'])){//如果是转发数据，则获取源微博数据
                $this->insertRecord($obj,1);
            }else{
                $this->insertRecord($obj);
            }
        } 
    }

    /**
     * INSERT执行过程
     * @param type $obj
     * @param type $retweeted_reprint 是否有转载数据1有，0无
     * @param type $parent 父ID
     */
    public function insertRecord($obj,$retweeted_reprint = 0,$parent = null){
        
        if(!empty($parent)){
            $model = new WeiboStatusChild;
            $model->parent_weibo_sys_id = $parent;
        }else{
            $model = new WeiboStatus;
        }
        
        $model->user_id = $obj['user']['id'];
        $model->screen_name = $obj['user']['screen_name'];
        $model->retweeted_status = $retweeted_reprint;
        $model->url = $obj['user']['url'];
        $model->created_at = strtotime($obj['created_at']);
        $model->id = $obj['id'];
        $model->mid = $obj['mid'];
        $model->idstr = $obj['idstr'];
        $model->text = $obj['text'];
        $model->source = $obj['source'];
        $model->favorited = $obj['favorited']?1:0;
        $model->truncated = $obj['truncated']?1:0;
        $model->reposts_count = $obj['reposts_count'];
        $model->comments_count = $obj['comments_count'];
        $model->attitudes_count = $obj['attitudes_count'];
        //$model->pic_urls = $obj['pic_urls']?serialize($this->returnPicUrls($obj['pic_urls'])):NULL;
        $model->pic_urls = $obj['pic_urls']?serialize($obj['pic_urls']):NULL;
        $model->profile_image_url = $obj['user']['profile_image_url'];
        $model->followers_count = $obj['user']['followers_count'];
        $model->friends_count = $obj['user']['friends_count'];
        $model->statuses_count = $obj['user']['statuses_count'];
        $model->favourites_count = $obj['user']['favourites_count'];
        $model->save();

        if($retweeted_reprint) $this->insertRecord($obj['retweeted_status'],0,$model->attributes['weibo_sys_id']);
    }

    /**
     * 解析图片数据
     * @param type $obj
     * @return type
     */
    public function returnPicUrls($obj){
        if(!empty($obj)){
            foreach ($obj as $key => $v){
                if(gettype($v) == 'object'){
                    $this->returnPicUrls($v);
                }else{
                    $this->pic_urls_arr[] = $v;
                }
            }
            return $this->pic_urls_arr;
        }
    }
}