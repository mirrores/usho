<div id="page_head"> 
    <p class="title">学校管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create') ?>" class="btn btn-green">添加学校</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="12" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;文档列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="10%">学校名称</td>
            <td width="10%">省份</td>
            <td width="5%">学校性质</td>
            <td width="10%">办学类型</td>
            <td width="10%">举办单位</td>
            <td width="20%">学校网址</td>
            <td width="5%">985</td>
            <td width="5%">211</td>
            <td width="5%">审核</td>
            <td width="5%">推荐学校</td>
            <td width="10%">操作</td>
        </tr>
        <?php
        foreach ($records as $_s):
            ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $_s->id; ?></td>
                <td align="center"><a href="<?= $this->createUrl('update', array("id" => $_s->id)) ?>"><?php echo $_s->name; ?></a></td>
                <td align="center"><?=isset($_s->provinces->name)?$_s->provinces->name:'' ?></td>
                <td align="center"><?=$_s->nature?$_s->nature->name:null ?></td>
                <td align="center"><?=$_s->genre?$_s->genre->name:null ?></td>
                <td align="center"><?=$_s->company?$_s->company->name:null ?></td>
                <td><a href="<?=$_s->website; ?>" target="_blank"><?=$_s->website; ?></a></td>
                                <td><input type="checkbox" value="1" onclick="switchBoolean(<?= $_s->id ?>,'is_985');" <?= $_s->is_985?'checked':'' ?> /></td></td>
                <td><input type="checkbox" value="1" onclick="switchBoolean(<?= $_s->id ?>,'is_211');" <?= $_s->is_211?'checked':'' ?> /></td></td>
                <td><input type="checkbox" value="1" onclick="switchBoolean(<?= $_s->id ?>,'is_verify');" <?= $_s->is_verify?'checked':'' ?> /></td></td>
                <td><input type="checkbox" value="1" onclick="switchBoolean(<?= $_s->id ?>,'is_recommend');" <?= $_s->is_recommend?'checked':'' ?> /></td></td>
                <td>
                    <a href="<?= $this->createUrl('update', array("id" => $_s->id)); ?>" target="_blank">编辑</a>
                    | <a href="<?= $this->createUrl('delete', array("id" => $_s->id)); ?>">删除</a></td>
            </tr>
        <?php endforeach; ?>
        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="12" align="center"><!--翻页代码 -->
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
                        <input type='text' name='keyword' value='<?= $keyword;?>' style='width:250px' />  
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


<script type="text/javascript">
    function switchBoolean(id,field){
        $.ajax({
            url: '<?= $this->createUrl('switchBoolean')?>',
            type: 'get',
            data: 'id='+id+'&field='+field
        });
    }
</script>