<div style="float: right;">
    <a href="<?= $this->createUrl('UserTrace/CountMonthly', array('type' =>"news"));?>" class="tab" style="font-size: 18px;">新闻</a>
      <a href="<?= $this->createUrl('UserTrace/CountMonthly', array('type' =>"event"));?>" class="tab" style="font-size: 18px;">活动</a>
 </div>
<!--  内容列表   -->
<form name="form2" style="clear: both;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="3" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="40%">新闻标题</td>
            <td width="40%">点击数量</td>
           <?php foreach($records as $value):?>
        </tr>
     
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.  = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
          <?php if($_GET['type']=="news"){?>
                  <td><?=$value['news']['title'];?></td>
          <?php }else{?>
                  <td><?=$value['event']['title'];?></td>
                  <?php }?>
                  <td><?=UserTrace::model()->count('monthly_id=(select max(id) from monthly) and data_id=:name   ',array(':name'=>$value['news']['id']));?></td>
                 
            </tr>
           <?php
           endforeach;
           ?>
        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="3" align="center"><!--翻页代码 -->
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
