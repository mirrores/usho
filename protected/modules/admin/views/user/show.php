<div style="font-size: 13px;margin: 10px 5px">
       <table width="98%" border="0" cellpadding="2" cellspacing="1" class="form_table" align="left" style="margin-top:8px">

                <tr>
                    <td align="right" width="150">
                        姓名：
                    </td>
                    <td align="left">
                       <?=$user['name'];?>
                    </td>
                </tr>
                
                <tr>
                    <td align="right" width="150">
                        邮箱：
                    </td>
                    <td align="left">
                       <?=$user['account'];?>
                    </td>
                </tr>
                <tr>
                  <td align="right">
                        所属校友会：
                    </td>
                    <td align="left">
                       <?=$user['alumni']['name']?>
                    </td>
                </tr>
                 <tr>
                    <td align="right">
                        职位：
                    </td>
                   <td align="left">
                       <?=$user['position'];?>
                    </td>
                </tr>
               <tr>
                    <td align="right">
                       电话：
                    </td>
                    <td align="left">
                         <?=$user['tel']?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        手机：
                    </td>
                    <td align="left">
                        <?=$user['mobile'];?>
                    </td>
                </tr>
            
                <tr>
                    <td align="right">
                       备注信息：
		
                    </td>
                    <td align="left">
                         <?=$user['note'];?>     
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                     <?php echo CHtml::htmlButton('返回', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
                    </td>
                </tr>  
            </table>
        </div>
