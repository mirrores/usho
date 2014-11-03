<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14">
    <div class="y_pm f_right">
        <dl class="k_dl1 m_b14">
            <?php include_once "protected/views/alumni/alumni_ranking.php"; ?>
        </dl>
        <dl class="k_dl1">
            <dt><h1>最新加入</h1><em></em></dt>
            <dd class="a_ml">
                <?php foreach ($new_school_alumni as $value) { ?>
                    <a href="<?= $value['website']; ?>" target="_blank"><img src="<?= Yii::app()->baseUrl . $value['logo_path']; ?>" width="166" height="46" /></a>

                <?php } ?>
            </dd>
        </dl>
    </div>
    <!---->
    <div class="fl_left w_780">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/atricle_1.jpg" style="display:block;" />
        <div class="art_showdiv">
            <div class="h_24"></div>
            <div class="keyword_select">
                <dl>
                    <dt>办学类型：</dt>
                    <dd>
                        <a href="<?= Yii::app()->createUrl('alumni/index', array('nature_code' => $nature_code, 'provinces_id' => $provinces_id)); ?>"><?php
                            if ($genre_code == '') {
                                echo '<span>全部</span>';
                            } else {
                                echo '全部';
                            }
                            ?></a>
                        <?php foreach ($genre_list as $value) { ?>
                            <a href="<?= Yii::app()->createUrl('alumni/index', array('nature_code' => $nature_code, 'genre_code' => $value['code'], 'provinces_id' => $provinces_id)); ?>"><?php
                                if ($genre_code == $value['code']) {
                                    echo '<span>' . $value['name'] . '</span>';
                                } else {
                                    echo $value['name'];
                                }
                                ?></a>
                        <?php } ?>
                    </dd>
                </dl>
                <dl>
                    <dt>性质类别：</dt>
                    <dd>
                        <a href="<?= Yii::app()->createUrl('alumni/index', array('genre_code' => $genre_code, 'provinces_id' => $provinces_id)); ?>"><?php
                            if ($nature_code == '') {
                                echo '<span>全部</span>';
                            } else {
                                echo '全部';
                            }
                            ?></a>
                        <?php foreach ($nature_list as $value) { ?>
                            <a href="<?= Yii::app()->createUrl('alumni/index', array('genre_code' => $genre_code, 'nature_code' => $value['code'], 'provinces_id' => $provinces_id)); ?>"><?php
                                if ($nature_code == $value['code']) {
                                    echo '<span>' . $value['name'] . '</span>';
                                } else {
                                    echo $value['name'];
                                }
                                ?></a>
                        <?php } ?>
                    </dd>
                </dl>
                <dl>
                    <dt>按地区：</dt>
                    <dd>
                        <a href="<?= Yii::app()->createUrl('alumni/index', array('genre_code' => $genre_code, 'nature_code' => $nature_code)); ?>"><?php
                            if ($provinces_id == '') {
                                echo '<span>全部</span>';
                            } else {
                                echo '全部';
                            }
                            ?></a>
                        <?php foreach ($provinces_list as $value) { ?>
                            <a href="<?= Yii::app()->createUrl('alumni/index', array('genre_code' => $genre_code, 'nature_code' => $nature_code, 'provinces_id' => $value['id'])); ?>"><?php
                                if ($provinces_id == $value['id']) {
                                    echo '<span>' . $value['name'] . '</span>';
                                } else {
                                    echo $value['name'];
                                }
                                ?></a>
                        <?php } ?>
                    </dd>
                </dl>
                <div class="search_list_key">
                    <!--注：text_list,img_list 未激活; text_list_on,img_list_on 激活-->
                    <!--<div class="status"><a href="" class="text_list"></a><a href="" class="img_list_on"></a></div>
                    <div class="active down"><a href="">活跃度</a></div><!--up 升序，down降序-->
                    <?php $form = $this->beginWidget('CActiveForm') ?><input type="text" value="<?= $keyword ? $keyword : '关键字' ?>" name="keyword" id="keyword" class="k_text" />
                    <input type="submit" value="确定" class="k_sub" /><?php $this->endwidget(); ?>
                    <script type="text/javascript">
                        $(".k_text").focus(function() {
                            var email_txt = $(this).val();
                            if (email_txt == '关键字') {
                                $(this).val("");
                                $(this).css('color', '5c5c5c');
                            }
                        })
                        $(".k_text").blur(function() {
                            var email_txt = $(this).val();
                            if (email_txt == "") {
                                $(this).val('关键字');
                            }
                        })
                    </script> 
                </div>
                <div class="search_content">
                    <ul>
                        <?php foreach ($list as $value) { ?>
                        <li style="border-right: 1px dashed #CCC; ">
                            <a <?php if($value['website']){?>href="<?= $value['website']; ?>" title="<?= $value['month_news_count'] . '新闻 ' . $value['month_event_count'] . '活动'; ?>"<?php }else{?>title="暂未收录校友网"<?php }?> target="_blank" style="padding-left: 5px; "><?= $value['name']; ?></a>
                            <a href="<?= Yii::app()->createUrl('news/index', array('alumni_id' => $value['id'])); ?>" target="_blank" style=" float: right; padding-right: 10px; color: #3993E0;cursor:pointer;" title="<?= $value['month_news_count'] . '新闻 ' . $value['month_event_count'] . '活动 ' . $value['month_weibo_count'] . '微博'; ?>"><?= $value['month_rank'] != 0 ? $value['month_rank'] : ''; ?></a>
                            <div > </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
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
                <div class="" style="clear:left;"></div>
            </div>
        </div><!--comment-->
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>