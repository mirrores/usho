<div id="page_head"> 
   <?php echo CHtml::htmlButton('返回', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
</div>

<!--  内容列表   -->
<form name="form2">

    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="3" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="10%">用户名称</td>
            <td width="50%">内容</td>
            <td width="50%">访问时间</td>
           <?php foreach($records as $value):?>
        </tr>
     
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.  = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
            <td><?=$value->user->name?></td>
               <?php if($value['controller']=="news" && $value['controller']!="event" && $value['controller']!="talk" && $value['action']=="view"){?>  
            <td><?=$value['news']['title'];?></td>
                <?php }elseif($value['controller']!="news" && $value['controller']=="event" && $value['controller']!="talk" && $value['action']=="view"){ ?>
                  <td><?=$value['event']['title'];?></td>
                  <?php }elseif($value['controller']!="news" && $value['controller']!="event" && $value['controller']=="talk" && $value['action']=="view"){ ?>
                  <td><?=$value['talk']['title'];?></td>
                  <?php }else{?>
                  <td><?=$value->controller;?>/<?=$value->action;?></td>
                  <?php }?>
                  <td><?=$value->create_date;?></td>
                
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

