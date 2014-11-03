<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>办学类别管理</title>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_URL?>/base.css">
</head>
<body leftmargin="8" topmargin="8" background='<?php echo ADMIN_IMG_URL?>allbg.gif'>

<!--  快速转换位置按钮  -->
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#D1DDAA" align="center">
<tr>
 <td height="26" background="<?php echo ADMIN_IMG_URL?>newlinebg3.gif">
  <table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="center">
      <a href="<?=$this->createUrl('create')?>" target="right">添加类别</a>
 </td>
 </tr>
</table>
</td>
</tr>
</table>
  
<!--  内容列表   -->
<form name="form2">
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
<tr bgcolor="#E7E7E7">
    <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL?>tbg.gif">&nbsp;文档列表&nbsp;</td>
</tr>

<tr align="center" bgcolor="#FAFAF1" height="22">
	<td width="6%">ID</td>
	<td width="10%">办学类型编码</td>
	<td width="15%">办学类型名称</td>
	<td width="10%">操作</td>
</tr>
<?php
     $i=1;
   foreach($records as $_t):
?>
<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
	<td align="center"><?php echo $i;?></td>
	<td align="center"><?php echo $_t->code;?></td>
                <td align="center"><a href="<?=$this->createUrl('update',array("id"=>$_t->id));?>"><?php echo $_t->name;?></a></td>
	<td align="center"><a href="<?=$this->createUrl('update',array("id"=>$_t->id));?>">编辑</a> | <a href="<?=$this->createUrl('delete',array("id"=>$_t->id)) ;?>">删除</a></td>
</tr>
<?php
    $i++;
    endforeach;?>




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
</body>
</html>