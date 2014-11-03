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
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>活动</td>
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
                <?php echo $form->labelEx($model, 'category_id') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'category_id', Event::model()->getCategory()); ?> 
                <?php echo $form->error($model, 'category_id'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'start_date') ?>
            </td>
            <td>
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $this->widget('CJuiDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'start_date',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'timeFormat'=>'hh:mm:ss',
                    ),
                    'htmlOptions' => array(
                    )
                ));
                ?>
                <?php echo $form->error($model, 'start_date'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'finish_date') ?>
            </td>
            <td>
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $this->widget('CJuiDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'finish_date',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'timeFormat'=>'hh:mm:ss',
                    ),
                    'htmlOptions' => array(
                    )
                ));
                ?>
                <?php echo $form->error($model, 'finish_date'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'alumni_id') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'alumni_id',array('style' => 'width:200px;')); ?>
                <span id="alumni_name"></span>
                <?php echo $form->error($model, 'alumni_id'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'promoter') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'promoter'); ?>
                <?php echo $form->error($model, 'promoter'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'sponsor') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'sponsor'); ?>
                <?php echo $form->error($model, 'sponsor'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'organise') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'organise'); ?>
                <?php echo $form->error($model, 'organise'); ?>
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
                <?php echo $form->labelEx($model, 'keyword') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'keyword'); ?>
                <?php echo $form->error($model, 'keyword'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'source') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'source'); ?>
                <?php echo $form->error($model, 'source'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'img_path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'img_path'); ?><br />
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'Event_img_path', 'msg' => '图片不大于2M', 'return_size_name' => 'thumbnail', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'img_path'); ?>
                <?php if ($model->img_path) : ?>
                    <br /><img src="<?php echo Yii::app()->request->baseUrl . '/' . $model->img_path; ?>">
                <?php endif; ?>
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
                <?php echo $form->labelEx($model, 'is_recommend') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_recommend', array('1' => '推荐', '0' => '不推荐'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_closed') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_closed', array('1' => '已审核', '0' => '未审核'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model, 'intro') ?></td>
            <td>
                <?php echo $form->textArea($model, 'intro', array('style' => 'width:900px;height:80px')); ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <?php echo $form->textArea($model, 'content', array('style' => 'width:900px;height:350px')); ?>
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
Common::ueditor('Event_content');
?>

<script type="text/javascript">
    $("#Event_alumni_id").autocomplete({
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
