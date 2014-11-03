<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14"><!---->
    <div class=" fl_left w_1000">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/search_1.jpg" style="display:block;" />
        <div class="member_m">
            <!--right-->
            <div class="member_right">
                <div class="site">位置：会员中心 － <span>我的关注</span></div>
                <div class="body_myinfo attention">
                    <?php foreach ($mark_list as $value) {?>
                        <dl>
                            <dt><a href="<?= $value->alumni->website?>" title="<?= $value->alumni->name ;?>校友会" target="block"><img src="<?php echo Yii::app()->request->baseUrl; if($value->alumni->logo_path) {echo $value->alumni->logo_path;}else{echo '/static/images/member_8.jpg';} ?>" width="100" height="100" style="overflow: hidden;" /></a></dt>
                            <dd><?= $value->alumni->name ;?>校友会</dd>
                            <dd><i></i><span><a href="<?= $value->alumni->website?>" target="block">查看</a> <a href="<?= Yii::app()->createUrl('user/delete', array('id'=>$value['id']))?>">取消关注</a></span></dd>
                        </dl>
                    <?php } ?>
                    <!--page-->
                    <div class="page_list clr">
                        <?php
                        $this->widget('CLinkPager', array(
                            'header' => false,
                            'firstPageLabel' => '第一页',
                            'lastPageLabel' => '最后一页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $pages,
                            'cssFile' => false,
                        ))
                        ?>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
            <!--left-->
            <div class="member_left">
                <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/member_1.jpg" />
                <div class="bg">
                    <ul>
                        <li><a href="<?= Yii::app()->createUrl('user')?>" class="ico_11 ">我的信息<i></i></a></li><!--on 选中样式-->
                        <li><a href="<?= Yii::app()->createUrl('user/mark')?>" class="ico_12 on">我的关注</a></li>
                        <li><a href="<?= Yii::app()->createUrl('user/message')?>" class="ico_13">我的留言</a></li>
                        <li><a href="<?= Yii::app()->createUrl('user/changepassword')?>" class="ico_14">修改密码</a></li>
                        <li><a href="<?= Yii::app()->createUrl('site/logout')?>" class="ico_15">安全退出</a></li>
                    </ul>
                </div>
                <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/member_3.jpg" />
            </div>

            <div class="clr"></div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>
