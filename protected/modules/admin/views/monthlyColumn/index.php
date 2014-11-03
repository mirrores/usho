<div id="page_head"> 
    <p class="title">添加月报栏目</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create', array("monthly_id" => $monthly_id)) ?>" class="btn btn-green">添加月报栏目</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;月报列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="40%">月报栏目名称</td>
            <td width="30%">所属月报</td>
            <td width="10%">排序</td>
            <td width="15%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td><?php echo $r->id; ?></td>
                <td align="left"><a href="<?= $this->createUrl('update', array("id" => $r->id, 'monthly_id' => $monthly_id)) ?>"><?php echo $r->name; ?></a></td>
                <td><?php echo Monthly::model()->findByPk($r->monthly_id)->name; ?></td>
                <td><?php echo $r->order_num; ?></td>
                <td><a href="<?= $this->createUrl('update', array("id" => $r->id, "monthly_id" => $monthly_id)) ?>">编辑</a> | <a href="<?= $this->createUrl('delete', array("id" => $r->id, 'monthly_id' => $monthly_id)) ?>">删除</a></td>
            </tr>
        <?php endforeach; ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="8" align="center">
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
                        关键字：
                    </td>
                    <td>
                        <input type='text' name='keyword' value='<?php echo $keyword ?>' style='width:250px' />
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
