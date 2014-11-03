<style>
    #sddm
    {
      margin: 0 auto;
      padding: 0;
      z-index: 30;
      width: 100px;
      height:23px;
    }

    #sddm div
    {	
      position: absolute;
      visibility: hidden;
      margin: 0;
      padding: 0;
      border: 1px solid #5970B2
    }
    #sddm div a
    {	
      position: relative;
      display: block;
      margin: 0;
      padding: 5px 10px;
      width: auto;
      white-space: nowrap;
      text-align: left;
      text-decoration: none;
      background:#DDD;
      font: 12px arial
    }

</style>

<div id="page_head"> 
    <p class="title">工作日志管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('create') ?>" class="btn btn-green">添加工作日志</a></li>
    </ul>
    <ul id="sddm" class="menu">
        <li><a href="<?= $this->createUrl('index') ?>" onmouseover="mopen('m1')" onmouseout="mclosetime()">选择查看日志</a>
            <div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                <a href="<?=$this->createUrl('list', array('id'=>852))?>">陈鸿</a>
                <a href="<?= $this->createUrl('list', array('id' => 876)) ?>">赵建刚</a>
                <a href="<?= $this->createUrl('list', array('id' => 875)) ?>"">楼文姗</a>
                <a href="<?= $this->createUrl('list', array('id' => 1)) ?>"">牛涛</a>
                <a href="<?= $this->createUrl('list', array('id' => 890)) ?>"">饶日红</a>
                <a href="<?= $this->createUrl('list', array('id' => 878)) ?>"">周秋浩</a>
                <a href="<?= $this->createUrl('list', array('id' => 151)) ?>"">徐斌</a>
                <a href="<?= $this->createUrl('list', array('id' => 891)) ?>"">康兴</a>
            </div>
        </li>
    </ul>
</div>

<!--  内容列表   -->
<form name="form2">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" style="margin-top:8px">
        <tr bgcolor="#E7E7E7">
            <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;文档列表&nbsp;</td>
        </tr>

         <tr align="center" bgcolor="#FAFAF1" height="22">
            <td width="5%">ID</td>
            <td width="90%" style="padding-left: 20px; text-align: left">内容</td>
            <td width="5%">操作</td>
        </tr>
        <?php foreach ($records as $r): ?>
            <tr  bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
                <td align='center'><?= $r->id; ?></td>
                <td style="padding-left: 20px;line-height: 30px;"><a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>"><?php echo Helper::truncateUtf8String($r->content, 200); ?></a><div style="clear:both;float:right;"><?= $r->user->name ?> <?= $r['create_date'] ?></div></td>
                <td align="center">
                    <?php if (Yii::app()->user->id === $r->user_id) { ?>
                        <a href="<?= $this->createUrl('update', array("id" => $r->id)) ?>">编辑</a>
                    <?php } else { ?>
                        <a href="<?= $this->createUrl('view', array("id" => $r->id)) ?>">查看</a>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr align="right" bgcolor="#EEF4EA">
            <td height="36" colspan="8" align="center">
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
<?php $form = $this->beginWidget('CActiveForm') ?>
<input type='hidden' name='dopost' value='' />
<table width='100%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
    <tr bgcolor='#EEF4EA'>
        <td background='<?php echo ADMIN_IMG_URL ?>wbg.gif' align='center'>
            <table border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        创建人/关键字：
                    </td>
                    <td>
                        <input type='text' name='keyword' value="<?= $keyword; ?>" style='width:250px'/>
                    </td>
                    <td width="10"></td>
                    <td>
                        <input name="imageField" type="image" src="<?php echo ADMIN_IMG_URL ?>search.gif" width="45" height="20" border="0" class="np" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $this->endwidget(); ?>

<script type="text/javascript">
    <!--
var timeout = 500;
    var closetimer = 0;
    var ddmenuitem = 0;

// open hidden layer
    function mopen(id)
    {
        // cancel close timer
        mcancelclosetime();

        // close old layer
        if (ddmenuitem)
            ddmenuitem.style.visibility = 'hidden';

        // get new layer and show it
        ddmenuitem = document.getElementById(id);
        ddmenuitem.style.visibility = 'visible';

    }
// close showed layer
    function mclose()
    {
        if (ddmenuitem)
            ddmenuitem.style.visibility = 'hidden';
    }

// go close timer
    function mclosetime()
    {
        closetimer = window.setTimeout(mclose, timeout);
    }

// cancel close timer
    function mcancelclosetime()
    {
        if (closetimer)
        {
            window.clearTimeout(closetimer);
            closetimer = null;
        }
    }

// close layer when click-out
    document.onclick = mclose;
    // -->
</script>
