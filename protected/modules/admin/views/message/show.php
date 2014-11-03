<div style="font-size: 13px;margin: 10px 5px">
       <table width="98%" border="0" cellpadding="2" cellspacing="1" class="form_table" align="left" style="margin-top:8px">

                <tr>
                    <td align="right" width="150">
                        标题：
                    </td>
                    <td align="left">
                       <?=$message['title'];?>
                    </td>
                </tr>
                <tr>
                  <td align="right">
                        类型：
                    </td>
                    <td align="left">
                       <?php if($message['type']==1){?><?='意见建议';?><?php }elseif ($message['type']==2){?><?='产品咨询';?><?php }else{?><?='其他';?><?php }?>
                    </td>
                </tr>
                 <tr>
                    <td align="right">
                        作者：
                    </td>
                   <td align="left">
                       <?=$message['user']['name'];?>
                    </td>
                </tr>
               <tr>
                    <td align="right">
                       内容：
                    </td>
                    <td align="left">
                         <?=$message['content']?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                      关键字：
                    </td>
                    <td align="left">
                        <?=$message['keyword'];?>
                    </td>
                </tr>
            
                <tr>
                    <td align="right">
                       是否推荐：
		
                    </td>
                    <td align="left">
                         <?=$message['is_recommend']==true?'是':'否';?>     
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                     <?php echo CHtml::htmlButton('返回', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
                    </td>
                </tr>  
            </table>
        </div>
