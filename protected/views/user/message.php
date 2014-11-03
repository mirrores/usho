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
                   	  <a href="<?= Yii::app()->createUrl('user/message');?>" class="tab">咨询</a>
                      <a href="<?= Yii::app()->createUrl('user/message', array('type' =>2));?>" class="tab">意见建议</a>
                      <a href="<?= Yii::app()->createUrl('user/message', array('type' => 3));?>" class="tab">其他</a>
                    </div>
                    <div class="body">
   	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <!--<td width="50" class="b">选择</td>-->
                              <td widht="100" class="b">标题</td>
                            <td class="b">内容</td>
                            <td width="100" class="b">状态</td>
                            <td width="150" class="b">日期</td>
                          </tr>
                    <?php foreach($list as $value){?>
                      
                          <tr>
                           <!-- <td height="30" align="center"><input type="checkbox" name="checkbox" id="checkbox" />
                            <label for="checkbox"></label></td>-->
                              <td width="150" align="center"><?=$value['title']?></td>
                            <td class="t"><?=$value['content']?></td>
                            <td align="center"><?php if(Message::model()->count('message_id='.$value['id'])==0){ ?>无回复<?php }elseif(Message::model()->count('is_read='.$value['is_read'])==1){ ?><a href="<?= Yii::app()->createUrl('user/messagereply',array('id'=>$value['id'])); ?>"><span style="color:#F00">暂无新回复</span></a><?php }else{ ?><a href="<?= Yii::app()->createUrl('user/messagereply',array('id'=>$value['id'])); ?>"><span style="color:#F00">有新回复(<?=Message::model()->count('is_read=0 and message_id='.$value['id'])?>)</span></a><?php }?></td>
                            <td align="center"><?=$value['create_date']?></td>
                          </tr>
                          <?php
                          }?>
                        </table>
		<div class="page_list clr" style="padding-left:0;">
                        	<!--<span class="delete1" onclick="javascript:vod(0);">删除</span>-->
                            <?php if ($page < $pages) { ?>
                        <a href="<?= Yii::app()->createUrl('message', array('type'=>$type, 'page' => $pages)); ?>">末页</a>
                        <a href="<?= Yii::app()->createUrl('message', array('type'=>$type,  'page' => $page + 1)); ?>">下一页</a>
                    <?php } ?>
                    <?php
                    if ($pages > 5) {
                        if ($page > 2 && $pages - $page > 2) {
                            echo '<a href="' . Yii::app()->createUrl('message', array('type'=>$type, 'page' => $page + 2)) . '">' . ($page + 2) . '</a><a href="' . Yii::app()->createUrl('news', array('category_id'=>$category_id, 'alumni_id'=>$alumni_id, 'page' => $page + 1)) . '">' . ($page + 1) . '</a><a href="' . Yii::app()->createUrl('news', array('category_id'=>$category_id, 'alumni_id'=>$alumni_id, 'page' => $page)) . '">' . $page . '</a><a href="' . Yii::app()->createUrl('news', array('category_id'=>$category_id, 'alumni_id'=>$alumni_id, 'page' => $page - 1)) . '" class="on">' . ($page - 1) . '</a><a href="' . Yii::app()->createUrl('news', array('category_id'=>$category_id, 'alumni_id'=>$alumni_id, 'page' => $page - 2)) . '">' . ($page - 2) . '</a>';
                        } elseif ($page <= 2) {
                            for ($i = 5; $i > 0; $i--) {
                                if ($i == $page) {
                                    echo '<a class="on" href="' . Yii::app()->createUrl('message', array('type'=>$type,  'page' => $page)) . '">' . $page . '</a>';
                                } else {
                                    echo '<a href="' . Yii::app()->createUrl('message', array('type'=>$type,'page' => $i)) . '">' . $i . '</a>';
                                }
                            }
                        } elseif ($pages - $page <= 2) {
                            for ($i = 5; $i > 0; $i--) {
                                if ($pages - $i == $page) {
                                    echo '<a class="on" href="' . Yii::app()->createUrl('message', array('type'=>$type, 'page' => $page)) . '">' . $page . '</a>';
                                } else {
                                    echo '<a href="' . Yii::app()->createUrl('message', array('type'=>$type,  'page' => $page - $i)) . '">' . ($pages - $i) . '</a>';
                                }
                            }
                        }
                    } else {
                        for ($pages; $pages > 0; $pages--) {
                            if ($pages == $page) {
                                echo '<a class="on" href="' . Yii::app()->createUrl('message', array('type'=>$type,  'page' => $pages)) . '">' . $pages . '</a>';
                            } else {
                                echo '<a href="' . Yii::app()->createUrl('message', array('type'=>$type, 'page' => $pages)) . '">' . $pages . '</a>';
                            }
                        }
                    }
                    ?>
                    <?php if ($page > 1) { ?>
                        <a href="<?= Yii::app()->createUrl('message', array('type'=>$type,  'page' => $page - 1)); ?>">上一页</a>
                        <a href="<?= Yii::app()->createUrl('message', array('type'=>$type,  )); ?>">首页</a>
                    <?php } ?>
                            <div class="clr"></div>
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
