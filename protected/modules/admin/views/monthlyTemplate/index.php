<div id="page_head"> 
    <p class="title">模板管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create')?>" class="btn btn-green">添加</a></li>
    </ul>
</div>


<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="4" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;文档列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="4%">ID</td>
            <td width="35%" style="padding-left: 20px; text-align: left">模板名称</td>
            <td width="10%" >预览</td>
            <td width="10%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr  bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $r->id; ?></td>
                <td style="padding-left: 20px"><a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>"><?php echo $r->name; ?></a></td>
                <td align="center"><a href="<?= $this->createUrl('preview', array("id" => $r->id)) ?>">预览</td>
                <td align="center"><a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>">编辑</a> | <a href="<?= $this->createUrl('delete', array("id" => $r->id)) ?>">删除</a></td>
            </tr>
        <?php endforeach; ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="4" align="center">
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
