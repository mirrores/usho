<!--  内容列表   -->
 <div style="font-size: 13px;margin: 10px 5px">
            
            <?php $form = $this -> beginWidget('CActiveForm',array(  'enableAjaxValidation' => false)); ?>
              <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">
   
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'code') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'code',array('size'=>30,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'code');?>
                    </td>
                </tr>
                   <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'gname') ?>
                    </td>
                    <td>
                        <?php echo $form ->textField($model,'name',array('size'=>30,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'name');?>
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
