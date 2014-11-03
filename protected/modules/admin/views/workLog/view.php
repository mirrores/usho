<div style="font-size: 13px;margin: 10px 5px">

    <table width="98%" border="0" cellpadding="2" cellspacing="1"  style="margin-top:8px" class="form_table">

        <tr>
            <td align="right">
                工作内容
            </td>
            <td>
                <?php echo $model->content; ?>
            </td>
        </tr>
        <tr>
            <td align="right">
                工作进行状态
            </td>
            <td>
                <?php echo $model->status; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php echo CHtml::htmlButton('返回', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
            </td>
        </tr>  
    </table>
    
</div>