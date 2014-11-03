<div id="page_head"> 
    <p class="title">用户记录</p>
</div>
<!--  内容列表   -->
<form name="form2" style="clear:both;">

    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="3%">ID</td>
            <td width="4%">用户名</td>
            <td width="8%">所属学校</td>
            <td width="5%">省份</td>
            <td width="20%">备注信息</td>
            <td width="10%">搜索的关键字</td>
            <td width="7%">查看的模块</td>
            <td width="21%">查看的内容</td>
            <td width="10%">ip地址</td>
            <td width="12%">查看的时间</td>
        </tr>
        <?php
        foreach ($records as $u):
            ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td><?= $u->id; ?></td>
                <td><a href="<?= $this->createUrl('clientLog/index', array('client_id' => $u['user_id'])); ?>"><?= $u['user']['name']; ?></a></td>
                <td><a href="<?= $this->createUrl('clientLog/index', array('alumni_id' => $u->user->alumni_id)); ?>"><?= $u->user->alumni->name ?></a></td>
                <td><?= isset($u->user->alumni->school->provinces->name) ? $u->user->alumni->school->provinces->name : '' ?></td>
                <td><?= $u['user']['note']; ?></td>
                <td><?= $u['keyword']; ?></td>
               <td><?=$u['controller'];?>/<?=$u['action']?></td>
                <?php
                if ($u['controller'] == "news" && $u['controller'] != "event" && $u['action'] == "view") {
                    $u['news_id'] = $u['data_id']
                    ?>
                    <td><?= $u['news']['title']; ?></td>
                <?php } elseif ($u['controller'] == "event" && $u['controller'] != "news" && $u['action'] == "view") {
                    $u['event_id'] = $u['data_id']
                    ?>
                    <td><?= $u['event']['title']; ?></td>
                    <?php } elseif ($u['controller'] == "talk" && $u['controller'] != "news" && $u['controller'] != "event" && $u['action'] == "view") {
                    ?>
                    <td><?= $u['talk']['title']; ?></td>
                <?php } else { ?>
                    <td></td>
    <?php } ?>
                <td><?= $u->ip; ?></td>
                <td><?= $u['create_date'] ?></td>
            </tr>
            <?php
        endforeach;
        ?>





        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="10" align="center"><!--翻页代码 -->
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
            </td>
        </tr>
    </table>

</form>
<!--  搜索表单  -->
<?php $form = $this->beginWidget('CActiveForm') ?>
<input type='hidden' name='dopost' value='' />
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
    <tr bgcolor='#EEF4EA'>
        <td background='<?php echo ADMIN_IMG_URL ?>wbg.gif' align='center'>
            <table border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        用户姓名/学校关键字：
                    </td>
                    <td>
                        <input type='text' name='keyword' value="<?= $keyword; ?>" style='width:250px' />
                    </td>
                    <td width="10"></td>
                    <td>
                        <input name="imageField" type="image" src="<?php echo ADMIN_IMG_URL ?>search.gif" width="45" height="20" border="0" class="np" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $this->endwidget(); ?>