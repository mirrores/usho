<!--body-->
<div class="m m_b14">
    <div class="y_pm f_right">
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>最新新闻</h1><em></em>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php foreach ($related_news_list as $value) { ?>
                        <li><i></i><h1><a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>" title="<?= '[' . $value['name'] . ']' . $value['title']; ?>"><?= $value['title']; ?></a></h1></li>
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
            <h1><?= CHtml::encode($model['title']); ?></h1>
            <h2>
                <?= $model->user->name ? '&nbsp;&nbsp;作者：' . $model->user->name : ''; ?>
                <?= $model['create_date'] ? '&nbsp;&nbsp;发布：' . substr($model['create_date'], 0, 10) : ''; ?>
            </h2>
            
            <div class="art_content no_login">
                <?= CHtml::encode($model['content']); ?>
            </div>

            <!--comment-->
            <div class="art_comment">
                <div class="art_c_tit"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ico_10.jpg" /><span>评论</span></div>
                <?php
                if (empty($comments_list)) {
                    echo '<dl><dd><div class="content">暂无评论</div></dd></dl>';
                } else {
                    $floor = 1;
                    foreach ($comments_list as $value) {
                        ?>
                        <dl>
                            <dt><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/face_2.jpg" width="60" height="60" /></dt>
                            <dd>
                                <span class="floor" id="<?= $floor; ?>floor"><?= $floor; ?> F</span>
                                <span class="name" id="<?= $floor; ?>name"><?= $value->is_anonymity ? '匿名' : $value->user->name; ?></span>
                                <span class="time" id="<?= $floor; ?>time"><?= $value->create_date; ?></span>
                                <div class="content" id="<?= $floor; ?>quote_comment"><?= $value->quote_comment; ?></div>
                                <div class="content" id="<?= $floor; ?>content"><?= $value->content; ?></div>
                            </dd>
                        </dl>
                        <?php
                        $floor++;
                    }
                }
                ?>
                <div class="clr"></div>
                <dl>
                    <dt><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/face_2.jpg" width="60" height="60" /></dt>
                    <dd>
                        登陆以后才能评论，请先&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="ajaxLoginForm('<?= Yii::app()->createUrl('site/ajaxLogin') ; ?>');">登录</a>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>