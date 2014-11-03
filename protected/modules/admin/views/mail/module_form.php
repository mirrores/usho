<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    ?>

<div id="page_head"> 
    <p class="title" style="width: 300px"><?= $mail->name?> — <?= $model->isNewRecord ? '添加' : '编辑' ?>模块</p>
</div>
    
    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">

        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'style_id') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'style_id', MailModuleStyle::model()->getCategoryList(),array('empty'=>'选择样式')); ?> 
                <?php echo $form->error($model, 'style_id'); ?>
            </td>
        </tr>
        
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
                <?php echo $form->labelEx($model, 'url') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'url', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'url'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'img_path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'img_path', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'img_path'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'order_num') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'order_num', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'order_num'); ?>
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'intro') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'intro', array('style' => 'width:900px;height:150px')); ?>
                <?php echo $form->error($model, 'intro'); ?>
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
