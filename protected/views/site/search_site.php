<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<!--body-->
<div class="m m_b14"><!---->
    <div class=" fl_left w_1000">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/search_1.jpg" style="display:block;" />
        <div class="search_m">
            <div class="search_path">当前位置：<a href="<?= Yii::app()->createUrl('site'); ?>">首页</a> > 站内搜索</div>
            <div class="search_menu">
                <ul>
                    <li class="<?= $model == 'news' ? 'smu on' : 'smu out'; ?>"><a href="<?= Yii::app()->createUrl('site/searchsite', array('model' => 'news', 'keyword' => $keyword)); ?>">新闻动态</a><i></i></li>
                    <li class="<?= $model == 'monthly' ? 'smu on' : 'smu out'; ?>"><a href="<?= Yii::app()->createUrl('site/searchsite', array('model' => 'monthly', 'keyword' => $keyword)); ?>">友笑月报</a><i></i></li>
                    <li class="<?= $model == 'event' ? 'smu on' : 'smu out'; ?>"><a href="<?= Yii::app()->createUrl('site/searchsite', array('model' => 'event', 'keyword' => $keyword)); ?>">校友活动</a><i></i></li>
                    <li class="<?= $model == 'weibo' ? 'smu on' : 'smu out'; ?>"><a href="<?= Yii::app()->createUrl('site/searchsite', array('model' => 'weibo', 'keyword' => $keyword)); ?>">校友会微博</a><i></i></li>
                </ul>
            </div>
            <div class="search_text">
                <form action="<?= Yii::app()->createUrl('site/searchsite'); ?>" method="POST" id="search_site2"><input type="text" class="text" name="keyword" value="<?= $keyword; ?>" /><input type="hidden" name="model" value="<?= $model; ?>"><input type="button" value="" onclick="$('#search_site2').submit();" class="but" /></form>
            </div>
            <span class="search_sum">共找到 <font><?= $count; ?></font> 条符合条件的内容：</span>
            <div class="search_li">
                <ul>
                    <?php
                    if ($list) {
                        foreach ($list as $value) {
                            if($model == 'weibo'){ ?>
                                <li>
                                    <i></i>
                                    <h1>[<?=$value['screen_name']?>] <a href="<?= Yii::app()->createUrl($model . '/index', array('id' => $value['weibo_sys_id'])); ?>" target="block"><?=Helper::truncateUtf8String($value['text'], 50)?></a></h1>
                                    <span><?=date('Y-m-d',$value['created_at']) ?></span>
                                </li>
                            <?php }else{ ?>
                            <li><i></i>
                                <h1>
                                    <?php if (isset($value['alumni'])) { ?>[<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?= $value['alumni']['name'] ?></a>]<?php } ?>
                                    <a href="<?= Yii::app()->createUrl($model . '/view', array('id' => $value['id'])); ?>" target="block">
                                        <?php
                                        if (isset($value['title'])) {
                                            echo $value['title'];
                                        } elseif (isset($value['title'])) {
                                            echo $value['title'];
                                        } else {
                                            echo $value['name'];
                                        }
                                        ?>
                                    </a>
                                </h1>
                                <span>
                                    <?php
                                    if (isset($value['create_date'])) {
                                        echo substr($value['create_date'], 0, 10);
                                    } elseif (isset($value['create_date'])) {
                                        echo $value['create_date'];
                                    } else {
                                        echo substr($value['start_date'], 0, 10);
                                    }
                                    ?></span></li>
                            <?php
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
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
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>