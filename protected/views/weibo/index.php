<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/pager.css" type="text/css" rel="stylesheet" />
<link href="<?= Yii::app()->request->baseUrl; ?>/static/css/weibo.css" type="text/css" rel="stylesheet" />
<script src="<?= Yii::app()->request->baseUrl; ?>/static/js/weibo.js" type="text/javascript" language="javascript" ></script>
<!--body-->
<div class="m m_b14">
    <div class="w_260 f_right">
        <?php echo Controller::followersRank(); ?>
        <?php echo Controller::statusesRank(); ?>
        <?php echo Controller::cityWide(); ?>
        <?php echo Controller::mySchoolWeibo(); ?>
        <?php echo Controller::iFocusAlumniWeibo(); ?>
    </div>
    <!---->
    <div class="fl_left w_730">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/atricle_1.jpg" style="display:block;width:730px;" />
        <div class="art_showdiv">
            <div class="weibo">
                <p>
                	<script language="javascript">
                		//退出微博
					    function logout_weibo() {
					        if (confirm("如果你需要更换其他的微博账号登陆，请点确定。")) {
					            var iframe = document.createElement("iframe");
					            iframe.src = "http://weibo.com/logout.php";
					            iframe.id = "logout";
					            iframe.style.display = "none";

					            if (iframe.attachEvent){
					                iframe.attachEvent("onload", function(){
					                    alert("注销成功，点确定返回");
					                });
					            } else {
					                iframe.onload = function(){
					                    alert("注销成功，点确定返回");
					                };
					    }
					    document.body.appendChild(iframe);
					        }
					    }
					</script>
                </p>
                <div class="title">热帖推荐</div>
                <div class="content">
                    <?php if(!empty($record)){ ?>
                    <ul>
                        <li class="li_list">
                        	<h1><img src="<?=$record->profile_image_url?>" /></h1>
                        	<dl>
                                    <dt><a href="http://www.weibo.com/u/<?=$record->user_id?>" target="_blank"><?=$record->screen_name ?></a><em><?=date('Y-m-d',$record->created_at) ?></em></dt>
                                <dd>
                                    <?=$record->text?>
                                    <?php if(!empty($record->pic_urls)){ ?>
                                    <div>
                                        <span style="display: inline-block;" class="photoBox">
                                            <div style="display: none;" class="loadingBox">
                                                <span class="loading"></span>
                                            </div>
                                            <?php for($i=0;$i<count($record->pic_urls);$i++){ ?>
                                                <img src="<?=str_replace('/thumbnail/','/square/',$record->pic_urls[$i]['thumbnail_pic']) ?>" class="zoom" onclick="zoom_image($(this).parent(),this);">
                                            <?php } ?>
                                        </span>
                                        <div class="photoArea" style="display: none;">
                                            <!--BEGIN-->
                                            <div class="zoombox">
                                                <div class="zoompic"><img style="display: inline;" src="about:blank" onclick="zoom_image($(this).parent().parent().parent(),this);" class="minifier"></div>
                                                <div class="sliderbox">
                                                    <div class="btn-left arrow-btn dasabled"></div>
                                                    <div class="thumbnail slider" id="thumbnail">
                                                        <ul style="width: 847px; left: 0px;">
                                                            <?php for($i=0;$i<count($record->pic_urls);$i++){ ?>
                                                            <li class=""><img src="<?=str_replace('/thumbnail/','/square/',$record->pic_urls[$i]['thumbnail_pic']) ?>"></li>
                                                            <?php } ?>
                                                        </ul>
                                                        <input type="hidden" value="0" class="slider_count">
                                                    </div>
                                                    <div style="cursor:pointer;" class="btn-right arrow-btn"></div>
                                                </div>
                                            </div>
                                            <!--END-->
                                            <p class="toolBar gc">
                                                <span><a class="green" href="javascript:void(0)" onclick="zoom_image($(this).parent().parent().parent());">收起</a></span>
                                            </p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- div style="padding-top: 5px; height: 30px;">
                                        <table style="float: right;">
                                            <tr>
                                                <td width="70">转发数：<?=$record->reposts_count?></td>
                                                <td width="70">评论数：<?=$record->comments_count?></td>
                                                <td width="70">点赞数：<?=$record->attitudes_count?></td>
                                            </tr>
                                        </table>
                                    </div -->
                                </dd>
                            </dl>
                        </li>
                    </ul>
                    <p class="title">TA的微博</p>
                    <?php } ?>
                    <ul>
                    	<?php foreach($records as $v){ ?>
                        <li class="li_list">
                                <?php if(empty($record)){ ?><h1><img src="<?=$v->profile_image_url?>" /></h1><?php } ?>
                        	<dl>
                                    <dt><?php if(empty($record)){ ?><a href="http://www.weibo.com/u/<?=$v->user_id?>" target="_blank"><?=$v->screen_name ?></a><?php } ?><em><?=date('Y-m-d',$v->created_at) ?></em></dt>
                                <dd>
                                    <?=$v->text?>
                                    <?php if(!empty($v->pic_urls)){ ?>
                                    <div>
                                        <span style="display: inline-block;" class="photoBox">
                                            <div style="display: none;" class="loadingBox">
                                                <span class="loading"></span>
                                            </div>
                                            <?php for($i=0;$i<count($v->pic_urls);$i++){ ?>
                                                <img src="<?=str_replace('/thumbnail/','/square/',$v->pic_urls[$i]['thumbnail_pic']) ?>" class="zoom" onclick="zoom_image($(this).parent(),this);">
                                            <?php } ?>
                                        </span>
                                        <div class="photoArea" style="display: none;">
                                            <!--BEGIN-->
                                            <div class="zoombox">
                                                <div class="zoompic"><img style="display: inline;" src="about:blank" onclick="zoom_image($(this).parent().parent().parent(),this);" class="minifier"></div>
                                                <div class="sliderbox">
                                                    <div class="btn-left arrow-btn dasabled"></div>
                                                    <div class="thumbnail slider" id="thumbnail">
                                                        <ul style="width: 847px; left: 0px;">
                                                            <?php for($i=0;$i<count($v->pic_urls);$i++){ ?>
                                                            <li class=""><img src="<?=str_replace('/thumbnail/','/square/',$v->pic_urls[$i]['thumbnail_pic']) ?>"></li>
                                                            <?php } ?>
                                                        </ul>
                                                        <input type="hidden" value="0" class="slider_count">
                                                    </div>
                                                    <div style="cursor:pointer;" class="btn-right arrow-btn"></div>
                                                </div>
                                            </div>
                                            <!--END-->
                                            <p class="toolBar gc">
                                                <span><a class="green" href="javascript:void(0)" onclick="zoom_image($(this).parent().parent().parent());">收起</a></span>
                                            </p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- div style="padding-top: 5px; height: 30px;">
                                        <table style="float: right;">
                                            <tr>
                                                <td width="70">转发数：<?=$v->reposts_count?></td>
                                                <td width="70">评论数：<?=$v->comments_count?></td>
                                                <td width="70">点赞数：<?=$v->attitudes_count?></td>
                                            </tr>
                                        </table>
                                    </div -->
                                </dd>
                            </dl>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <!--page-->
                <div class="page_list clr">
                    <?php
                    $this->widget('CLinkPager', array(
                        'header' => false,
                        'firstPageLabel' => '第一页',
                        'lastPageLabel' => '最后一页',
                        'prevPageLabel' => '上一页',
                        'nextPageLabel' => '下一页',
                        'pages' => $pages,
                        'cssFile' => false,
                    ))
                    ?>
                    <div class="clr"></div>
                </div>
                <div class="" style="clear:left;"></div>
            </div>
        </div><!--comment-->
        <div class="hd_lbtm"></div>
    </div>
    <div class="clr"></div>
</div>