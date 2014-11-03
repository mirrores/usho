<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14">
    <div class="y_pm f_left">
        <?php include_once "protected/views/alumni/alumni_ranking.php"; ?>
        <span class="link_ad1"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ad_1.jpg" /></span>
    </div>

    <div class="hd_list w_780">
        <dl class="k_dl3">
            <dt><h1>校友会微信</h1><em></em></dt>
            <dd>
                <ul>
                    <?php foreach ($list as $value) { ?>
                    <li><i></i><h1>[<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?=$value['alumni']['name']?></a>] <a target="_blank" href="<?= Yii::app()->createUrl('weixin/view', array('id' => $value['id'])); ?>"><?= $value['title'] ?></a></h1><span><?= substr($value['created_at'], 0, 10); ?></span></li>
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