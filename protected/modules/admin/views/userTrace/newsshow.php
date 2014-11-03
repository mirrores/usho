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
            <td width="50%">校友会名称</td>
            <td width="50%">次数</td>
           <?php foreach($records as $value):?>
        </tr>
     
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.  = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                  <td><?=$value->user->name;?></td>
                  <td><?=$value->user->alumni->name;?></td>
                  <td><?=UserTrace::model()->count('controller="news" and action="view" and user_id='.$value->user->id.' and data_id='.$value['news']['id']);?></td>
                
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

