<?php /* @var $this Controller */ ?>
<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index'): ?><?= CHtml::encode($this->pageTitle); ?> — 中国高校校友会动态信息展示及交流中心 <?php else: ?><?= CHtml::encode($this->pageTitle); ?> - <?= Common::yiiparam('site_name') ?><?php endif; ?></title>
        <meta name="Keywords" content="<?= Common::yiiparam('keywords') ?>"/>
        <meta name="Description" content="<?= Common::yiiparam('description') ?>"/> 
        <link href="<?= Yii::app()->request->baseUrl; ?>/static/css/style.css" type="text/css" rel="stylesheet" />
        <!--[if IE 6]>
        <script src="<?= Yii::app()->request->baseUrl; ?>/static/js/DD_belatedPNG.js"></script>
        <script>DD_belatedPNG.fix("*");</script>
        <![endif]-->
        <script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jQuery-1.9.1.js"></script>
        <script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/global.js"></script>
        <script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/layer/layer.min.js"></script>
    </head>

    <body>
        <!--header-->
        <div class="tbg">
            <div class="m tbg_t">
                <?php if (Yii::app()->user->id) { ?>
                    <span class="h_logined">亲爱的 <a href="<?= Yii::app()->createUrl('user'); ?>"><font><?= Yii::app()->user->name; ?></font></a> ,您好! <a href="<?= Yii::app()->createUrl('user'); ?>">用户中心</a> <a href="<?= Yii::app()->createUrl('site/logout'); ?>">退出</a></span> 
                <?php } elseif ($this->userInfo) { ?>
                    <span class="h_logined">亲爱的 <font><?= $this->userInfo->name; ?></font> 老师 ,您好! <a href="javascript:void(0);" onclick="ajaxLoginForm('<?= Yii::app()->createUrl('site/ajaxLogin', array('uid'=>$this->userInfo->id)) ; ?>');">登陆</a></span>
                <?php } else { ?>
                    <span>
                        <a href="javascript:void(0);" onclick="ajaxLoginForm('<?= Yii::app()->createUrl('site/ajaxLogin') ; ?>');">登陆</a>
                        <!--<a href="<?= Yii::app()->createUrl('site/login'); ?>" class="h_login">登陆</a>
                        <a href="#" class="h_reg">注册</a>-->
                    </span>
                <?php } ?>
                <span><a href="javascript:void(0);" id="fav">收藏本站</a>|<a href="javascript:void(0);" id="addHomePage">设为首页</a>|<a href="">意见反馈</a></span>

                <!--<?php if(!Yii::app()->session['weibouser']){ ?>
                <a href="<?=$this->getWeiboCodeUrl() ?>"><img src="<?= Yii::app()->baseUrl ?>/static/images/loginbtn_03.png" title="点击进入授权页面" alt="点击进入微博授权页面|登陆" border="0" style="margin-top:5px; float:right;" /></a>
                <?php }else{ ?>-->
                <!--待认证通过后启用
                <span style="float:right;"><a href="http://www.weibo.com/u/<?php //=Yii::app()->session['weibouser']['uid']?>" target="_blank" ><?php //=Yii::app()->session['weibouser']['name']?></a>,<a href="<?php //=Yii::app()->request->baseUrl; ?>/site/logout.html">退出</a></span>
                <img src="<?php //=Yii::app()->session['weibouser']['avatar_hd']?>" border="0" style="width:20px; height:20px;margin-top:7px; float:right;border-radius: 2px;" />
                -->
                <!--<span style="float:right;"><a href="http://www.weibo.com/u/<?=Yii::app()->session['weibouser']['uid']?>" target="_blank" ><?=Yii::app()->session['weibouser']['uid']?></a>,<a href="<?= Yii::app()->request->baseUrl; ?>/site/logout.html">退出</a></span>-->
                <img src="<?= Yii::app()->baseUrl ?>/static/images/share_icon_mini.png" border="0" style="width:20px; height:20px;margin-top:7px; float:right;border-radius: 2px;" />
                <!--<?php } ?>-->

            </div>
        </div>
        <div class="m h_93">
            <div class="logo"></div>
            <div class="search">
                <form action="<?= Yii::app()->createUrl('site/searchsite'); ?>" method="POST" id="search_site">
                    <a href="javascript:void(0);" onclick="$('#search_site').submit();"></a>
                    <div class="textbg">
                        <select name="model" id="model">
                            <option value="news" selected="selected">新闻</option>
                            <option value="event">活动</option>
                            <option value="monthly">月报</option>
                            <option value="weibo">微博</option>
                        </select>
                        <input type="text" id="keyword" name="keyword" placeholder="省份、学校全称、标题" required />
                    </div>
                </form>
            </div>
        </div>
        <div class="m h_41">
            <div class="m menu_bg">
                <ul class="menu_ul">
                    <li class="<?= Yii::app()->controller->id === 'site' ? 'on' : ''; ?>"><a href="/site/index"><em>首页</em></a></li>
                    <li class="<?= Yii::app()->controller->id === 'news' ? 'on' : ''; ?>"><a href="/news/index"><em>新闻动态</em></a></li>
                    <li class="<?= Yii::app()->controller->id === 'event' ? 'on' : ''; ?>"><a href="/event/index"><em>校友活动</em></a></li>
                    <li class="<?= Yii::app()->controller->id === 'monthly' ? 'on' : ''; ?>"><a href="/monthly/index"><em>友笑周报</em></a></li>
                    <li class="<?= Yii::app()->controller->id === 'alumni' ? 'on' : ''; ?>"><a href="/alumni/index"><em>校友会导航</em></a></li>
                    <li class="<?= Yii::app()->controller->id === 'talk' ? 'on' : ''; ?>"><a href="/talk/talk"><em >聊天室（<font class="count"></font>）</em></a></li>
                    <li class="<?= Yii::app()->controller->id === 'weibo' ? 'on' : ''; ?>"><a href="/weibo/index"><em>校友微博</em></a></li>
                </ul>
            </div>
        </div>
        <div class="m h_14"></div>

        <?php echo $content; ?>

        <!--link-->
        <div class="m link_div m_b14">
            <a href="<?= Yii::app()->createUrl('about/index'); ?>">关于我们</a>  ｜  <a href="<?= Yii::app()->createUrl('about/product'); ?>">服务内容</a>  ｜  <a href="<?= Yii::app()->createUrl('about/solution'); ?>">技术支持</a>  ｜  <a href="#">站点地图</a>  ｜  <a href="<?= Yii::app()->createUrl('about/contact'); ?>">联系方式</a>
        </div>

        <!--footer-->
        <div class="m footer">
            <dl>
                <dt><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/logo_footer.png" width="131" height="33" /></dt>
                <dd>
                    联系信箱：ushosales@163.com  地址：杭州西湖区西溪路525号浙大科技园C楼608室<br /> 
                    版权所有  中国高校校友会信息网 l  Chinese university alumni association information network <br />
                    邮编：310058  浙ICP备12021015号-2 技术支持：友笑网络

                </dd>
                <div style="display: none;">
                    <script type="text/javascript">
                        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F19238b154fc2b198f57167bb776be87b' type='text/javascript'%3E%3C/script%3E"));
                    </script>
                </div>
            </dl>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                //添加到收藏夹
                jQuery.fn.addFavorite = function(l, h) {
                    var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL';
                    return this.click(function() {
                        var t = jQuery(this);
                        if (jQuery.browser.msie) {
                            window.external.addFavorite(h, l);
                        } else if (jQuery.browser.mozilla || jQuery.browser.opera) {
                            t.attr("rel", "sidebar");
                            t.attr("title", l);
                            t.attr("href", h);
                        } else {
                            alert("添加失败 = =!\n请使用" + ctrl + " + D 将本页加入收藏夹！");
                        }
                    });
                }
                $('#fav').addFavorite(document.title, location.href);

                //设置主页  
                $("#addHomePage").click(function() {
                    if (document.all) {//设置IE  
                        document.body.style.behavior = 'url(#default#homepage)';
                        document.body.setHomePage(location.href);
                    } else {
                        alert("设置首页失败，请手动设置！");
                    }
                })
                
                //2014-06-10 主导航跟屏
                $(document).scroll(function() {
                    var wz_num = $(window).scrollTop();
                    if(wz_num >=126){
                        $('.menu_bg').removeClass('menu_stop');
                        $('.menu_bg').addClass('menu_start');
                    }else{
                        $('.menu_bg').addClass('menu_stop');
                        $('.menu_bg').removeClass('menu_start');
                    }
                });
            })
        </script>
    </body>
</html>
<script type="text/javascript">
    jQuery(function($) {
    var List = $('.count');
    function updateUser(){
        List.html("Loading...");
        $.ajax({
            url: "<?= $this->createUrl('/talk/count') ?>",
            dataType: 'json',
            cache: false,
            success: function(data) {
                var out = "";
                $(data).each(function(){
                 out+=this.user_id;
                });
                List.html(out);
            }
        });
    }
    updateUser();
    setInterval(function(){
        updateUser()
    }, 60000);
});        
            
            
</script>