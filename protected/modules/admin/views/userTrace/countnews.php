
<div style="float: right;">
    <a href="<?= $this->createUrl('UserTrace/CountNews',  array('keyword'=>0));?>" class="tab" style="font-size: 18px;">当天</a>
      <a href="<?= $this->createUrl('UserTrace/CountNews', array('keyword' =>7));?>" class="tab" style="font-size: 18px;">最近7日</a>
      <a href="<?= $this->createUrl('UserTrace/CountNews', array('keyword' =>30));?>" class="tab" style="font-size: 18px;">最近30日</a>
      <a href="<?= $this->createUrl('UserTrace/CountNews', array('type' =>1));?>" class="tab" style="font-size: 18px;">访问次数统计</a>
 </div>
<!--  内容列表   -->
<form name="form2" style=" clear:both;">

    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="5" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="10%">ID</td>
            <td width="50%">新闻名称</td>
            <td width="20%">来源</td>
            <td width="10%">作者</td>
            <td width="10%">点击数量</td>
           <?php foreach($records as $value):?>
        </tr>
     
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.  = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                  <td><?=$value['news']['id']?></td>
                  <td><a href="<?=$this->createUrl('userTrace/NewsShow',array('id'=>$value['news']['id']))?>"><?=$value['news']['title']?></a></td>
                  <td><?=$value['news']['source']?></td>
                  <td><?=$value['news']['authod_name']?></td>
                  <td><?=  UserTrace::model()->count('controller="news" and action="view" and data_id=:name',array(':name'=>$value['news']['id']))?></td>
                
            </tr>
           <?php
           endforeach;
           ?>
        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="5" align="center"><!--翻页代码 -->
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
