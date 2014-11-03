<!--  内容列表   -->
 <div style="font-size: 13px;margin: 10px 5px">
            
            <?php $form = $this -> beginWidget('CActiveForm'); ?>
     <table width="98%" border="0" cellpadding="2" cellspacing="1" class="form_table" align="center" style="margin-top:8px">

                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'name') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'name',array('size'=>30,'maxlength'=>20,'class'=>'abc')); ?>
                        <?php echo $form->error($model,'name');?>
                    </td>
                </tr>
                   <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'intro') ?>
                    </td>
                    <td>
                        <?php echo $form ->textArea($model,'intro',array('cols'=>50,'rows'=>10)); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'is_public') ?>
                    </td>
                    <td>
                        <?php echo $form -> radioButtonList($model,'is_public',array('1'=>'允许会员使用','0'=>'不允许会员使用'),array('separator'=>false)); ?>
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
