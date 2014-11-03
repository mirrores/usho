
<div style="float: right;">
    <a href="<?= $this->createUrl('UserTrace/CountUser',  array('keyword'=>0));?>" class="tab" style="font-size: 18px;">当天</a>
      <a href="<?= $this->createUrl('UserTrace/CountUser', array('keyword' =>7));?>" class="tab" style="font-size: 18px;">最近7日</a>
      <a href="<?= $this->createUrl('UserTrace/CountUser', array('keyword' =>30));?>" class="tab" style="font-size: 18px;">最近30日</a>
      <a href="<?= $this->createUrl('UserTrace/CountUser', array('type' =>1));?>" class="tab" style="font-size: 18px;">访问次数统计</a>
 </div>
<!--  内容列表   -->
<form name="form2" style=" clear:both;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="6" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;介绍列表&nbsp;</td>
        </tr>

        <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="10%">ID</td>
            <td width="10%">用户名</td>
            <td width="30%">校友会</td>
            <td width="10%">职务</td>
             <td width="20%">点击数量</td>
             <td width="20%">最后点击时间</td>
           <?php foreach($records as $v):?>
        </tr>
     
            <tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.  = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                  <td><?=$v->user_id;?></td>
                  <td><a href="<?=$this->createUrl('userTrace/UserShow',array('id'=>$v['user']['id']))?>"><?=$v['user']['name'];?></a></td>
                  <td><?=$v['user']['alumni']['name'];?></td>
                  <td><?=$v['user']['position'];?></td>
                  <td><?=  UserTrace::model()->count('user_id='.$v->user_id);?></td>
                  <td><?=$v->create_date;?></td>
            </tr>
           <?php
           endforeach;
           ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="6" align="center"><!--翻页代码 -->
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
