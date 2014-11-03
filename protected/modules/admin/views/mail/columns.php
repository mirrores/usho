<style type="text/css">
    *{font-size:14px}
</style>

<div id="page_head"> 
    <p class="title" style="width: 600px"><?= $mail->name ?> —— 内容设置</p>
    <ul class="menu">
    </ul>
</div>

<style type="text/css">
    .columnbox{border: 2px solid #fff;padding:5px;margin: 10px 0}
    .columnbox:hover{border: 2px solid #008200;background-color: #f8f8f8}
    .columnbox:hover .ctool{ display: block}

    .column_title{margin-top: 8px}
    .column_title li{border-left: 0px solid #008200;background-color: #EAF5EA;height:30px;line-height: 30px;padding-left: 10px;text-align: left;width:100%}
    .column_title li .cname{font-size: 14px;font-weight: bold;color: #008200;width:40%;float: left;text-align: left}
    .column_title li .ctool{font-size: 12px;color: #999;float: right;width: 50%;text-align: right;display: none;margin-right: 10px}
    .column_title li .ctool a{font-size: 12px;color: #666;}

    .art_list{margin-top: 10px}
    .art_list li{height:30px;line-height: 30px;padding-left: 10px;text-align: left;width:100%}
    .art_list li .title{font-size: 12px;color: #333;width:60%;float: left;text-align: left;color: #999}
    .art_list li .tool{font-size: 12px;color: #999;float: right;width: 35%;text-align: right;display: none;margin-right: 10px}
    .art_list li .tool a{font-size: 12px;color: #666;}
    .art_list li:hover{background-color: #eee}
    .art_list li:hover .tool{display: block}
    .art_list li.clume_intro{color: #f60;font-size: 12px;}
</style>

<div style="width:100%;">
    <!--  内容列表   -->
    <?php foreach ($records as $key => $r): ?>

    <div class="columnbox">

            <div style="width:68%;float: left;">
                <ul class="column_title">
                    <li>
                        <div class="cname"><?= $key+1?>、<?php echo $r->title; ?></div>
                        <div class="ctool">
                            <a href="<?= $this->createUrl('create_content', array('mail_id' => $r->mail_id, 'column_id' => $r->id)) ?>"  title="增加文章" style="font-size: 12px">添加文章</a>
                            <a href="<?= $this->createUrl('update_column', array("id" => $r->id, 'mail_id' => $r->mail_id)) ?>"  title="修改栏目名称" style="font-size: 12px">修改栏目</a>
                            <a href="<?= $this->createUrl('delete_column', array("id" => $r->id, 'mail_id' => $r->mail_id)) ?>"  title="删除栏目已经内容" style="font-size: 12px">删除栏目</a>
                            <?php if ($key): ?> 
                                <a href="<?= $this->createUrl('order_column', array("id" => $r->id, 'order' => 'up')) ?>"  title="提升栏目" style="font-size: 12px">上升栏目</a>
                            <?php else: ?>
                                <span style="font-size: 12px;color: #ccc">降低栏目</span>
                            <?php endif; ?>
                            <?php if ($key < count($records) - 1): ?> 
                                <a href="<?= $this->createUrl('order_column', array("id" => $r->id, 'order' => 'down')) ?>"  title="提升栏目" style="font-size: 12px">下移栏目</a>
                            <?php else: ?>
                                <span style="font-size: 12px;color: #ccc">上升栏目</span>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
                <?php $contents = $r->contents; ?>
                <ul class="art_list">
                    <?php if ($contents): ?>   
                        <?php foreach ($contents as $k => $c): ?>
                            <li>
                                <div class="title">&bull; <a href="<?= $this->createUrl('update_content', array("id" => $c->id, 'mail_id' => $r->mail_id)) ?>"><?php echo $c->title; ?></a> <?php if($c->img_path):?><span style="color:#008200">[图]</span><?php endif;?> </div>
                                <div class="tool">
                                    <a href="<?= $this->createUrl('update_content', array("id" => $c->id, 'mail_id' => $r->mail_id)) ?>" >修改</a>
                                    <a href="<?= $this->createUrl('delete_content', array("id" => $c->id, 'mail_id' => $r->mail_id)) ?>" >删除</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="clume_intro">提示：<?= $r->style->intro ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        
            <div style="width:28%;float:right">
                <a href="<?= $this->createUrl('update_style', array("id" => $r->style_id, 'mail_id' => $r->mail_id)) ?>"  title="编辑“<?=$r->style->name ?>”栏目样式" ><img src="<?= $r->style->img_path ?>" alt="" /></a>
            </div>

            <div style="clear: both"></div>
        </div>

    <?php endforeach; ?>
</div>

<div style=" text-align: center"> 
<a href="<?= $this->createUrl('index', array('mail_id' => $mail->id)) ?>" class="btn">取消</a>
<a href="<?= $this->createUrl('create_column', array('mail_id' => $mail->id)) ?>" class="btn btn-green"><i class="fa fa-plus" ></i> 增加栏目</a>
<a href="<?= $this->createUrl('preview', array('id' => $mail->id)) ?>" class="btn btn-green" target="_blank"><i class="fa fa-eye" ></i> 完整预览</a>
</div>
