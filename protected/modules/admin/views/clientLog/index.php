<div id="page_head"> 
    <p class="title" style="width: 200px;">客户联系日志管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create')?>" class="btn btn-green">添加客户联系日志</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;文档列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="30%" style="padding-left: 20px; text-align: left">内容</td>
            <td width="7%">联系人</td>
            <td width="7%">客户</td>
            <td width="12%">学校</td>
            <td width="14%">创建时间</td>
            <td width="14%">下次联系时间</td>
            <td width="11%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr  bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $r->id; ?></td>
                <td style="padding-left: 20px"><a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>"><?php echo Helper::truncateUtf8String($r->content, 45) ; ?></a></td>
                <td align="center"> <?= $r['user']['name'] ?></td>
                <td align="center"> <?= $r['client']['name'] ?></td>
                <td align="center"> <?= $r['alumni']['name'] ?></td>
                <td align="center"><?= $r['create_date'] ?></td>
                <td align="center"><?= $r['next_client_date'] ?></td>
                <td align="center"><a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>">编辑</a> | <a href="<?= $this->createUrl('delete', array("id" => $r->id, 'keyword'=>$keyword)) ?>">删除</a></td>
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
    <table width='100%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
        <tr bgcolor='#EEF4EA'>
            <td background='<?php echo ADMIN_IMG_URL ?>wbg.gif' align='center'>
                <table border='0' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td>
                            客户名字/客户校友会/校友会：
                        </td>
                        <td>
                            <input type='text' name='keyword' value="<?= $keyword;?>" style='width:250px'/>
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