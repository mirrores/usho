
<!--  内容列表   -->
 <div style="font-size: 13px;margin: 10px 5px">
            
            <?php $form = $this -> beginWidget('CActiveForm',array(
                'id'=>'pro-form',
                'enableAjaxValidation'=>false,
                )); ?>
    
            <table width="98%" border="0" cellpadding="2" cellspacing="1" align="center" style="margin-top:8px">

                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'pro_name') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'pro_name',array('size'=>10,'maxlength'=>20,'class'=>'abc')); ?>
                    </td>
                </tr>
                
                 <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'pro_image') ?>
                    </td>
                    <td>
                       <?php echo $form->textField($model, 'pro_image'); ?><br />
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="<?= Yii::app()->baseUrl ?>/static/icon/loading2.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src=" <?= $this->createUrl('/upload/img', array('no' => null, 'hidden_fieid' => 'Product_pro_image', 'msg' => '图片不大于2M', 'return_size_name' => 'thumbnail', 'prefix_path' => null)) ?>"></iframe>
                <?php echo $form->error($model, 'pro_image'); ?>
                <?php if ($model->pro_image) : ?>
                <br /><img src="<?php echo Yii::app()->request->baseUrl . '/' . $model->pro_image; ?>">
                <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td >
                        <?php echo $form -> labelEx($model, 'pro_content') ?>
                    </td>
                    <td>
                           <?php echo $form->textArea($model, 'pro_content', array('style' => 'width:900px;height:400px')); ?>
                    </td>
                </tr>
               
                <tr>
                    <td colspan="2" align="center">
                        <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-green')); ?>
                     <?php echo CHtml::htmlButton('取消', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
                    
                    </td>
                </tr>  
            </table>
            <?php $this -> endwidget(); ?>
        </div>
<?php Common::ueditor('Product_pro_content');?>