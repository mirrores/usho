<!--  内容列表   -->
 <div style="font-size: 13px;margin: 10px 5px">
            
            <?php $form = $this -> beginWidget('CActiveForm'); ?>
           <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">
   
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'genre_code') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'genre_code',array('size'=>30,'maxlength'=>20,'class'=>'abc')); ?>
                        <?php echo $form->error($model,'genre_code');?>
                    </td>
                </tr>
                   <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'nature_name') ?>
                    </td>
                    <td>
                        <?php echo $form ->textField($model,'nature_name',array('size'=>30,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'nature_name');?>
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
</body>
</html>