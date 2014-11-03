<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>月报管理</title>
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
      <a href="./index.php?r=admin/school/add" target="right">添加月报</a>
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
    <td height="24" colspan="16" background="<?php echo ADMIN_IMG_URL?>tbg.gif">&nbsp;文档列表&nbsp;</td>
</tr>

<tr align="center" bgcolor="#FAFAF1" height="22">
	<td width="3%">ID</td>
	<td width="5%"></td>
                <td width="10%"></td>
	<td width="20%">操作</td>
</tr>
<?php
     $i=1;
   foreach($essay_info as  $_e  ){
      
?>
<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
	<td><?php echo $i;?></td>
	<td align="center"><?php echo $_e->essay_title;?></td>
                <td align="center"><?php echo $_e->essay_issue;?></td>
                <td align="center"><?php echo $_s[] == true ? '是':'否' ?></td>
                <td align="center"><?php echo $_s[''] == true ? '是':'否' ?></td>
                <td align="center"><?php echo $_s[''] == true ? '是':'否' ?></td>
                <td align="center"><?php echo $_s[''] == true ? '是':'否' ?></td>
	<td><?php echo $_s->create_date;?></td>
                 <td><?php echo $_s->update_date;?></td>
	<td><a href="./index.php?r=admin/school/update&id=<?php echo $_s->school_id;?>">编辑</a> | <a href="./index.php?r=admin/school/del&id=<?php echo $_s->school_id;?>">删除</a></td>
</tr>
<?php
    $i++;
   }?>




<tr align="right" bgcolor="#EEF4EA">
	<td height="36" colspan="16" align="center"><!--翻页代码 -->
        
                        <?php  echo $page_list; ?>
        </td>
</tr>
</table>

</form>

<!--  搜索表单  -->
 <?php $form = $this -> beginWidget('CActiveForm')?>
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
  <tr bgcolor='#EEF4EA'>
    <td background='<?php echo ADMIN_IMG_URL?>wbg.gif' align='center'>
      <table border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='90' align='center'>搜索条件：</td>
          <td width='160'>
          <select name='cid' style='width:150'>
          <option value='0'>选择类型...</option>
          	<option value='1'>名称</option>
          </select>
        </td>
        <td width='70'>
          关键字：
        </td>
        <td width='160'>
          	<?php echo $form -> textField($school_models,'cities_id',array('size'=>30,'maxlength'=>20)); ?>  
        </td>
        <td width='110'>
    		<select name='orderby' style='width:80px'>
            <option value='id'>排序...</option>
            <option value='pubdate'>发布时间</option>
      	</select>
        </td>
        <td>
            <input name="imageField" type="image" src="<?php echo ADMIN_IMG_URL?>search.gif" width="45" height="20" border="0" class="np" />
        </td>
       </tr>
      </table>
    </td>
  </tr>
</table>
   <?php $this -> endwidget(); ?>
</body>
</html>