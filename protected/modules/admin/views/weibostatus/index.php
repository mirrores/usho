<div id="page_head"> 
    <p class="title">微博管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('capture')?>" class="btn btn-green">抓取新微博</a></li>
    </ul>
</div>
<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="9" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="50">ID</td>
            <td width="80" style="padding-left: 20px; text-align: left">微博ID</td>
            <td width="100">用户昵称</td>
            <td>微博内容</td>
            <td width="130">创建时间</td>
            <td width="50">来源</td>
            <td width="50">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr  bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $r->weibo_sys_id; ?></td>
                <td style="padding-left: 20px"><?php echo $r->user_id; ?></td>
                <td align="center"><?php echo $r->screen_name; ?></td>
                <td><?php echo $r->text; ?>＝
                    [<?php 
//                    if(isset($r->weibotmp)){
//                        echo $r->weibotmp->id;
//                    }
                    if(isset($r->weibostatuschild)){
                        echo $r->weibostatuschild->parent_weibo_sys_id;
                    }
?>]
                </td>
                <td align="center"><?= date('Y-m-d H:i:s',$r['created_at']) ?></td>
                <td align="center"><?php echo $r->retweeted_status?'转载':'原创'; ?></td>
                <td align="center"><a href="<?= $this->createUrl('delete', array("id" => $r->weibo_sys_id)) ?>">删除</a></td>
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