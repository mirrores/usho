<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14">
    <div class="y_pm f_left">
        <?php include_once "protected/views/alumni/alumni_ranking.php"; ?>
        <span class="link_ad1"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ad_1.jpg" /></span>
    </div>

    <div class="hd_list w_780">
        <dl class="k_dl3">
            <dt>
                <h1>所有问题</h1><em></em>
            </dt>
            <?php if(Yii::app()->user->id){}?>
            <dd>
                <a href="<?= Yii::app()->createUrl('talk/talk'); ?>" style=" background-color: #85c1f7;border-radius: 2px;color: #FFF; float: right;padding: 7px 15px; margin-top: -7px;">聊天室</a>
                <a href="<?= Yii::app()->createUrl('talk/create'); ?>" style="background-color: #85c1f7;border-radius: 2px;padding: 7px 15px;color: #FFF; margin-left: 600px">发布新问题</a>
            </dd>
            <dd>
                <ul>
                    <?php foreach ($list as $value) { ?>
                        <li><i></i><h1><a target="_blank" href="<?= Yii::app()->createUrl('talk/view', array('id' => $value['id'])); ?>"><?= $value['title'] ?></a></h1><span><?= substr($value['create_date'], 0, 10); ?></span></li>
                    <?php } ?>
                </ul>
                <!--page-->
                <div class="page_list">
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
            </dd>
        </dl>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>