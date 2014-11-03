<!--body-->
<div class="m m_b14">
	<div class="y_pm f_right">
    	<dl class="k_dl4 m_b14">
        	<dt>
        	  <h1>相关新闻</h1><em></em><?php if(count($my_school_news_list)>0):?><a href="<?=Yii::app()->createUrl('news/index',array('alumni_id'=>$alumni['id']));?>"><span style="color:#f00">更多</span></a><?php endif;?>
            </dt>
            <dd class="ar_sho">
                
              
            	<ul>
                    <?php if(count($my_school_news_list)>0):?>
                    <?php foreach ($my_school_news_list as $value) {?>
                    
                    <li><i></i><h1><a href="<?= Yii::app()->createUrl('news/view', array('id' => $value['id'])); ?>"><?= $value['title']; ?></a></h1></li>  
                <?php }?>
                    <?php else:?>
                    <li><i></i><h1>暂无新闻</h1></li>  
                    <?php endif;?>
                </ul>
            </dd>
        </dl>
        <dl class="k_dl4 m_b14">
        	<dt>
                <h1>相关活动</h1><em></em><?php if(count($my_school_news_list)>0):?><a href="<?=Yii::app()->createUrl('event/index',array('alumni_id'=>$alumni['id']));?>"><span style="color:#f00">更多</span></a><?php endif;?>
            </dt>
            <dd class="ar_sho">
            	<ul>
                       <?php if(count($my_school_news_list)>0):?>
                     <?php foreach ($my_school_event_list as $value) {?>
                    <li><i></i><h1><a href="<?= Yii::app()->createUrl('event/view', array('id' => $value['id'])); ?>"><?= $value['title']; ?></a></h1></li>
                     <?php }?>
                    <?php else:?>
                    <li><i></i><h1>暂无活动</h1></li>  
                    <?php endif;?>
                </ul>
            </dd>
        </dl>
    </div>
	<!---->
	<div class="ar_sho fl_left w_780">
    	<img src="<?= Yii::app()->request->baseUrl; ?>/static/images/atricle_1.jpg" style="display:block;" />
        <div class="art_showdiv">
        	<div class="h_24"></div>
            <div class="alumni_tit">
            	<div class="a_name"><span><?=$alumni['school']['name']?>校友会</span><em></em></div>
                <?php if($alumni['website']){?>
                <?php if((int)$alumni_lists['alumni_id']==(int)$alumni['id']){?>
                <a href="" class="attention"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ico_16.png" />已关注</a>
                <?php }else{ ?>
                <a href="javascript:void(0);" class="attention" id="user_marked"><img src="<?= Yii::app()->request->baseUrl; ?>/static/images/ico_16.png" />加关注</a>
                <?php }}?>
                
            </div>
            <div class="alumni_content">
            	<dl>
                	<dt><i>●</i> 基本介绍</dt>
                    <dd><?=$alumni['introduction']?$alumni['introduction']:'暂无';?>  </dd>
                </dl>
                <dl>
                	<dt><i>●</i> 联系方式</dt>
                        <dd>校友会网址：<?php if($alumni['website']){?><a href="<?=$alumni['website']?>" target="_blank"><?=$alumni['website'];?></a><?php }else {echo '暂无';}?></dd>
                </dl>
            </div>
            
            <!--相关信息
            <dl class="correlation f_left">
            	<dt><span>相关新闻</span></dt>
                <dd>
                	<a href="">把梦想"码"进现实 ——访计算机学院2013</a>
                    <a href="">我院4项研究成果获浙江省第十七届哲学社会</a>
                    <a href="">教育学院青年教师联谊会理事会换届会议暨</a>
                    <a href="">沈会长访问杭州浙大校友会</a>
                    <a href="">我会沈会长向校友总会报告工</a>
                </dd>
            </dl>
            <dl class="correlation f_right">
            	<dt><span>相关活动</span></dt>
                <dd>
                	<a href="">把梦想"码"进现实 ——访计算机学院2013</a>
                    <a href="">我院4项研究成果获浙江省第十七届哲学社会</a>
                    <a href="">教育学院青年教师联谊会理事会换届会议暨</a>
                    <a href="">沈会长访问杭州浙大校友会</a>
                    <a href="">我会沈会长向校友总会报告工</a>
                </dd>
            </dl>
            -->
            <div style="clear:left"></div>
        </div>
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#user_marked').click(function() {
            $.ajax({
                type: 'post',
                url: '<?= Yii::app()->createUrl('alumni/mark',array('id'=>$alumni['id'])); ?>',    
            });
        })
     })
</script>

