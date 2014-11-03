<div style="float: right;">
    <a href="<?= $this->createUrl('UserTrace/MonthlyDay');?>" class="tab" style="font-size: 18px;">每日</a>
      <a href="<?= $this->createUrl('UserTrace/MonthlyWeek');?>" class="tab" style="font-size: 18px;">每周</a>
 </div>
<!--  内容列表   -->
<form name="form2" style="clear: both;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="3" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="40%">周</td>
            <td width="40%">点击数量</td>
           <?php foreach($records as $value):?>
        </tr>
     
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.  = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
          
                  <td>第<?=$value->create_date;?>周</td>
                  <td><?=$value->user_id;?></td>
                 
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
