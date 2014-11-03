<div id="page_head"> 
    <p class="title">基金会管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create') ?>" class="btn btn-green">添加基金会</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="6" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;文档列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="15%">基金会名称</td>
            <td width="20%">所属学校</td>
            <td width="10%">所属省份</td>
            <td width="30%">网址</td>
            <td width="20%">操作</td>
        </tr>
        <?php
        foreach ($records as $_s):
            ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $_s->id; ?></td>
                <td align="center"><?= $_s->name; ?></td>
                <td align="center"><?= $_s->school ? $_s->school->name : null ?></td>
                <td align="center"><?= $_s->school->provinces ? $_s->school->provinces->name : null ?></td>
                <td align="left"><a href="<?= $_s->website; ?>" target="_blank"><?= $_s->website; ?></a></td>
                <td><a href="<?= $this->createUrl('update', array("id" => $_s->id)); ?>" target="_blank">编辑</a> | <a href="<?= $this->createUrl('delete', array("id" => $_s->id)); ?>">删除</a></td>
            </tr>
        <?php endforeach; ?>
        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="6" align="center"><!--翻页代码 -->
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
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
    <tr bgcolor='#EEF4EA'>
        <td background='<?php echo ADMIN_IMG_URL ?>wbg.gif' align='center'>
            <table border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        大学名称：
                    </td>
                    <td>
                        <input type='text' name='keyword' value='<?= $keyword; ?>' style='width:250px' />  
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