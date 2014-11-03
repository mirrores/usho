<div id="page_head"> 
    <p class="title">用户管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create') ?>" class="btn btn-green">添加用户</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="9" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;用户列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="6%">ID</td>
            <td width="7%">用户姓名</td>
            <td width="15%">用户账号</td>
            <td width="15%">所属校友会</td>
            <td width="6%">省份</td>
            <td width="7%">用户职位</td>
            <td width="15%">电话</td>
            <td width="5%">是否订阅</td>
            <td width="10%">操作</td>
        </tr>
        <?php
        foreach ($records as $r) {
            ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td><?= $r->id; ?></td>
                <td><?= $r->name ?></td>
                <td align="left"><?= $r->account; ?></td>
                <td><?= $r->alumni ? $r->alumni->name : '--'; ?></td>
                <td><?= isset($r->alumni->school->provinces->name) ? $r->alumni->school->provinces->name : '--' ?></td>
                <td><?= $r->position; ?></td>
                <td><?= $r->tel; ?></td>
                <td>
                <input type="checkbox" value="1" onclick="switchBoolean(<?= $r->id ?>,'is_subscription');" <?= $r->is_subscription?'checked':'' ?> /></td>
                <td><a href="<?= $this->createUrl('update',array('id'=>$r->id))?>" target="_blank">修改</a> | <a href="<?= $this->createUrl('delete',array('id'=>$r->id))?>">删除</a></td>
            </tr>
        <?php } ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="9" align="center"><!--翻页代码 -->
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

<script type="text/javascript">
    function switchBoolean(id,field){
        $.ajax({
            url: '<?= $this->createUrl('switchBoolean')?>',
            type: 'get',
            data: 'id='+id+'&field='+field
        });
    }
</script>
