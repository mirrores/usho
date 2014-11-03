<style type="text/css">
    #columnstyle{ list-style: none;width: 100%;border: 1px solid #fff}
    #columnstyle li{ color: #999;width: 320px;height:120px; padding:5px; margin-right: 10px; text-align: center;float: left;margin-bottom: 10px;}
    #columnstyle li img{ border:3px solid #fff;padding: 3px;margin: 4px}
    #columnstyle li.selected{color: green}
    #columnstyle li.selected img{ border:3px solid green;background-color: #E8F5E8}
</style>
<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    $img_dir = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    ?>

    <div id="page_head"> 
        <p class="title" style="width: 300px"><?= $mail->name ?> — <?= $model->isNewRecord ? '添加' : '编辑' ?>栏目</p>
    </div>

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">


        <tr>
            <td align="right" style="width:100px">
                <?php echo $form->labelEx($model, 'style_id') ?>
            </td>
            <td>
<?php echo $form->hiddenField($model, 'style_id'); ?>
                <?php
                $style = MailColumnStyle::model()->findAll();
                ?>
                <?php if ($style): ?>
                    <?php $first_id = $model->style_id?$model->style_id:$style[0]['id']; ?>
                    <ul id="columnstyle">
                        <?php foreach ($style as $key => $r): ?>
                            <li class="<?= $r->id == $first_id ? 'selected' : null; ?>" val="<?= $r->id ?>">
                                <img src="<?= $r->img_path ?>" style="vertical-align: middle"><br />
                                <?= $r->name ?>
                            </li>
                        <?php endforeach; ?>
                        <div style="clear: both"></div>
                    </ul>
                <?php else: ?>
                    <div style="color: #999">暂无任何样式！</div>
                <?php endif; ?>
            </td>
        </tr>
        
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_show_title') ?>
            </td>
            <td>
                <input type="radio" name="MailColumn[is_show_title]" value="1" <?= $model->is_show_title ? 'checked="checked"' : null ?> />是
                <input type="radio" name="MailColumn[is_show_title]" value="0" <?= !$model->is_show_title ? 'checked="checked"' : null ?> />否
            </td>
        </tr>

        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'title') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'title', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </td>
        </tr>

       <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'url') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'url', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'url'); ?>
            </td>
        </tr>

        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'intro') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'intro', array('style' => 'width:900px;height:200px')); ?>
                <?php echo $form->error($model, 'intro'); ?>
            </td>
        </tr>


        <tr>
            <td colspan="2" align="center">
                <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-green')); ?>
                <a href="<?= $this->createUrl('columns', array('mail_id' => $mail->id)) ?>" class="btn">取消</a>

            </td>
        </tr>  


    </table>
    <?php $this->endwidget(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $style_id = $('#MailColumn_style_id');
        $lis = $('#columnstyle>li');
        $lis.bind('click', function() {
            $lis.removeClass('selected');
            $(this).addClass('selected');
            $style_id.val($(this).attr('val'));
        })
    })
</script>