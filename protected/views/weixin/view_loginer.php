<!--body-->
<div class="m m_b14">
    <div class="w_300 f_right">
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>我的关注</h1><em></em><?php if (count($my_mark_school_news_list) > 5) { ?><a style="color: #5d8080" href="<?= Yii::app()->createUrl('weixin/index', array('alumni_id' => $my_mark_alumnis, 'category_id' => 1)); ?>" target="_blank">更多</a><?php } ?>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php if ($my_mark_school_news_list) { ?>
                        <?php foreach ($my_mark_school_news_list as $value) { ?>
                            <li><i></i>
                                <h1 style="width:200px;">
                                    [<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?= $value['name']; ?></a>]
                                    <a href="<?= Yii::app()->createUrl('weixin/view', array('id' => $value['id'])); ?>" target="_blank" title="<?= '[' . $value['name'] . ']' . $value['title']; ?>"><?= $value['title']; ?></a>
                                </h1>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <li><i></i><h1>暂无微信</h1></li>
                    <?php } ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>我校微信</h1><em></em><?php if (count($my_school_news_list) > 5) { ?><a style="color: #5d8080" href="<?= Yii::app()->createUrl('weixin/index', array('alumni_id' => $alumni_info->id, 'category_id' => 1)); ?>" target="_blank">更多</a><?php } ?>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php if ($my_school_news_list) { ?>
                        <?php foreach ($my_school_news_list as $value) { ?>
                            <li><i></i>
                                <h1 style="width:200px;">
                                    [<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?= $value['name']; ?></a>]
                                    <a href="<?= Yii::app()->createUrl('weixin/view', array('id' => $value['id'])); ?>" target="_blank" title="<?= '[' . $value['name'] . ']' . $value['title']; ?>"><?= $value['title']; ?></a>
                                </h1>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <li><i></i><h1>暂无微信</h1></li>
                    <?php } ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl4 m_b14">
            <dt>
            <h1>同省微信</h1><em></em><?php if (count($city_news_list) > 5) { ?><a style="color: #5d8080" href="<?= Yii::app()->createUrl('weixin/index', array('alumni_id' => $city_alumni_list_ids, 'category_id' => 1)); ?>" target="_blank">更多</a><?php } ?>
            </dt>
            <dd class="ar_sho">
                <ul>
                    <?php if ($city_news_list) { ?>
                        <?php foreach ($city_news_list as $value) { ?>
                            <li><i></i>
                                <h1 style="width:200px;">
                                    [<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?= $value['name']; ?></a>]
                                    <a href="<?= Yii::app()->createUrl('weixin/view', array('id' => $value['id'])); ?>" target="_blank" title="<?= '[' . $value['name'] . ']' . $value['title']; ?>"><?= $value['title']; ?></a>
                                </h1>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <li><i></i><h1>暂无微信</h1></li>
                    <?php } ?>
                </ul>
            </dd>
        </dl>
    </div>

    <!---->
    <div class="f_left w_200">
        <dl class="k_dl1 m_b14">
            <dt><h1>全国排名</h1><em></em><a target="_blank" href="<?= Yii::app()->createUrl('alumni/index', array('uid' => $user_info['id'])); ?>">查看全部</a></dt>
            <dd>
                <ul class="pmlist_ul">
                    <?php
                    $i = $rank_in_all[0];
                    $j = $rank_in_all[0];
                    foreach ($rank_in_all[1] as $key => $value) {
                        if ($value['id'] == $user_info['alumni_id']) {
                            echo '<li class="my_school"><i></i>';
                        } else {
                            echo '<li>';
                        }

                        if ($key) {
                            if ($rank_in_all[1][$key]['month_rank'] != $rank_in_all[1][$key - 1]['month_rank'])
                                $i = $j;
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

                        echo '<a href="' . Yii::app()->createUrl('alumni/view', array('id' => $value['id'])) . '" target="_blank">' . $value['name'] . '</a></li>';
                        $j ++;
                    }
                    ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl1 m_b14">
            <dt><h1>同类排名</h1><em></em><a target="_blank" href="<?= Yii::app()->createUrl('alumni/index', array('uid' => $user_info['id'], 'nature_code' => $school_info->nature_code, 'genre_code' => $school_info->genre_code)); ?>">查看全部</a></dt>
            <dd>
                <ul class="pmlist_ul">
                    <?php
                    $i = $rank_in_kind[0];
                    $j = $rank_in_kind[0];
                    foreach ($rank_in_kind[1] as $key => $value) {
                        if ($value['id'] == $user_info['alumni_id']) {
                            echo '<li class="my_school"><i></i>';
                        } else {
                            echo '<li>';
                        }

                        if ($key) {
                            if ($rank_in_kind[1][$key]['month_rank'] != $rank_in_kind[1][$key - 1]['month_rank'])
                                $i = $j;
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

                        echo '<a href="' . Yii::app()->createUrl('alumni/view', array('id' => $value['id'])) . '" target="_blank">' . $value['name'] . '</a></li>';
                        $j ++;
                    }
                    ?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl1 m_b14">
            <dt><h1>同省排名</h1><em></em><a target="_blank" href="<?= Yii::app()->createUrl('alumni/index', array('uid' => $user_info['id'], 'provinces_id' => $school_info->provinces_id)); ?>">查看全部</a></dt>
            <dd>
                <ul class="pmlist_ul">
                    <?php
                    $i = $rank_in_province[0];
                    $j = $rank_in_province[0];
                    foreach ($rank_in_province[1] as $key => $value) {
                        if ($value['id'] == $user_info['alumni_id']) {
                            echo '<li class="my_school"><i></i>';
                        } else {
                            echo '<li>';
                        }

                        if ($key) {
                            if ($rank_in_province[1][$key]['month_rank'] != $rank_in_province[1][$key - 1]['month_rank'])
                                $i = $j;
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

                        echo '<a href="' . Yii::app()->createUrl('alumni/view', array('id' => $value['id'])) . '" target="_blank">' . $value['name'] . '</a></li>';
                        $j ++;
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
            <h1><?= $news['title']; ?></h1>
            <h2>
                <?= $news['created_at'] ? '&nbsp;&nbsp;发布：' . substr($news['created_at'], 0, 10) : ''; ?>
                <?= $news->alumni ? '&nbsp;&nbsp;来源：' . $news->alumni->name : ''; ?>
                <?= '&nbsp;&nbsp;'; ?>点击：<?= $news['hits_num'] ? $news['hits_num'] : 0; ?>
            </h2>
            <div class="alumni_tit" style="background:none;">
                <a href="javascript:void(0);" class="attention" id="user_marked"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ico_16.png" /><span id="mark_if"><?= $is_marked ? '取消关注' : '关注'; ?></span><?= $news->alumni->name; ?></a>
            </div>
            <div class="art_content is_login">
                <?= $news['content']; ?>
            </div>
            <div class=""><?php if ($news['url']) { ?><a href="<?= $news['url']; ?>" target="_blank">查看源文</a><?php } ?></div>
            <div class="art_next">
                <?php
                if (empty($next_news)) {
                    echo '下一篇：无';
                } else {
                    ?>下一篇：<a href="<?= Yii::app()->createUrl('weixin/view', array('id' => $next_news['id'])); ?>"><?= $next_news['title']; ?></a><?php } ?>
            </div>

            <!--comment-->
            <div class="art_comment">
                <div class="art_c_tit"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ico_10.jpg" /><span>评论</span></div>
                <div id="comment_list">
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
                                    <div class="content"><a style="float: right; margin-right: 30px" href="javascript:void(0);" onclick="quote_comment(<?= $floor; ?>)">引用</a></div>
                                </dd>
                            </dl>
                            <?php
                            $floor++;
                        }
                    }
                    ?>
                </div>
                <dl>
                    <dt><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/face_2.jpg" width="60" height="60" /></dt>
                    <dd>
                        <?php if (Yii::app()->user->id) { ?>
                            <div class="content" id="quote"></div>
                            <input type="hidden" id="quote_comment" value="">
                            <div class="content">
                                <textarea id="comment" name="comment" cols="60" rows="8"></textarea>
                            </div>
                            <input type="checkbox" name="is_anonymity" id="is_anonymity" value="1">匿名评论
                            <span class="published" id="gray_submit" style="-webkit-filter: grayscale(100%); -webkit-filter: grayscale(1); filter: grayscale(100%); filter:gray; display:block;"></span>
                            <a href="javascript:void(0);" style="display: none;" class="published" id="put_comment"></a>
                        <?php } else { ?>
                            登陆以后才能评论，请先&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  onclick="ajaxLoginForm('<?= Yii::app()->createUrl('site/ajaxLogin', array('uid' => $this->userInfo->id)); ?>');">登录</a>
                        <?php } ?>
                    </dd>
                </dl>
                <div class="clr"></div>
            </div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#put_comment').click(function() {
            var is_anonymity = 0;
            if ($("#is_anonymity").is(":checked")) {
                is_anonymity = $("#is_anonymity").val()
            }

            $.ajax({
                type: 'post',
                url: '<?= Yii::app()->createUrl('comment/ajaxAdd'); ?>',
                data: {'content': $('#comment').val(), 'quote_comment': $('#quote_comment').val(), 'is_anonymity': is_anonymity, 'news_id':<?= $news['id']; ?>},
                success: function(data) {
                    $('#comment_list').html(data);
                    $('#comment').val('');
                    $('#put_comment').css('display', 'none');
                    $('#gray_submit').css('display', '');
                    $('#quote').html('');
                    $('#quote_comment').html('');
                }
            });
        })

        $('#user_marked').click(function() {
            var is_loginer = <?= Yii::app()->user->isGuest ? Yii::app()->user->isGuest : 0; ?>;
            if (is_loginer) {
                ajaxLoginForm('<?= Yii::app()->createUrl('site/ajaxLogin', array('uid' => $this->userInfo->id)); ?>');
            } else {
                if ($('#mark_if').html() == '关注') {
                    $.ajax({
                        type: 'post',
                        url: '<?= Yii::app()->createUrl('alumni/mark', array('id' => $news['alumni_id'])); ?>',
                        success: function(data) {
                            $('#mark_if').html('取消关注');
                        }
                    });
                } else {
                    $.ajax({
                        type: 'post',
                        url: '<?= Yii::app()->createUrl('alumni/markDelete', array('id' => $news['alumni_id'])); ?>',
                        success: function(data) {
                            $('#mark_if').html('关注');
                        }
                    });
                }
            }
        })
    })
</script>
