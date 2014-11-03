<?php

class CommentController extends Controller {

    //ajax添加评论
    public function actionAjaxAdd() {
        $model = new Comment();
        $model->attributes = $_POST;
        $model->user_id = Yii::app()->user->id;
        $model->create_date = date('Y-m-d H:i:s');

        $model->save();

        if (isset($_POST['news_id']))
            $where = 'news_id = ' . $_POST['news_id'];
        elseif (isset($_POST['event_id']))
            $where = 'event_id = ' . $_POST['event_id'];

        //获取评论列表
        $comments_list = Comment::model()->findAll($where);

        $is_guster = Yii::app()->user->isGuest ? Yii::app()->user->isGuest : 0;
        $data = '';
        $floor = 1;
        foreach ($comments_list as $value) {
            $name = $value->is_anonymity ? '匿名' : $value->user->name;
            $data.='<dl>
                        <dt><img src="' . Yii::app()->request->baseUrl . '/static/images/face_2.jpg" width="60" height="60" /></dt>
                        <dd>
                            <span class="floor" id="' . $floor . 'floor">' . $floor . ' F</span><span class="name" id="' . $floor . 'name">' . $name . '</span><span class="time" id="' . $floor . 'time">' . $value->create_date . '</span>
                            <div class="content" id="' . $floor . 'quote_comment">' . $value->quote_comment . '</div>    
                            <div class="content" id="' . $floor . 'content">' . $value->content . '</div>
                            <div class="content"><a style="float: right; margin-right: 30px" href="javascript:void(0);" onclick="quote_comment(' . $floor . ',' . $is_guster . ',\'' . Yii::app()->createUrl('site/ajaxLogin', array('uid' => $this->userInfo->id)) . '\')">引用</a></div>
                        </dd>
                     </dl>';
            $floor++;
        }
        echo $data;
    }

}
