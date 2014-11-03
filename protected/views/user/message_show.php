<!--body-->
<div class="m m_b14"><!---->
	<div class=" fl_left w_1000">
    	<img src="<?= Yii::app()->request->baseUrl; ?>/static/images/search_1.jpg" style="display:block;" />
        <div class="member_m">
            <!--right-->
            <div class="member_right">
            	<div class="site">位置：会员中心 － 我的留言</div>
                <div class="select_child">
                	<div class="menu">
               <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
                )); ?>
                    </div>
                    <div class="body">
   	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50" class="b">标题</td>
                            <td class="b">内容</td>
                            <td width="150" class="b">日期</td>
                          </tr>
                         
                          <tr>
                            <td height="30" align="center"><?php echo $model->title;?></td>
                            <td class="t"><?=$model->content;?></td>
                            <td align="center"><?=$model->create_date;?></td>
                             <?php echo $form->hiddenField($model,'is_read',array('value'=>1)); ?> 
                          </tr>
                        </table>
		<div class="page_list clr" style="padding-left:0;">
                    <div class="clr" style="float: right"><?php echo CHtml::submitButton($model->isNewRecord ? '确定' : '确定', array('class' => 'btn btn-green')); ?></div>
                            <?php $this -> endwidget(); ?>
                        </div>
                  </div>
                </div>
            </div>
            <!--left-->
            <div class="member_left">
            	<img src="<?= Yii::app()->request->baseUrl; ?>/static/images/member_1.jpg" />
                <div class="bg">
                     <ul>
                    	<li><a href="<?= Yii::app()->createUrl('user')?>" class="ico_11">我的信息</a></li><!--on 选中样式-->
                                <li><a href="<?= Yii::app()->createUrl('user/mark')?>" class="ico_12">我的关注</a></li>
                                <li><a href="<?= Yii::app()->createUrl('user/message')?>" class="ico_13 on">我的留言<i></i></a></li>
                                <li><a href="<?= Yii::app()->createUrl('user/changepassword')?>" class="ico_14">修改密码</a></li>
                                <li><a href="<?= Yii::app()->createUrl('site/logout')?>" class="ico_15">安全退出</a></li>
                    </ul>
                </div>
                <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/member_3.jpg" />
            </div>
            
            <div class="clr"></div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>
