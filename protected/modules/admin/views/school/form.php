<div style="font-size: 13px;margin: 10px 5px">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'school-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <table width="98%" border="0" cellpadding="2" cellspacing="1" class="form_table"  align="center" style="margin-top:8px">
        <tr>
            <td colspan="2" class="title"><?= $model->isNewRecord ? '添加' : '保存' ?>学校</td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'code') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'code'); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
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
                <?php echo $form->labelEx($model, 'short_name') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'short_name'); ?>
                <?php echo $form->error($model, 'short_name'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'provinces_id') ?>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'provinces_id', CHtml::listData(Provinces::model()->findAll(), 'id', 'name'), array('empty' => '-请选择-')); ?>

            </td>
        </tr>
        <?php if ($model->provinces_id) {?>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'cities_id') ?>
            </td>
            <td>
                <?php
                echo $form->dropDownList(
                    $model, 'cities_id', CHtml::listData(Cities::model()->findAll('province_id=' . $model->provinces_id), 'id', 'name'), array('empty' => '-请选择-')
                );
                ?>
            </td>
        </tr>
        <?php }?>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'nature_code') ?>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'nature_code', CHtml::listData(Nature::model()->findAll(), 'code', 'name'), array('empty' => '-请选择-')); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'genre_code') ?>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'genre_code', CHtml::listData(Genre::model()->findAll(), 'code', 'name'), array('empty' => '-请选择-')); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'company_code') ?>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'company_code', CHtml::listData(Company::model()->findAll(), 'code', 'name'), array('empty' => '-请选择-')); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_star') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_star', array('1' => '重点', '0' => '不重点'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_fixed') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_fixed', array('1' => '定制', '0' => '不定制'), array('separator' => false)); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'is_verify') ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model, 'is_verify', array('1' => '已审核', '0' => '未审核'), array('separator' => false)); ?>
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
                <?php echo $form->labelEx($model, 'logo_path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'logo_path'); ?><br />
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'School_logo_path', 'msg' => '图片不大于2M', 'return_size_name' => 'thumbnail', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'logo_path'); ?>
                <?php if ($model->logo_path) : ?>
                    <br /><img src="<?php echo Yii::app()->request->baseUrl . $model->logo_path; ?>">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'website') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'website'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'weixin') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'weixin'); ?>
                <?php echo $form->error($model, 'weixin'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'erweima_path') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'erweima_path'); ?><br />
                <div id="uploading2" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe2" name="upfileframe2" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => 2, 'hidden_fieid' => 'Alumni_erweima_path', 'msg' => '图片不大于2M', 'return_size_name' => 'thumbnail', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'erweima_path'); ?>
                <?php if ($model->erweima_path) : ?>
                    <br /><img src="<?php echo Yii::app()->request->baseUrl . $model->erweima_path; ?>">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'weibo') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'weibo'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'remark') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'remark'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'keyword') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'keyword'); ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                <?php echo $form->labelEx($model, 'celebration') ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'celebration'); ?>
            </td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model, 'introduction') ?></td>
            <td>
                <?php echo $form->textArea($model, 'introduction', array('style' => 'width:900px;height:400px')); ?>
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
Common::ueditor('School_introduction');
?>