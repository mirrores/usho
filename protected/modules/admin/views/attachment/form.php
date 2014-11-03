<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl ?>/static/css/jquery-ui.css">

<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    ?>

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">
        <tr>
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>附件</td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'type') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'type', array('1'=>'图片','2'=>'压缩文件','3'=>'PDF文档','4'=>'Word文档','5'=>'Excel文档','6'=>'其他')); ?> 
                <?php echo $form->error($model, 'type'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'title') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'title'); ?>
                <?php echo $form->error($model, 'title'); ?>
            </td>
        </tr>

        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'path'); ?><br />
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'Attachment_path', 'msg' => '图片不大于2M', 'return_size_name' => 'mini', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'path'); ?>
                <?php if ($model->path) : ?>
                    <br /><img src="<?php echo Yii::app()->request->baseUrl . '/' . $model->path; ?>">
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-green')); ?>
                <?php echo CHtml::htmlButton('取消', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
            </td>
        </tr>  
    </table>
    <?php $this->endwidget(); ?>
</div>
