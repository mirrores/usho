<?php
$tag_attr = array(
    'ag' => '形语素',
    'a' => '形容词',
    'ad' => '副形词',
    'an' => '名形词',
    'b' => '区别词',
    'c' => '连词',
    'dg' => '副语素',
    'd' => '副词',
    'e' => '叹词',
    'f' => '方位词',
    'g' => '语素',
    'h' => '前接成分',
    'i' => '成语',
    'j' => '简称略语',
    'k' => '后接成分',
    'l' => '习用语',
    'm' => '数词',
    'ng' => '名语素',
    'n' => '名词',
    'nr' => '人名',
    'ns' => '地名',
    'nt' => '机构团体',
    'nz' => '其他专名',
    'o' => '拟声词',
    'ba' => '介词',
    'bei' => '介词',
    'p' => '介词',
    'q' => '量词',
    'r' => '代词',
    's' => '处所词',
    'tg' => '时语素',
    't' => '时间词',
    'dec' => '助词',
    'deg' => '助词',
    'di' => '助词',
    'etc' => '助词',
    'as' => '助词',
    'msp' => '助词',
    'u' => '其他助词',
    'vg' => '动语素',
    'v' => '动词',
    'vd' => '副动词',
    'vn' => '名动词',
    'w' => '其他标点符号',
    'x' => '非语素字',
    'y' => '语气词',
    'z' => '状态词'
);
?>
<div id="page_head"> 
    <p class="title">分词管理</p>
    <ul class="menu">
        <li><a href="<?= $this->createUrl('index', array('attent' => 1))?>" class="btn btn-green">所有一星关注</a></li>
        <li><a href="<?= $this->createUrl('index', array('attent' => 2))?>" class="btn btn-green">所有二星关注</a></li>
        <li><a href="<?= $this->createUrl('index', array('attent' => 3))?>" class="btn btn-green">所有三星关注</a></li>
        <li><a href="<?= $this->createUrl('index', array('attent' => 0))?>" class="btn btn-green">所有不关注</a></li>
    </ul>
</div>

<!--  内容列表   -->
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" style="margin-top:8px">
    <tr bgcolor="#E7E7E7">
        <td height="24" colspan="10" background="<?php echo ADMIN_IMG_URL ?>tbg.gif">&nbsp;文档列表&nbsp;</td>
    </tr>

    <tr align="center" bgcolor="#FAFAF1" height="22">
        <td width="15%">ID</td>
        <td width="30%">分词</td>
        <td width="10%">长度</td>
        <td width="10%">类型</td>
        <td width="10%">热度</td>
        <td width="25%">关注</td>
    </tr>
    <?php foreach ($records as $r): ?>
        <tr  bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor = '#FCFDEE';" onMouseOut="javascript:this.bgColor = '#FFFFFF';" height="22" >
            <td align="center"><?= $r->id; ?></td>
            <td align="center"><a href="<?= $this->createUrl('news/index', array('tag_id' => $r->id)) ?>"><?= $r->tag; ?></a></td>
            <td align="center"><a href="<?= $this->createUrl('index', array('len' => $r->len)) ?>"><?= $r->len ?></a></td>
            <td align="center"><a href="<?= $this->createUrl('index', array('attr' => $r->attr)) ?>"><?= isset($tag_attr[$r->attr]) ? $tag_attr[$r->attr] : $r->attr ?></a></td>
            <td align="center"><?= count($r->news) ?></td>
            <td align="center">
                <input type="radio" name="attent<?= $r->id; ?>" value="1" <?= $r->attent == 1 ? 'checked' : '' ?> onclick="ajaxTagsAttent(<?= $r->id; ?>, 1);">一星&nbsp;
                <input type="radio" name="attent<?= $r->id; ?>" value="2" <?= $r->attent == 2 ? 'checked' : '' ?> onclick="ajaxTagsAttent(<?= $r->id; ?>, 2);">二星&nbsp;
                <input type="radio" name="attent<?= $r->id; ?>" value="3" <?= $r->attent == 3 ? 'checked' : '' ?> onclick="ajaxTagsAttent(<?= $r->id; ?>, 3);">三星&nbsp;
                <input type="radio" name="attent<?= $r->id; ?>" value="0" <?= $r->attent == 0 ? 'checked' : '' ?> onclick="ajaxTagsAttent(<?= $r->id; ?>, 0);">不关注
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

<!--  搜索表单  -->
<?php $form = $this->beginWidget('CActiveForm') ?>
<input type='hidden' name='dopost' value='' />
<table width='100%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
    <tr bgcolor='#EEF4EA'>
        <td background='<?php echo ADMIN_IMG_URL ?>wbg.gif' align='center'>
            <table border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>
                        分词：
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
    function ajaxTagsAttent(id, attent) {
        //alert(id);alert(attent);
        $.ajax({
            type: 'post',
            url: '<?= $this->createUrl('changeAttent'); ?>',
            data: {'id': id, 'attent': attent},
            success: function(data) {}
        });
    }
</script>