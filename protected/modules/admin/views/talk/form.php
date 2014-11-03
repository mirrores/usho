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
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>话题</td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'user_id') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'user_id',array('style' => 'width:200px;')); ?>
                <span id="user_name"></span>
                <?php echo $form->error($model, 'user_id'); ?>
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
                <?php echo $form->labelEx($model, 'content') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'content', array('style' => 'width:900px;height:350px')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_public') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_public', array('1' => '公开', '0' => '不公开'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_anonymity') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_anonymity', array('1' => '匿名', '0' => '不匿名'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_fixed') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_fixed', array('1' => '置顶', '0' => '不置顶'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_release') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_release', array('1' => '已审核', '0' => '未审核'), array('separator' => false)); ?>
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
Common::ueditor('Talk_content');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#Talk_user_id").val(<?= Yii::app()->user->id;?>);
        $("#user_name").html('<?= User::model()->findByPk(Yii::app()->user->id)->name;?>');
    })
    
    $("#Talk_user_id").autocomplete({
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