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
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>客户联系日志</td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'client_id') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'client_id',array('style' => 'width:200px;')); ?>
                <span id="user_name"></span>
                <?php echo $form->error($model, 'client_id'); ?>
                <a href="<?= Yii::app()->createUrl('admin/user/create')?>" target="_blank"><?php echo CHtml::htmlButton('添加新用户', array('class' => 'btn btn-green',)); ?></a>
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
            <td align="right">
                <?php echo $form->labelEx($model, 'next_client_date') ?>
            </td>
            <td>
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $this->widget('CJuiDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'next_client_date',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'timeFormat'=>'hh:mm:ss',
                    ),
                    'htmlOptions' => array(
                    )
                ));
                ?>
                <?php echo $form->error($model, 'next_client_date'); ?>
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

<?php
//Common::ueditor('ClientLog_content');
?>

<script type="text/javascript">
    $("#ClientLog_client_id").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= $this->createUrl('/user/autocomplete') ?>",
                dataType: "json",
                data: {
                    searchDbInforItem: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value
                        }
                    }));
                }
            });
        },
        minLength: 1,
        select: function(event, ui) {
            $("#user_name").html(ui.item.label);
        }
    });
</script>