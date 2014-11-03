<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>menu</title>
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_URL ?>base.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_URL ?>menu.css" type="text/css" />
        <script language='javascript'>var curopenItem = '1';</script>
        <script language="javascript" type="text/javascript" src="<?php echo ADMIN_CSS_URL ?>menu.js"></script>
        <script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jQuery-1.9.1.js"></script>
        <base target="main" />
        <script type="text/javascript">
            function disp(id) {
                var $sitemu = $(".sitemu");
                $sitemu.css('display', 'none');
                $("#nav_" + id).css('display', 'block');
            }
        </script>

    </head>
    <body target="main">
        <table width='99%' height="100%" border='0' cellspacing='0' cellpadding='0'>
            <tr>
                <td style='padding-left:3px;padding-top:8px' valign="top">
                    <!-- Item 1 Strat -->
                    <dl class='bitem'>
                        <dt onClick='showHide("items1_1")'><b>常用操作</b></dt>
                        <dd style='display:block' class='sitem' id='items1_1'>

                            <ul class='sitemu' id="nav_home" style="display:">
                                <li><a href='<?= $this->createUrl('/admin/index') ?>' target='right'>仪表盘</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/attachment') ?>' target='right'>附件管理</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/alumni') ?>' target='right'>校友会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/news') ?>' target='right'>新闻列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/event') ?>' target='right'>活动列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/monthly') ?>' target='right'>月报列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/workLog') ?>' target='right'>工作日志</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/clientLog') ?>' target='right'>客户交流日志</a> </li>
                            </ul>
                            
                            <ul class='sitemu' id="nav_base" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/alumni') ?>' target='right'>校友会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumni/create') ?>' target='right'>添加校友会</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumnic') ?>' target='right'>地方校友会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumni/baiduIndex') ?>' target='right'>更新百度指数</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumni/monthRank') ?>' target='right'>更新月排名</a></li>
                                <li style="border-top: #000000 dotted thin; background:none;padding: 0px;line-height: 0; height: 0px"></li>
                                <li><a href='<?= $this->createUrl('/admin/foundation') ?>' target='right'>基金会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/foundation/create') ?>' target='right'>添加基金会</a></li>
                                <li style="border-top: #000000 dotted thin; background:none;padding: 0px;line-height: 0; height: 0px"></li>
                                <li><a href='<?= $this->createUrl('/admin/school') ?>' target='right'>学校管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/provinces') ?>' target='right'>省份管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/genre') ?>' target='right'>办学类型管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/cities') ?>' target='right'>城市管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/company') ?>' target='right'>办学单位管理</a></li>
                            </ul>
                            
                            <ul class='sitemu' id="nav_data" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/news') ?>' target='right'>新闻列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/news/create') ?>' target='right'>添加新闻</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/category') ?>' target='right'>分类管理</a></li>
                                <li style="border-top: #000000 dotted thin; background:none;padding: 0px;line-height: 0; height: 0px"></li>
                                <li><a href='<?= $this->createUrl('/admin/event') ?>' target='right'>活动列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/event/create') ?>' target='right'>添加活动</a> </li>
                                <li style="border-top: #000000 dotted thin; background:none;padding: 0px;line-height: 0; height: 0px"></li>
                                <li><a href='<?= $this->createUrl('/admin/talk') ?>' target='right'>话题列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/talk/create') ?>' target='right'>添加话题</a> </li>
                                <li style="border-top: #000000 dotted thin; background:none;padding: 0px;line-height: 0; height: 0px"></li>
                                <li><a href='<?= $this->createUrl('/admin/tags/') ?>' target='right'>分词列表</a> </li>
                            </ul>
                            
                            <ul class='sitemu' id="nav_user" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/user') ?>' target='right'>用户管理</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/user/create') ?>' target='right'>添加用户</a></li>
                                <li><a href="<?=$this->createUrl('/admin/message')?>"  target="right">留言管理</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace')?>"  target="right">用户浏览记录</a></li>
                            </ul>
                            
                            <ul class='sitemu' id="nav_count" style="display: none">
                                 <li><a href='<?= $this->createUrl('/admin/userTrace/CountUser') ?>' target='right'>用户点击数统计</a></li>
                                <li><a href='<?= $this->createUrl('/admin/userTrace/CountNews') ?>' target='right'>新闻点击数统计</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/userTrace/CountEvent') ?>' target='right'>活动点击数统计</a></li>
                                <li><a href='<?= $this->createUrl('/admin/userTrace/CountMonthly') ?>' target='right'>月报击数统计</a></li>
                                <li><a href='<?= $this->createUrl('/admin/userTrace/MonthlyDay') ?>' target='right'>每日每周统计</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/CountTalk')?>"  target="right">讨论区点击数统计</a></li>
                               <li><a href='<?= $this->createUrl('/admin/userTrace/CountAlumni') ?>' target='right'>校友会点击数统计</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/userTrace/CountSearch') ?>' target='right'>搜索统计</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/CountModel')?>"  target="right">模块点击数统计</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/Diagram')?>"  target="right">曲线图统计</a></li>
                            </ul>
                            
                           <ul class='sitemu' id="nav_users" style="display: none">
                                <li><a href="<?=$this->createUrl('/admin/userTrace/OldUser')?>"  target="right">老用户</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/NewUser')?>"  target="right">新用户</a></li>
                                <li><a href="<?=$this->createUrl('/admin/user/PotentialUser')?>"  target="right">潜在用户</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/ActiveUser')?>"  target="right">活跃用户</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/NewUserLost')?>"  target="right">流失新用户</a></li>
                                <li><a href="<?=$this->createUrl('/admin/userTrace/OldUserLost')?>"  target="right">流失老用户</a></li>
                           </ul>
                            
                            <ul class='sitemu' id="nav_periodical" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/monthly') ?>' target='right'>月报列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/monthly/create') ?>' target='right'>添加月报</a> </li>
                                <li style="border-top: #000000 dotted thin; background:none;padding: 0px;line-height: 0; height: 0px"></li>
                                <li><a href='<?= $this->createUrl('/admin/monthlyTemplate') ?>' target='right'>模板列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/monthlyTemplate/create') ?>' target='right'>添加模板</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/attachment') ?>' target='right'>附件管理</a> </li>
                            </ul>
                            
                            <ul class='sitemu' id="nav_about" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/about') ?>' target='right'>介绍信息</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/about/create') ?>' target='right'>添加介绍</a> </li>
                                <li><a href="<?=$this->createUrl('/admin/product')?>" target="right">产品介绍</a></li>
                            </ul>
                            
                            <ul class='sitemu' id="nav_mail" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/mail') ?>' target='right'>邮件管理</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/mail/template') ?>' target='right'>邮件模板</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/mail/column_style') ?>' target='right'>栏目样式</a> </li>
                                <li><a href="<?=$this->createUrl('/admin/mail')?>" target="right">发送记录</a></li>
                                <li><a href="<?=$this->createUrl('/admin/mail')?>" target="right">使用帮助</a></li>

                            </ul>

                            <!--<ul class='sitemu' id="nav_news" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/news') ?>' target='right'>新闻列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/news/create') ?>' target='right'>添加新闻</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/category') ?>' target='right'>分类管理</a></li>
                            </ul>

                            <ul class='sitemu' id="nav_event" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/event') ?>' target='right'>活动列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/event/create') ?>' target='right'>添加活动</a> </li>
                            </ul>

                            <ul class='sitemu' id="nav_user" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/user') ?>' target='right'>用户管理</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/user/create') ?>' target='right'>添加用户</a></li>
                                <li><a href='<?= $this->createUrl('/admin/userTrace') ?>' target='right'>用户浏览记录</a></li>
                            </ul>

                            <ul class='sitemu' id="nav_school" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/school') ?>' target='right'>学校管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/provinces') ?>' target='right'>省份管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/genre') ?>' target='right'>办学类型管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/cities') ?>' target='right'>城市管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/company') ?>' target='right'>办学单位管理</a></li>
                            </ul>

                            <ul class='sitemu' id="nav_alumni" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/alumni') ?>' target='right'>校友会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumni/create') ?>' target='right'>添加校友会</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumnic') ?>' target='right'>地方校友会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumni/baiduIndex') ?>' target='right'>更新百度指数</a></li>
                                <li><a href='<?= $this->createUrl('/admin/alumni/monthRank') ?>' target='right'>更新月排名</a></li>
                            </ul>

                            <ul class='sitemu' id="nav_foundation" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/foundation') ?>' target='right'>基金会管理</a></li>
                                <li><a href='<?= $this->createUrl('/admin/foundation/create') ?>' target='right'>添加基金会</a></li>
                            </ul>

                            <ul class='sitemu' id="nav_monthly" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/monthly') ?>' target='right'>月报列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/monthly/create') ?>' target='right'>添加月报</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/sendmail') ?>' target='right'>模板管理</a> </li>
                            </ul>

                            <ul class='sitemu' id="nav_about" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/about') ?>' target='right'>介绍信息</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/about/create') ?>' target='right'>添加介绍</a> </li>
                            </ul>

                            <ul class='sitemu' id="nav_monthly_template" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/monthlyTemplate') ?>' target='right'>模板列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/monthlyTemplate/create') ?>' target='right'>添加模板</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/attachment') ?>' target='right'>附件管理</a> </li>
                            </ul>-->

                            <ul class='sitemu' id="nav_weibo_status" style="display: none">
                                <li><a href='<?= $this->createUrl('/admin/Weibostatus') ?>' target='right'>微博列表</a> </li>
                                <li><a href='<?= $this->createUrl('/admin/Weibostatus/capture') ?>' target='right'>一键操作</a> </li>
                            </ul>

                        </dd>
                    </dl>
                </td>
            </tr>
        </table>
    </body>
</html>