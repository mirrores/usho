<!--body-->
<div class="m m_b14">
    <div class="y_pm f_left">
        <?= $this->renderPartial('//alumni/alumni_ranking'); ?>
        <span class="link_ad1">排名规则:根据校友会网站上个月的新闻和活动数量以及校友总会微博发布数量进行积分排名,一个活动、新闻+10分,一条微博+1分.</span>
    </div>
    
    <!--首页新闻-->
    <div class="tj_news f_left m_l18">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/news_1.jpg" style="display:block;" />
        <div class="tj_con">
            <?php if ($news_top): ?>
                <h1 class="tit"><a href="<?= Yii::app()->createUrl('news/view', array('id' => $news_top->id)); ?>" target="_blank"><span style="size: 14px; color: #cc0000; font-size: 14px;"><?= $news_top->title; ?></span></a></h1>
                <dl>
                    <dt><a href="<?= Yii::app()->createUrl('news/view', array('id' => $news_top->id)); ?>" target="_blank"><img src="<?= $news_top->images; ?>" width="100" height="75" /></a></dt>
                    <dd><a href="<?= Yii::app()->createUrl('news/view', array('id' => $news_top->id)); ?>" target="_blank"> &nbsp;&nbsp;&nbsp;&nbsp;<?= Helper::truncateUtf8String(strip_tags($news_top->content), 65); ?>&nbsp;&nbsp全文</a></dd>
                </dl>
            <?php endif; ?>
            <?php if ($news_list): ?>
                <ul>
                    <?php foreach ($news_list as $value) { ?>
                        <li><h1>[<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?= $value['name']; ?></a>] <a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>" title="<?= $value['title']; ?>" target="_blank"><?= Helper::truncateUtf8String($value['title'], (28 - strlen($value['name'])/3)); ?></a></h1><span><?= substr($value['create_date'], 5, 5); ?></span></li>
                    <?php } ?>
                </ul>
            <?php endif; ?>

            <div class="tj_nmore clr"><a href="<?= Yii::app()->createUrl('news/index', array('category_id' => 1)); ?>">::MORE::</a></div>
        </div>
    </div>
    <!--首页新闻结束-->

    <!--登录框-->
    <div class="dengl_tj f_right">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/login_1.jpg" />
        <div id="login_con">
            <?php if (Yii::app()->user->id) { ?>
                <div style="padding: 10px">
                    欢迎回来，<?= Yii::app()->user->name; ?>！&nbsp;&nbsp;
                    <a href="<?= Yii::app()->createUrl('user/index'); ?>">用户中心</a>&nbsp;&nbsp;
                    <a href="<?= Yii::app()->createUrl('site/logout'); ?>">安全退出</a>
                    <?php if (Yii::app()->user->role == '管理员'): ?>
                        <br /><br /><a href="<?= $this->createUrl('admin/index') ?>" title="second">进入管理后台</a>
                    <?php endif; ?>
                </div>
            <?php } else { ?>
                <form action="<?= Yii::app()->createUrl('site/login'); ?>" method="POST" id="login_form" onsubmit="checkform()">
                    <?php if (Yii::app()->user->hasFlash('error')): ?> 
                        <div style="padding:10px;color: #FF6A6A">
                            <?= Yii::app()->user->getFlash('error'); ?> 
                        </div>
                    <?php endif; ?>
                    <dl>
                        <dt><input type="text" placeholder="用户名" id="account" name="account" tabindex="1" /></dt>
                        <dd><input type="submit" class="login_bt" id="to_login" tabindex="3" value=""></dd>
                    </dl>
                    <dl>
                        <dt><input type="password" placeholder="密码" id="pwd_prompt" name="password" tabindex="2"/></dt>
                        <dd><input type="checkbox" value="1" class="ckx" id="remember" name="rememberMe" tabindex="4" /><span>记住登录</span></dd>
                    </dl>
                    <input type="hidden" name="return_url" value="<?= $return_url;?>">
                </form>
            <?php } ?>
        </div>
        <!--登录框结束-->

        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/login_2.jpg" class="m_b14" />
        <dl class="k_dl1">
            <dt><h1>推荐校友会</h1><em></em></dt>
            <dd class="a_ml">
                <?php foreach ($alumni_list as $value) { ?>
                    <a href="<?= $value['website']; ?>" target='_blank'><img style="width: 232px; height: 65px;" src="<?= Yii::app()->request->baseUrl . $value['logo_path']; ?>" /></a>
                <?php } ?>
            </dd>
        </dl>
    </div>

    <!--ad-->
    <div class="ad_usho"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ad_7.jpg" /></div>

    <!--近期活动-->
    <div class="jqhd f_left">
        <dl class="k_dl1">
            <dt><h1>近期活动</h1><em></em><a href="<?= Yii::app()->createUrl('event'); ?>">更多</a></dt>
            <dd>
                <?php if ($event_list): ?>
                    <ul>
                        <?php foreach ($event_list as $value) { ?>
                            <li>
                                <h1 style="width: 254px; height: 28px; overflow: hidden;">
                                    [<a href="<?= Yii::app()->createUrl('alumni/view', array('id' => $value['alumni_id'])); ?>" target="_blank"><?= $value->alumni->name; ?></a>]
                                    <a href="<?= Yii::app()->createUrl('event/view', array('id' => $value['id'])); ?>" title="<?= $value['title']; ?>" target="_blank"><?= Helper::truncateUtf8String($value['title'], (19 - strlen($value->alumni->name)/3)); ?></a>
                                </h1>
                                <span><?= substr($value['start_date'], 5, 5); ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php endif; ?>
            </dd>
        </dl>
    </div>
    <!--近期活动结束-->

    <!--政策法规-->
    <div class="jqhd f_left m_l21">
        <dl class="k_dl1">
            <dt><h1>政策法规</h1><em></em><a href="<?= Yii::app()->createUrl('news/index', array('category_id' => 4)); ?>">更多</a></dt>
            <dd>
                <?php if ($laws_list): ?>
                    <ul>
                        <?php foreach ($laws_list as $value) { ?>
                        <li><h1><a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>" title="<?= $value['title']; ?>" target="_blank"><?= Helper::truncateUtf8String($value['title'], 20); ?></a></h1><span><?= substr($value['create_date'], 5, 5); ?></span></li>
                        <?php } ?>
                    </ul>
                <?php endif; ?>
            </dd>
        </dl>
    </div>
    <!--政策法规结束-->

    <div class="xiehui_dy f_right">
        <dl class="k_dl2">
            <dt><h1>地方协会</h1><em></em></dt>
            <dd class="a_xh">
                <?php if ($alumnic_list): ?>
                    <ul>
                        <?php foreach ($alumnic_list as $value) { ?>
                            <a href="<?= $value['website']; ?>" target='_blank'><?= $value['name'] ?></a>
                        <?php } ?>
                    </ul>
                <?php endif; ?>
                <div class="clr"></div>
            </dd>
        </dl>
        <a href="javascript:void(0);" id="subscibe"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/chick_dy.jpg" width="279" height="71" border="0" /></a>
    </div>
    <div class="clr"></div>
</div>
<script type="text/javascript">
    function checkform() {
        if ($('#account').val() == '用户名') {
            $('#account').css('border', '1px solid red');
            return false;
        }
        if ($('#password').val() == '') {
            $('#password').css('border', '1px solid red');
            return false;
        }
    }
</script>