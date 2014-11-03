<!--  快速转换位置按钮  -->
<div id="page_head"> 
    <p class="title">附件管理（图片）</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create')?>" class="btn btn-green">添加图片</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;图片列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="4%">ID</td>
            <td width="15%" style="padding-left: 20px; text-align: left">标题</td>
            <td width="20%" >原图</td>
            <td width="5%" >中等尺寸</td>
            <td width="5%" >缩略图</td>
            <td width="5%" >迷你图</td>
            <td width="6%">分类</td>
            <td width="6%">创建时间</td>
            <td width="5%">上传</td>
            <td width="10%">操作</td>
        </tr>
                            
        <?php foreach ($records as $r): ?>
            <tr  bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $r->id; ?></td>
                <td style="padding-left: 20px"><?php echo $r->title; ?></td>
                <td align="center"><a href="<?=  Yii::app()->baseUrl.str_replace('_mini','',$r->path)?>" target="_blank">
                    <img src="<?=  Yii::app()->baseUrl.$r->path?>" style="border-width: 0;vertical-align: middle"></a>
                </td>
                <td align="center"><a href="<?=  Yii::app()->baseUrl.str_replace('_mini','_bmiddle',$r->path)?>" target="_blank">
                    预览
                </td>
                <td align="center"><a href="<?=  Yii::app()->baseUrl.str_replace('_mini','_thumbnail',$r->path)?>" target="_blank">预览</a>
                </td>
                <td align="center"><a href="<?=  Yii::app()->baseUrl.$r->path?>" target="_blank">预览</a>
                </td>
                <td align="center"> <?= $r->type ?></td>
                <td align="center"><?= $r->user_id ?></td>
                <td align="center"><?= ueTime($r['created_date']) ?></td>
                <td align="center"><a href="<?= $this->createUrl('delete', array("id" => $r->id)) ?>">删除</a></td>
            </tr>
        <?php endforeach; ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="10" align="center">
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
