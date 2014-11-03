<dl class="k_dl4 m_b14">
    <dt>
    <h1>我关注的微博</h1><em></em>
    </dt>
    <dd class="ar_sho">
        <ul>
            <?php if ($data) { ?>
                <?php foreach ($data as $value) { ?>
                    <li><i></i>
                        <h1 style="width:220px;">
                            <a href="<?= Yii::app()->createUrl('weibo/index', array('id' => $value['weibo_sys_id'])); ?>" target="_blank" title="<?= '[' . $value['screen_name'] . ']' . $value['text']; ?>"><?= $value['text']; ?></a>
                        </h1>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li><i></i><h1>暂无微博</h1></li>
            <?php } ?>
        </ul>
    </dd>
</dl>