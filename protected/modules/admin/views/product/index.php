<div id="page_head"> 
    <p class="title">产品管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create') ?>" class="btn btn-green">添加产品</a></li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">

    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="30%">名称</td>
            <td width="55%">内容</td>
            <td width="10%">操作</td>
        </tr>
        <?php
        $i = 1;
        foreach ($records as $_p):
            ?>
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td><?php echo $i; ?></td>
                <td align="left"><a href="<?= $this->createUrl('update', array("id" => $_p->pro_id)); ?>"><?php echo $_p->pro_name; ?></a></td>
                <td><?php echo $_p->pro_content; ?></td>
                <td><a href="<?= $this->createUrl('update', array("id" => $_p->pro_id)); ?>">编辑</a> | <a href="<?= $this->createUrl('delete', array("id" => $_p->pro_id)); ?>">删除</a></td>
            </tr>
            <?php
            $i++;
        endforeach;
        ?>





        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="10" align="center"><!--翻页代码 -->
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
