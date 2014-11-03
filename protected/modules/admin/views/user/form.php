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
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>用户</td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'name') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'name'); ?>
                <?php echo $form->error($model, 'name'); ?>
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
                <?php echo $form->labelEx($model, 'sex') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'sex', array('男' => '男', '女' => '女'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr id="school_tr">
            <td align="right">
                <?php echo $form->labelEx($model, 'alumni_id') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'alumni_id',array('style' => 'width:300px;')); ?>
                &nbsp;&nbsp;&nbsp;<span id="alumni_name"></span>
                <?php echo $form->error($model, 'alumni_id'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'department') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'department'); ?>
                <?php echo $form->error($model, 'department'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'position') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'position'); ?>
                <?php echo $form->error($model, 'position'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'player') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'player'); ?>
                <?php echo $form->error($model, 'player'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'account') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'account'); ?>
                <?php echo $form->error($model, 'account'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'address') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'address'); ?>
                <?php echo $form->error($model, 'address'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'tel') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'tel'); ?>
                <?php echo $form->error($model, 'tel'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'mobile') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'mobile'); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'fax') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'fax'); ?>
                <?php echo $form->error($model, 'fax'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'qq') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'qq'); ?>
                <?php echo $form->error($model, 'qq'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_public_email') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_public_email', array('1' => '已查到', '0' => '未查到'), array('separator' => false)); ?>
                <?php echo $form->error($model, 'is_public_email'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_subscription') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_subscription', array( '1' => '订阅','0' => '退订',), array('separator' => false)); ?>
                <?php echo $form->error($model, 'is_subscription'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'note') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'note',array('style' => 'width:700px;height:100px')); ?>
                <?php echo $form->error($model, 'note'); ?>
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


<script type="text/javascript">
    $("#User_alumni_id").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= $this->createUrl('/alumni/autocomplete') ?>",
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
        minLength: 2,
        select: function(event, ui) {
            $("#alumni_name").html(ui.item.label);
        }
    });
</script>