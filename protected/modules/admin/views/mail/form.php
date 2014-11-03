<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    ?>

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">
        <tr>
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '编辑' ?>邮件</td>
        </tr>
        
        <tr style="margin-bottom: ">
            <td align="right" style="width: 100px">
                <?php echo $form->labelEx($model, 'template_id') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'template_id', MailTemplate::model()->getCategoryList(),array('empty'=>'请选择')); ?> 
                <?php echo $form->error($model, 'template_id'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'subject') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'subject', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'subject'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'object_id') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'object_id', UserList::model()->getList()); ?> 
                <?php echo $form->error($model, 'object_id'); ?>
            </td>
        </tr>
        

        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'issue') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'issue', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'issue'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'content_type') ?>
            </td>
            <td>
                <?php echo CHtml::activeRadioButtonList($model,'content_type', array('column'=>'从栏目自动生成','custom'=>'自定义邮件内容')); ?>
                <?php echo $form->error($model, 'content_type'); ?>
            </td>
        </tr>
        
        <tr id="content_box" style="display: <?=$model->content_type=='column'?'none':'';?>">
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
                <a href="<?= $this->createUrl('index') ?>" class="btn">取消</a>
            </td>
        </tr>  
    </table>
    <?php $this->endwidget(); ?>
</div>


<?php
//Common::ueditor('Mail_content','base',array('sourceEditorFirst'=>'false','initialStyle'=>'"p{padding:0;text-indent: 0px;}"'));
?>


<script type="text/javascript">
    $(document).ready(function() {
        $radio =$("input:radio[name='Mail[content_type]']");
        $content_box=$('#content_box');
        $radio.bind('click', function() {
           if($(this).val()=='custom'){
               $content_box.show();
           }
           else{
               $content_box.hide();
           }
        })
    })
</script>