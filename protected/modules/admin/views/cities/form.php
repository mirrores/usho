 <div style="font-size: 13px;margin: 10px 5px">
            <?php $form = $this -> beginWidget('CActiveForm'); ?>
           <table width="98%" border="0" cellpadding="2" cellspacing="1" class="form_table"  align="center" style="margin-top:8px">
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'province_id') ?>
                    </td>
                    <td>
                        <?php echo $form ->dropDownList($model,'province_id',CHtml::listData(Provinces::model()->findAll(), 'id', 'name'), array('empty' => '-请选择-')); ?>
                        <?php echo $form->error($model,'province_id')?>
                    </td>
                </tr> 
               <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'id') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'id');?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'name') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'name',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'name')?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'city_id') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'city_id',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'city_id');?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <?php echo $form -> labelEx($model, 'pinyin') ?>
                    </td>
                    <td>
                        <?php echo $form -> textField($model,'pinyin',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'pinyin');?>
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
