<div id="page_head"> 
    <p class="title" style="width: 300px"><?= $mail->name?> — 模块管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create_module',array('mail_id'=>$mail->id)) ?>" class="btn btn-green">新建模块</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="7" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;模块列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="20%" align="left">模块名称</td>
            <td width="25%" >模块样式</td>
            <td width="10%">文章篇数</td>
            <td width="10%">预览</td>
            <td width="10%">添加文章</td>
            <td width="20%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td><?php echo $r->id; ?></td>
                <td align="left"><a href="<?= $this->createUrl('update_module', array("id" => $r->id,'mail_id'=>$r->mail_id)) ?>"><?php echo $r->name; ?></a></td>
                <td align="center"><?= $r->style?$r->style->name:'-';?></td>
                <td align="center"><a href="<?= $this->createUrl('content', array("mail_id"=>$r->mail_id,"module_id" => $r->id)) ?>" title="点击查看"><?= $r->contentCount ?>篇</a></td>
                <td  align="center"><a href="<?= $this->createUrl('setting', array("id" => $r->id)) ?>">预览</a></td>

                <td  align="center">
                    <a href="<?= $this->createUrl('create_content', array("mail_id"=>$r->mail_id,"module_id" => $r->id)) ?>">添加文章</a>
                </td>

                <td  align="center">
                    <a href="<?= $this->createUrl('update_module', array("id" => $r->id,'mail_id'=>$r->mail_id)) ?>">修改</a> | 
                    <a href="<?= $this->createUrl('delete_module', array("id" => $r->id)) ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="7" align="center">
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

