<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl ?>/static/css/jquery-ui.css">

<div style="font-size: 13px;margin: 10px 5px">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'monthlydata-form',
        'enableAjaxValidation' => false
    ));
    ?>

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">
        <tr>
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>文章</td>
        </tr>
        
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'news_id') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'news_id',array('style' => 'width:200px;')); ?>
                <?php echo $form->error($model, 'news_id'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'event_id') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'event_id',array('style' => 'width:200px;')); ?>
                <?php echo $form->error($model, 'event_id'); ?>
            </td>
        </tr>
        
        
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'title') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'title', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'title_color') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'title_color', array('size' => 10, 'maxlength' => 50, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'title_color'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'column_id') ?>
            </td>
            <td>
                <?= $form->dropDownList($model, 'column_id', CHtml::listData(MonthlyColumn::model()->findAllBySql('SELECT * FROM monthly_column WHERE monthly_id=' . $monthly_id . ' ORDER BY id DESC'), 'id', 'name')); ?> 
                <?php echo $form->error($model, 'column_id'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'intro') ?>
            </td>
            <td>
                <?php echo $form->textArea($model, 'intro', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'intro'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'keyword') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'keyword', array('size' => 10, 'maxlength' => 100, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'keyword'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'author') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'author', array('size' => 10, 'maxlength' => 100, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'author'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'source_url') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'source_url', array('size' => 10, 'maxlength' => 255, 'class' => 'abc')); ?>
                <?php echo $form->error($model, 'source_url'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'img_path') ?>
            </td>
            <td>
                <?php
                if (!$model->isNewRecord) {
                    ?>
                    <img src="<?php echo Yii::app()->request->baseUrl . $model->img_path; ?>">
                    <?php
                }
                ?>
                <?php echo $form->textField($model, 'img_path'); ?><br />
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'MonthlyData_img_path', 'msg' => '图片不大于2M', 'return_size_name' => 'thumbnail', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'img_path'); ?>
            </td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model, 'content') ?></td>
            <td>
                <?php echo $form->textArea($model, 'content', array('style' => 'width:900px;height:400px')); ?>
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
Common::ueditor('MonthlyData_content');
?>

<script type="text/javascript">
    $("#MonthlyData_news_id").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= $this->createUrl('/news/autocomplete') ?>",
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
            $("#MonthlyData_title").val(ui.item.label);
        }
    });
    
    $("#MonthlyData_event_id").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= $this->createUrl('/event/autocomplete') ?>",
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
            $("#MonthlyData_title").val(ui.item.label);
        }
    });
</script>