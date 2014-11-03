<div id="page_head"> 
    <p class="title">发送日志</p>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="7" >&nbsp;日志列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="25%" align="left">邮件标题/预览</td>
            <td width="5%">用户</td>
            <td width="12%">发送日期</td>
            <td width="15%">发送邮局</td>
            <td width="15%">发送状态</td>
            <td width="10%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr align='center' bgcolor="#FFFFFF"  height="22" >
                <td><?php echo $r->id; ?></td>
                <td align="left"><a href="<?= $this->createUrl('preview', array("id" => $r->mail_id,'user_id'=>$r->user_id)) ?>"  target="_blank" ><?=$r->subject?$r->subject:null; ?></a></td>
                <td align="center" title="<?= $r->email?>"><?= $r->user ? $r->user->name : '未知'; ?></td>
                <td align="center"><?= $r->send_at; ?></td>
                <td align="center"><?= $r->sender; ?></td>
                <td align="center"><?=  MailLog::getStatusLabel($r->status)?></td>
                <td  align="center">
                    <a href="<?= $this->createUrl('preview', array("id" => $r->mail_id,'user_id'=>$r->user_id)) ?>"  target="_blank" >重新发送</a>
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
    
    <div style="margin:15px 50px;text-align: center">
        <a href="<?= $this->createUrl('index') ?>" class="btn">返回</a>
    </div>
</form>

