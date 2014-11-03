<dl class="k_dl1 m_b14">
    <dt><h1>活跃度排行</h1><em></em><a target="_blank" href="<?= Yii::app()->createUrl('alumni/index'); ?>">查看全部</a></dt>
    <dd>
        <ul class="pmlist_ul">
            <?php
            $i = 1;
            foreach ($top_alumnis as $key => $value) {
                ?>
                <li>
                    <?php
                    if ($key) {
                        if ($top_alumnis[$key]['month_rank'] != $top_alumnis[$key - 1]['month_rank'])
                            $i = $key + 1;
                    }
                    if ($i == 1) {
                        echo '<em class="a">' . $i . '</em>';
                    } elseif ($i == 2 || $i == 3) {
                        echo '<em class="b">' . $i . '</em>';
                    } elseif ($i > 3 && $i < 11) {
                        echo '<em class="c">' . $i . '</em>';
                    } else {
                        echo '<em class="d">' . $i . '</em>';
                    }
                    ?>
                    <a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['id'])); ?>" target="_blank"><?= $value['name']; ?></a>
                    <p style=" float: right"><a href="<?= Yii::app()->createUrl('news/index', array('alumni_id' => $value['id'])); ?>" target="_blank" style="color: #3993E0;cursor:pointer;" title="<?= $value['month_news_count'] . '新闻 ' . $value['month_event_count'] . '活动' . $value['month_weibo_count'] . '微博'; ?>"><?= $value['month_rank']; ?></a></p>
                    <div style="clear:both;"></div>
                </li>
            <?php } ?>
        </ul>
    </dd>
</dl>
