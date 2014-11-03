<!--body-->
<div class="m m_b14">
    <div class="w_200 f_right">
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>我关注的校友会</h1><em></em><?php if ($my_mark_alumnis) { ?><a href="<?= Yii::app()->createUrl('news/index', array('alumni_id' => $my_mark_alumnis, 'category_id' => 1)); ?>">更多</a><?php } ?>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php if ($my_mark_school_news_list) { ?>
                        <?php foreach ($my_mark_school_news_list as $value) { ?>
                            <li><i></i><h1><a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>"><?= $value['title']; ?></a></h1></li>
                        <?php } ?>
                    <?php } else { ?>
                        <li><i></i><h1>暂无新闻</h1></li>
                    <?php } ?>
                </ul>
            </dd> 
        </dl>
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>我校校友会新闻</h1><em></em><a href="<?= Yii::app()->createUrl('news/index', array('alumni_id' => $alumni_info->id, 'category_id' => 1)); ?>">更多</a>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php if ($my_school_news_list) { ?>
                        <?php foreach ($my_school_news_list as $value) { ?>
                            <li><i></i><h1><a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>"><?= $value['title']; ?></a></h1></li>
                        <?php } ?>
                    <?php } else { ?>
                        <li><i></i><h1>暂无新闻</h1></li>
                    <?php } ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>同省校友会新闻</h1><em></em><?php if ($city_alumni_list_ids) { ?><a href="<?= Yii::app()->createUrl('news/index', array('alumni_id' => $city_alumni_list_ids, 'category_id' => 1)); ?>">更多</a><?php } ?>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php if ($city_news_list) { ?>
                        <?php foreach ($city_news_list as $value) { ?>
                            <li><i></i><h1><a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>"><?= $value['title']; ?></a></h1></li>
                        <?php } ?>
                    <?php } else { ?>
                        <li><i></i><h1>暂无新闻</h1></li>
                    <?php } ?>
                </ul>
            </dd>
        </dl>
    </div>

    <!---->
    <div class="f_left w_200">
        <dl class="k_dl1 m_b14">
            <dt><h1>全国排名</h1><em></em></dt>
            <dd>
                <ul class="pmlist_ul">
                    <?php
                    $show = 0;
                    for ($i = $ranknum_in_all - 2; $show < 5; $i++) {
                        if (isset($all_alumni_list[$i])) {
                            if ($i == $ranknum_in_all) {
                                $id = $alumni_info->id;
                                $name = $alumni_info->name;
                                echo '<li class="my_school"><i></i>';
                            } else {
                                $id = $all_alumni_list[$i]['id'];
                                $name = $all_alumni_list[$i]['name'];
                                echo '<li>';
                            }
                            ?><em class="<?php
                            if ($i == 1) {
                                echo 'a';
                            } elseif ($i == 2 || $i == 3) {
                                echo 'b';
                            } else {
                                echo 'c';
                            }
                            ?>"><?= $i; ?></em><a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $id)); ?>" target="_blank"><?= $name; ?></a></li>
                                <?php
                                $show++;
                            }
                        }
                        ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl1 m_b14">
            <dt><h1>同类排名</h1><em></em></dt>
            <dd>
                <ul class="pmlist_ul">
                    <?php
                    $show = 0;
                    for ($i = $ranknum_in_kind - 2; $show < 5; $i++) {
                        if (isset($kind_alumni_list[$i])) {
                            if ($i == $ranknum_in_kind) {
                                $id = $alumni_info->id;
                                $name = $alumni_info->name;
                                echo '<li class="my_school"><i></i>';
                            } else {
                                $id = $kind_alumni_list[$i]['id'];
                                $name = $kind_alumni_list[$i]['name'];
                                echo '<li>';
                            }
                            ?><em class="<?php
                            if ($i == 1) {
                                echo 'a';
                            } elseif ($i == 2 || $i == 3) {
                                echo 'b';
                            } else {
                                echo 'c';
                            }
                            ?>"><?= $i; ?></em><a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $id)); ?>" target="_blank"><?= $name; ?></a></li>
                                <?php
                                $show++;
                            }
                        }
                        ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl1 m_b14">
            <dt><h1>同城排名</h1><em></em></dt>
            <dd>
                <ul class="pmlist_ul">
                    <?php
                    $show = 0;
                    for ($i = $ranknum_in_city - 2; $show < 5; $i++) {
                        if (isset($city_alumni_list[$i])) {
                            if ($i == $ranknum_in_city) {
                                $id = $alumni_info->id;
                                $name = $alumni_info->name;
                                echo '<li class="my_school"><i></i>';
                            } else {
                                $id = $city_alumni_list[$i]['id'];
                                $name = $city_alumni_list[$i]['name'];
                                echo '<li>';
                            }
                            ?><em class="<?php
                            if ($i == 1) {
                                echo 'a';
                            } elseif ($i == 2 || $i == 3) {
                                echo 'b';
                            } else {
                                echo 'c';
                            }
                            ?>"><?= $i; ?></em><a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $id)); ?>" target="_blank"><?= $name; ?></a></li>
                                <?php
                                $show++;
                            }
                        }
                        ?>
                </ul>
            </dd>
        </dl>
    </div>
    <!---->
    <div class="ar_sho m_l210 w_580">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/atricle_1.jpg" width="580" style="display:block;" />
        <div class="art_showdiv">
            <div class="h_24"></div>
            <h1><?= $data['title']; ?></h1>
            <h2>
                <?= $data['create_date'] ? '&nbsp;&nbsp;发布：' . substr($news['create_date'], 0, 10) : ''; ?>
                <?= $data['author'] ? '&nbsp;&nbsp;作者：' . $data['author'] : ''; ?>
                <?= '&nbsp;&nbsp;';?>点击：<?= $data['hit_num'] ? $data['hit_num'] : 0; ?>
            </h2>
            <div class="art_content is_login">
                <?= $data['content']; ?>
            </div>
            <div class=""><?php if ($data['source_url']) { ?><a href="<?= $event['source_url']; ?>" target="_blank">查看源文</a><?php } ?></div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>