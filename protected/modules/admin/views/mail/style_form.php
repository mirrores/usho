<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    $img_dir='http://'.$_SERVER['HTTP_HOST'].'/';
    ?>

    <div id="page_head"> 
        <p class="title" style="width: 300px"><?= $model->isNewRecord ? '添加' : '编辑' ?>模块样式</p>
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
                <?php echo $form->labelEx($model, 'intro') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'intro', array('style' => 'width:900px;height:80px')); ?>
                <?php echo $form->error($model, 'intro'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'img_path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'img_path', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?><br />
                <?php echo $form->error($model, 'img_path'); ?>
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style=" width:600px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'MailColumnStyle_img_path', 'msg' => '不大于2M PNG透明背景LOGO', 'return_size_name' => 'original', 'prefix_path' => $img_dir)) ?>"></iframe>
            </td>
        </tr>


        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'content') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'content', array('style' => 'width:900px;height:350px')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-green')); ?>
                
                <?php if(isset($mail_id)):?>
                <a href="<?= $this->createUrl('columns',array('mail_id'=>$mail_id)) ?>" class="btn btn-green">取消</a>
                <?php else:?>
                <a href="<?= $this->createUrl('column_style') ?>" class="btn btn-green">取消</a>
                <?php endif;?>
            </td>
        </tr>  
    </table>
    <?php $this->endwidget(); ?>
</div>
