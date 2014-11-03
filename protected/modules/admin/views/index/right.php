<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>main</title>
        <base target="_self">
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_URL ?>base.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_URL ?>main.css" />
    </head>
    <body leftmargin="8" topmargin='8'>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td><div style='float:left'> <img height="14" src="<?php echo ADMIN_IMG_URL ?>book1.gif" width="20" />&nbsp;欢迎使用内容管理系统，建站的首选工具。 </div>
                    <div style='float:right;padding-right:8px;'>
                        <!--  //保留接口  -->
                    </div></td>
            </tr>
            <tr>
                <td height="1" background="<?php echo ADMIN_IMG_URL ?>sp_bg.gif" style='padding:0px'></td>
            </tr>
        </table>

        <table width="98%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px">
            <tr>
                <td colspan="2" background="<?php echo ADMIN_IMG_URL ?>wbg.gif" bgcolor="#EEF4EA" class='title'>
                    <div style='float:left'><span>快捷操作</span></div>
                    <div style='float:right;padding-right:10px;'></div>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td height="30" colspan="2" align="center" valign="bottom"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                        <tr>
                            <td width="15%" height="31" align="center"><img src="<?php echo ADMIN_IMG_URL ?>qc.gif" width="90" height="30" /></td>
                            <td width="85%" valign="bottom">

                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>menuarrow.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('news/index') ?>'><u>新闻管理</u></a></div>
                                </div>
                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>manage1.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('school/index') ?>'><u>学校管理</u></a></div>
                                </div>
                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>file_dir.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('user/index') ?>'><u>用户管理</u></a></div>
                                </div>
                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>part-index.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('monthly/index') ?>'><u>刊物管理</u></a></div>
                                </div>
                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>manage1.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('email/index') ?>'><u>邮件管理</u></a></div>
                                </div>
                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>manage1.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('userTrace/MonthlyDay') ?>'><u>每日、每周、每月用户访问统计数</u></a></div>
                                </div>
                                <div class='icoitem'>
                                    <div class='ico'><img src='<?php echo ADMIN_IMG_URL ?>manage1.gif' width='16' height='16' /></div>
                                    <div class='txt'><a href='<?= $this->createUrl('userTrace/email') ?>'><u>各期邮件点击率</u></a></div>
                                </div>
                            </td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <table width="98%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px">
            <tr bgcolor="#EEF4EA">
                <td colspan="8" background="<?php echo ADMIN_IMG_URL ?>wbg.gif" class='title'><span>系统基本信息</span></td>
            </tr>
            <tr bgcolor="#FFFFFF" align="center">
                 <td><?=date("m-d",strtotime("-7 day"))?> <?=date('l',strtotime("-7 day"))?></td>
                 <td><?=date("m-d",strtotime("-6 day"))?> <?=date('l',strtotime("-6 day"))?></td>
                 <td><?=date("m-d",strtotime("-5 day"))?> <?=date('l',strtotime("-5 day"))?></td>
                 <td><?=date("m-d",strtotime("-4 day"))?> <?=date('l',strtotime("-4 day"))?></td>
                 <td><?=date("m-d",strtotime("-3 day"))?> <?=date('l',strtotime("-3 day"))?></td>
                 <td><?=date("m-d",strtotime("-2 day"))?> <?=date('l',strtotime("-2 day"))?></td>
                 <td><?=date("m-d",strtotime("-1 day"))?> <?=date('l',strtotime("-1 day"))?></td>
                  <td>今天访问人数</td>
                
            </tr>
            <tr bgcolor="#FFFFFF" align="center">
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=7')?></font></td>
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=6')?></font></td>
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=5')?></font></td>
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=4')?></font></td>
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=3')?></font></td>
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=2')?></font></td>
                <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())-TO_DAYS(create_date)=1')?></font></td>
                 <td><font color="red"><?=  UserTrace::model()->countBySql('SELECT count(DISTINCT user_id) from user_trace where TO_DAYS(NOW())=TO_DAYS(create_date)')?></font></td>
            </tr>
        </table>
        <table width="98%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px">
            <tr bgcolor="#FFFFFF" align="center">
                 <td>本周邮件总点击次数</td>
                 <td>本期总访问量(独立ip)</td>
                 <td>本周邮件用户点击率统计(点击的用户占总发送的用户数比例)</td>
                
            </tr>
            <tr bgcolor="#FFFFFF" align="center">
                 <td><font color="red"><?=  UserTrace::model()->countBySql('select count(*) from user_trace where  monthly_id=(select max(id) from usho_mail)' )?></font></td>
                 <td><font color="red"><?=  UserTrace::model()->countBySql('select count(DISTINCT ip) from user_trace where  monthly_id=(select max(id) from usho_mail) ' )?></font></td>
                 <td><font color="red">
                     <?php $i= UserTrace::model()->countBySql('select count(DISTINCT user_id) from user_trace where  monthly_id=(select max(id) from usho_mail)')?>
                     <?php $t=Mail::model()->countBySql('select count(id) from user where is_subscription=1')?> 
                      <?php $a=($i/$t)*100;?>
                       <?=  substr($a, 0,4);?>%
                     </font></td>
           </tr>
        </table>
        <table width="98%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px">
            <tr bgcolor="#FFFFFF" align="center">
                 <td>上周周邮件总点击次数</td>
                 <td>上期总访问量(独立ip)</td>
                 <td>上周邮件用户点击率统计(点击的用户占总发送的用户数比例)</td>
                
            </tr>
            <tr bgcolor="#FFFFFF" align="center">
                 <td><font color="red"><?=  UserTrace::model()->countBySql('select count(*) from user_trace where  monthly_id=(select max(id)-1 from usho_mail)' )?></font></td>
                 <td><font color="red"><?=  UserTrace::model()->countBySql('select count(DISTINCT ip) from user_trace where  monthly_id=(select max(id)-1 from usho_mail) ' )?></font></td>
                 <td><font color="red">
                     <?php $i= UserTrace::model()->countBySql('select count(DISTINCT user_id) from user_trace where  monthly_id=(select max(id)-1 from usho_mail)')?>
                     <?php $t=Mail::model()->countBySql('select count(id) from user where is_subscription=1')?> 
                      <?php $a=($i/$t)*100;?>
                       <?=  substr($a, 0,4);?>%
                     </font></td>
           </tr>
        </table>
    </body>
</html>