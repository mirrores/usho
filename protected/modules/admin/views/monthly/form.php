<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'about-form',
        'enableAjaxValidation' => false
    ));
    ?>

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">
        <tr>
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '编辑' ?>月报</td>
        </tr>
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'template_id') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'template_id', MonthlyTemplate::model()->getCategoryList(),array('empty'=>'请选择')); ?> 
                <?php echo $form->error($model, 'template_id'); ?>
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
                <?php echo $form->labelEx($model, 'subject') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'subject', array('size' => 15, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'subject'); ?>
                <span style="color: #999">使用 {user_title} 替代用户称谓</span> 
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
                <?php echo $form->labelEx($model, 'send_progress') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'send_progress', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'send_progress'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_send_completed') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'is_send_completed', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'is_send_completed'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'send_completed_date') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'send_completed_date', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'send_completed_date'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'sent_num') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'sent_num', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'sent_num'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'cover_img_path') ?>
            </td>
            <td>
                <?php
                if (!$model->isNewRecord) {
                    ?>
                    <img src="<?= Yii::app()->baseUrl .  $model->cover_img_path; ?>">
                    <?php
                }
                ?>
                <?php echo $form->textField($model, 'cover_img_path'); ?><br />
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'Monthly_cover_img_path', 'msg' => '图片不大于2M', 'return_size_name' => 'thumbnail', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'cover_img_path'); ?>
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
