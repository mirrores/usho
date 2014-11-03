<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>城市管理</title>
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
      <a href="<?=$this->createUrl('create')?>" target="right">添加城市</a>
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
	<td width="10%">城市编号</td>
                <td width="20">城市名称</td>
                <td width="10">城市编码</td>
                <td width="8%">城市拼音</td>
	<td width="15%">创建时间</td>
                <td width="15%">修改时间</td>
	<td width="10%">操作</td>
</tr>
<?php
     foreach ($records as $_c ):
?>
<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >	
	<td align="center"><?php echo $_c->id;?></td>
        <td align="center"><a href="<?=$this->createUrl('update',array("id"=>$_c->id))?>"> <?php echo $_c->name;?></a></td>
                <td align="center"><?php echo $_c->city_id;?></td>
                <td align="center"><?php echo $_c->pinyin;?></td>
	<td><?php echo $_c->created_at;?></td>
                 <td><?php echo $_c->updated_at;?></td>
	<td><a href="<?=$this->createUrl('update',array("id"=>$_c->id)) ;?>">编辑</a> | <a href="<?=$this->createUrl('delete',array("id"=>$_c->id)) ;?>">删除</a></td>
</tr>
<?php
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

<!--  搜索表单  -->
<?php $form=$this->beginWidget('CActiveForm');?>
<input type='hidden' name='dopost' value='' />
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
  <tr bgcolor='#EEF4EA'>
    <td background='<?php echo ADMIN_IMG_URL?>wbg.gif' align='center'>
      <table border='0' cellpadding='0' cellspacing='0'>
        <tr>
        <td width='100'>
          城市名称关键字：
        </td>
        <td width='160'>
            <input type='text' name='keyword' value='' style='width:150px' />
        </td>
        
        <td>
            <input name="imageField" type="image" src="<?php echo ADMIN_IMG_URL?>search.gif" width="45" height="20" border="0" class="np" />
        </td>
       </tr>
      </table>
    </td>
  </tr>
</table>
<?php $this->endWidget();?>
</body>
</html>
