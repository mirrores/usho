<!--body-->
<div class="m m_b14">
    <div class="y_pm f_right">
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>相关新闻</h1><em></em>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php
                    if (count($related_news_list) > 0) {
                        foreach ($related_news_list as $value) {
                            if ($value['news_id']) {
                                $url = Yii::app()->createUrl('news/view', array('id' => $value['news_id']));
                            } elseif ($value['event_id']) {
                                $url = Yii::app()->createUrl('event/view', array('id' => $value['event_id']));
                            } else {
                                $url = Yii::app()->createUrl('monthlyData/view', array('id' => $value['id']));
                            }
                            ?>
                            <li><i></i><h1><a href="<?= $url; ?>"><?= $value['title']; ?></a></h1></li>
                            <?php
                        }
                    } else {
                        ?>
                        <li><i></i><h1>暂无新闻</h1></li>
<?php } ?>
                </ul>
            </dd>
        </dl>
    </div>

    <!---->
    <div class="ar_sho fl_left w_780">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/atricle_1.jpg" style="display:block;" />
        <div class="art_showdiv">
            <div class="h_24"></div>
            <h1><?= $data['title']; ?></h1>
            <h2>
                <?= $data['create_date'] ? '&nbsp;&nbsp;发布：' . substr($news['create_date'], 0, 10) : ''; ?>
                <?= $data['author'] ? '&nbsp;&nbsp;作者：' . $data['author'] : ''; ?>
                <?= '&nbsp;&nbsp;';?>点击：<?= $data['hit_num'] ? $data['hit_num'] : 0; ?>
            </h2>
            <div class="art_content no_login">
<?= $data['content']; ?>
            </div>
            <div class=""><?php if ($data['source_url']) { ?><a href="<?= $data['source_url']; ?>" target="_blank">查看源文</a><?php } ?></div>
            <div class="art_next"></div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>