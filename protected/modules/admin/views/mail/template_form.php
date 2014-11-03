<script type="text/javascript" src="/static/js/jscolor/jscolor.js"></script>
<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    $img_dir='http://'.$_SERVER['HTTP_HOST'].'/';
    ?>

    <div id="page_head"> 
        <p class="title" style="width: 300px"><?= $model->isNewRecord ? '添加' : '编辑' ?>邮件样式</p>
    </div>

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">

        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'name') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'name', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>

      
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'background_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'background_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'background_color'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'head_background_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'head_background_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'head_background_color'); ?>
            </td>
        </tr>
        
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'body_background_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'body_background_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'body_background_color'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'column_background_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'column_background_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'column_background_color'); ?>
            </td>
        </tr>
        
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'column_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'column_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'column_color'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'text_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'text_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'text_color'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'link_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'link_color', array('size' => 10, 'maxlength' => 255, 'class' => 'color')); ?>
                <?php echo $form->error($model, 'link_color'); ?>
            </td>
        </tr>
        
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'logo_path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'logo_path', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?><br />
                <?php echo $form->error($model, 'logo_path'); ?>
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style=" width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'MailTemplate_logo_path', 'msg' => 'logo不大于1M', 'return_size_name' => 'original', 'prefix_path' => $img_dir)) ?>"></iframe>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'intro') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'intro', array('style' => 'width:900px;height:60px')); ?>
                <?php echo $form->error($model, 'intro'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'content') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'content', array('style' => 'width:1000px;height:500px')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center" >
                <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-green')); ?>
                <a href="<?= $this->createUrl('template') ?>" class="btn">取消</a>
            </td>
        </tr>  
    </table>
    <?php $this->endwidget(); ?>
</div>

<?php
//Common::ueditor('MailTemplate_content','base',array('sourceEditorFirst'=>'true','initialStyle'=>'"p{padding:0;text-indent: 0px;}"'));
?>