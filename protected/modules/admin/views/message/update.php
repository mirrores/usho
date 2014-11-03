<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div style="font-size: 13px;margin: 10px 5px">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
       <table width="98%" border="0" cellpadding="2" cellspacing="1" align="center" style="margin-top:8px">

                <tr>
                    <td align="right">
                        <?php echo $form->labelEx($model,'type'); ?>
                    </td>
                    <td>
                       <?php echo $form->dropDownList($model,'type',array(1=>'意见建议',2=>'产品咨询',3=>'其他')) ;?>
	       <?php echo $form->error($model,'type'); ?>
                    </td>
                </tr>
                <tr>
                  <td align="right">
                        <?php echo $form->labelEx($model,'title'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model,'title',array('readonly'=>true)); ?>
	        <?php echo $form->error($model,'title'); ?>
                    </td>
                </tr>
               <tr>
                    <td align="right">
                       <?php echo $form->labelEx($model,'content'); ?>
                    </td>
                    <td>
                         <?php echo $form->textArea($model, 'content',array('style' => 'width:900px;height:400px','readonly'=>true)); ?>
                        <?php echo $form->error($model,'content'); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                      <?php echo $form->labelEx($model,'keyword'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model,'keyword',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'keyword'); ?>
                    </td>
                </tr>
            
                <tr>
                    <td align="right">
                       <?php echo $form->labelEx($model,'is_recommend'); ?>
		
                    </td>
                    <td>
                         <?php echo $form->radioButtonList($model, 'is_recommend', array('1' => '是', '0' => '否'), array('separator' => false)); ?>      
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


	
	
	
	