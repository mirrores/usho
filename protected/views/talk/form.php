
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/assets/admin/css/base.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/assets/admin/css/form.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl ?>/static/css/form.css">
<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl ?>/static/css/jquery-ui.css">
<!--body-->
<div class="m m_b14">
    <div class="y_pm f_left">
        <?php echo Controller::actionGetRanking(); ?>
        <span class="link_ad1"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ad_1.jpg" /></span>
    </div>

    <div class="hd_list w_780">
        <dl class="k_dl3">
            <dt><h1>发布讨论话题</h1><em></em></dt>
            <dd>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'school-form',
                    'enableAjaxValidation' => false,
                ));
                ?>
                <table width="98%" border="0" cellpadding="2" cellspacing="1" class="form_table" align="center" style="margin-top:8px">
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
                            <?php echo $form->textArea($model, 'content', array('style' => 'width:650px;height:250px')); ?> 
                            <?php echo $form->error($model, 'content'); ?>
                        </td>
                    </tr>
                    <!--<tr style="height: 32px; line-height: 32px;">
                        <td align="right">
                    <?php echo $form->labelEx($model, 'is_public') ?>
                        </td>
                        <td>
                    <?php echo $form->radioButtonList($model, 'is_public', array('1' => '公开', '0' => '不公开'), array('separator' => false)); ?>
                        </td>
                    </tr>-->
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
                            回答邀请
                        </td>
                        <td>
                            <input type="text" id="alumni_name" style="width:300px"><input type="hidden" id="alumni_id"> &nbsp;<?php echo CHtml::Button('邀请', array('class' => 'btn btn-red', 'id' => 'invite')); ?>(最多可邀请5个校友会)
                            <div></div>
                        </td>
                    </tr>
                    <tr style="height: 50px"><td></td><td id="invite_list"></td></tr>
                    <tr style="height: 20px"></tr>
                    <tr>
                        <td colspan="2" align="center">
                            <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-green')); ?>
                            <?php echo CHtml::htmlButton('取消', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
                        </td>
                    </tr>  
                </table>
                <?php $this->endwidget(); ?>
            </dd>
        </dl>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>
<?php
Common::ueditor('Talk_content');
?>
<script type="text/javascript">
    $("#alumni_name").autocomplete({
        autoFocus: true,
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
                            //value: item.value
                            value: item.label,
                            id: item.value
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#alumni_id").val(ui.item.id);
        }
    });

    $(document).ready(function() {
        $('#invite').click(function() {
            var invite_size = $('.invite').size();
            if (invite_size < 5) {
                $('#invite_list').append('<li style="width:330px;" class="invite" id="invite_' + $('#alumni_id').val() + '">' + $('#alumni_name').val() + '<input type="hidden" name="alumni_id[]" value="' + $('#alumni_id').val() + '"><a style="float:right" href="javascript:void(0);" onclick="$(\'#invite_' + $('#alumni_id').val() + '\').remove();">取消</a></li>');
            } else {
                alert('最多邀请5个校友会!');
            }
        })
    })

</script>