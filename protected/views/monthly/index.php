<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14">
    <div class="y_pm f_left">
        <?php include_once "protected/views/alumni/alumni_ranking.php"; ?>
        <span class="link_ad1"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ad_1.jpg" /></span>
    </div>

    <!---->
    <div class="monthly_list w_780">
        <dl class="k_dl3">
            <dt>
            <h1>友笑周报</h1><em></em></dt>
            <dd>
                <ul>
                    <?php foreach ($list as $value) { ?>
                        <li>
                            <a href="<?= $this->createUrl('monthly/view', array("id" => $value['id'])) ?>">
                                <img src="<?= Yii::app()->request->baseUrl . $value['cover_img_path']; ?>" width="142" height="195" />
                            </a>
                            <h1 style="width: 142px; height: 48px; overflow: hidden;">
                                <a href="<?= $this->createUrl('monthly/view', array("id" => $value['id'])) ?>" title="<?= $value['name']; ?>"><?= $value['name']; ?>
                                </a>
                            </h1>
                        </li>
                    <?php } ?>
                </ul>
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
            </dd>
        </dl>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>