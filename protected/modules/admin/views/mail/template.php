<div id="page_head"> 
    <p class="title" style="width: 300px">邮件模板管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create_template') ?>" class="btn btn-green">新建模板</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="4" >&nbsp;所有模板&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="15%" align="left">模板名称</td>
            <td width="60%" align="left">介绍</td>
            <td width="20%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr align='center' bgcolor="#FFFFFF" height="22" >
                <td><?php echo $r->id; ?></td>
                <td align="left"><a href="<?= $this->createUrl('update_template', array("id" => $r->id)) ?>"><?php echo $r->name; ?></a></td>
                <td align="left"><?= $r->intro; ?></td>
                <td  align="center">
                    <a href="<?= $this->createUrl('update_template', array("id" => $r->id)) ?>">修改</a> | 
                    <a href="<?= $this->createUrl('copy_template', array("id" => $r->id)) ?>" title="复制一个新的邮件模板">复制</a> | 
                    <a href="<?= $this->createUrl('delete_template', array("id" => $r->id)) ?>">删除</a>
                </td>
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

