<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <title>留言管理</title>
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_URL ?>/base.css">
    </head>
    <body leftmargin="8" topmargin="8" background='<?php echo ADMIN_IMG_URL ?>allbg.gif'>

        <!--  快速转换位置按钮  -->

        <!--  内容列表   -->
        <form name="form2">

            <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
                <tr bgcolor="#E7E7E7">
                    <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
                </tr>

                <tr align="center" bgcolor="#FAFAF1" height="22">
                    <td width="5%">ID</td>
                    <td width="10%">名称</td>
                    <td width="10%">类型</td>
                    <td width="10%">留言人</td>
                    <td width="15%">介绍内容</td>
                    <td width="10%">是否已读</td>
                    <td width="10%">是否推荐</td>
                    <td width="10%">提问时间</td>
                    <td width="10%">修改时间</td>
                    <td width="10%">操作</td>
                </tr>
                <?php
                $i = 1;
                foreach ($records as $_a):
                    ?>
                    <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                        <td><?php echo $i; ?></td>
                        <td align="left"><a href="<?= $this->createUrl('view', array("id" => $_a->id)); ?>"><?php echo $_a->title; ?></a></td>

                        <td><?php if ($_a['type'] == 1) { ?><?= '意见建议'; ?><?php } elseif ($_a['type'] == 2) { ?><?= '产品咨询'; ?><?php } else { ?><?= '其他'; ?><?php } ?></td>
                        <td><?= $_a->user['name']; ?></td>
                        <td><?= Helper::truncateUtf8String($_a->content, 15); ?></td>
                        <td><?= $_a['is_read'] == true ? '是' : '否'; ?></td>
                        <td><?= $_a['is_recommend'] == true ? '是' : '否'; ?></td>
                        <td><?= ueTime($_a['create_date']) ?></td>
                        <td><?= ueTime($_a['update_date']) ?></td>
                        <td><a href="<?= $this->createUrl('create', array("id" => $_a->id)); ?>">回复</a> | <a href="<?= $this->createUrl('update', array("id" => $_a->id)); ?>">修改</a> | <a href="<?= $this->createUrl('delete', array("id" => $_a->id)); ?>">删除</a></td>
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
                        ?></td>
                </tr>
            </table>

        </form>
    </body>
</html>