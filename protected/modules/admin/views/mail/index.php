<div id="page_head"> 
    <p class="title">邮件群发</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create') ?>" class="btn btn-green">新增邮件</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="8" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;邮件列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="30%" align="left">邮件标题</td>
            <td width="15%">邮件模板</td>
            <td width="10%">发送对象</td>
            <td width="5%">发送预览</td>
            <td width="5%">已发送</td>
            <td width="10%">栏目内容管理</td>
            <td width="10%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td><?php echo $r->id; ?></td>
                <td align="left"><a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>"  ><?php echo $r->subject; ?></a></td>
                <td align="center"><?= $r->template?$r->template->name:'未指定';?></td>
                <td align="center"><?= $r->userList?$r->userList->name:'所有'; ?></td>
                <td align="center"><?php if ($r->template_id): ?><a href="<?= $this->createUrl('preview', array("id" => $r->id)) ?>" target="_blank">预览</a><?php else: ?>-<?php endif; ?></td>
                <td align="center"><a href="<?= $this->createUrl('logs', array("mail_id" => $r->id)) ?>" ><?= $r->logsCount?>份</a></td>
                <td  align="center">
                    <?php if($r->content_type=='column'):?>
                    <a href="<?= $this->createUrl('columns', array("mail_id" => $r->id)) ?>" title="点击设计栏目和内容" >栏目管理</a>
                    <?php else:?>
                    <a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>"  >自定义内容</a>
                    <?php endif;?>
                </td>
                <td  align="center">
                    <a href="<?= $this->createUrl('copy', array("id" => $r->id)) ?>" title="复制为一份新邮件，包含栏目及配置">复制</a> | <a href="<?= $this->createUrl('delete', array("id" => $r->id)) ?>">删除</a>
                </td>
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

