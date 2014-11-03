<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
        <title>top</title>
        <script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jQuery-1.9.1.js"></script>
        <link href="<?php echo ADMIN_CSS_URL ?>base.css" rel="stylesheet" type="text/css">
            <style>
                body { padding:0px; margin:0px; }
                #nav {
                    color: #009933;
                    margin:0px;
                    padding:0px;
                    float:right;
                    padding-right:10px;
                    margin-bottom:4px;
                    margin-bottom:10px\9
                }

                #nav li{
                    float:left;
                    width:100px;
                    list-style:none;
                }

                #nav li.item {
                    text-align:center;
                    background:url(<?php ADMIN_IMG_URL ?>topitembg.gif) 0px 3px no-repeat;
                    width:82px;
                    height:26px;
                    line-height:28px;
                }

                #nav li.item:hover,#nav li.itemsel {
                    width:80px;
                    text-align:center;
                    background:#226411;
                    border-left:1px solid #c5f097;
                    border-right:1px solid #c5f097;
                    border-top:1px solid #c5f097;
                    height:26px;
                    line-height:28px;
                }

                *html .itemsel {
                    height:26px;
                    line-height:26px;
                }
                
                
                a:link,a:visited,a:hover {
                    text-decoration: underline;
                }

                .item a:link, .item a:visited {
                    font-size: 12px;
                    color: #ffffff;
                    text-decoration: none;
                    font-weight: bold;
                    display:block
                }

                .itemsel a:hover {
                    color: #ffffff;
                    font-weight: bold;
                    text-decoration: underline;
                    display:block
                }

                .itemsel a:link, .itemsel a:visited {
                    font-size: 12px;
                    color: #ffffff;
                    text-decoration: none;
                    font-weight: bold;
                    display:block
                }

            </style>
    </head>
    <body bgColor='#ffffff'>
        <table style="width: 100%;height:60px" border="0" cellpadding="0" cellspacing="0" background="<?php echo ADMIN_IMG_URL ?>topbg.gif">
            <tr>
                <td width='20%' style="height:60px"><img src="<?php echo ADMIN_IMG_URL ?>logo.gif" /></td>
                <td width='80%' align="right" valign="bottom" >
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:28px">
                        <tr>
                            <td align="right" style="padding-right:10px;line-height:28px;">
                                您好：<span class="username"><?= Yii::app()->user->name;?></span>，欢迎使用内容管理系统！
                                [<a href="<?= Yii::app()->homeUrl?>" target="_blank">网站主页</a>]
                                [<a href="" target="_blank">修改密码</a>]
                                [<a href="loginout" target="_top">注销退出</a>]&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td align="right" >
                                <ul id="nav">
                                    <li class='itemsel' nav="home"><a href="<?=$this->createUrl('/admin/index/right')?>"  target="right">管理首页</a></li>
                                    <li class='item' nav="base"><a href="<?=$this->createUrl('/admin/alumni')?>" target="right">基础管理</a></li>
                                    <li class='item' nav="data"><a href="<?=$this->createUrl('/admin/news')?>" target="right">信息管理</a></li>
                                    <li class='item' nav="user"><a href="<?=$this->createUrl('/admin/user')?>" target="right">用户管理</a></li>
                                    <li class='item' nav="count"><a href="<?=$this->createUrl('/admin/userTrace/CountUser')?>" target="right">访问统计</a></li>
                                    <li class='item' nav="users"><a href="<?=$this->createUrl('/admin/userTrace/OldUser')?>"  target="right">用户指标</a></li>
                                    <li class='item' nav="periodical"><a href="<?=$this->createUrl('/admin/monthly')?>" target="right">刊物管理</a></li>
                                    <li class='item' nav="mail"><a href="<?=$this->createUrl('/admin/mail')?>" target="right">邮件系统</a></li>
                                    <li class='item' nav="about"><a href="<?=$this->createUrl('/admin/about')?>"  target="right">关于我们</a></li>
                                    
                                    
                                    
                                    <!--<li class='item' nav="news"><a href="<?=$this->createUrl('/admin/news')?>" target="right">新闻管理</a></li>
                                    <li class='item' nav="event"><a href="<?=$this->createUrl('/admin/event')?>" target="right">活动管理</a></li>
                                    <li class='item' nav="school"><a href="<?=$this->createUrl('/admin/school')?>" target="right">学校管理</a></li>
                                    <li class='item' nav="alumni"><a href="<?=$this->createUrl('/admin/alumni')?>" target="right">校友会管理</a></li>
                                    <li class='item' nav="foundation"><a href="<?=$this->createUrl('/admin/foundation')?>" target="right">基金会管理</a></li>
                                     <li class='item' nav="user"><a href="<?=$this->createUrl('/admin/user')?>" target="right">用户管理</a></li>
                                     <li class='item' nav="monthly"><a href="<?=$this->createUrl('/admin/monthly')?>" target="right">月刊管理</a></li>
                                     <li class='item' nav="monthly_template"><a href="<?=$this->createUrl('/admin/monthlyTemplate')?>" target="right">模板管理</a></li>
                                     <li class='item' nav="message"><a href="<?=$this->createUrl('/admin/message')?>"  target="right">留言管理</a></li>
                                     <li class='item' nav="product"><a href="<?=$this->createUrl('/admin/product')?>" target="right">产品介绍</a></li>
                                    <li class='item' nav="about"><a href="<?=$this->createUrl('/admin/about')?>"  target="right">公司介绍</a></li>-->
                                    <li class='item' nav="weibo_status"><a href="<?=$this->createUrl('/admin/Weibostatus')?>"  target="right">微博管理</a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

<script language="javascript">
    var $item = $("#nav li");
    $(document).ready(function() {
        $item.click(function() {
            $item.removeClass('itemsel').addClass('item');
            $(this).addClass('itemsel');
            parent.left.disp($(this).attr("nav"));
        });
    });
</script>