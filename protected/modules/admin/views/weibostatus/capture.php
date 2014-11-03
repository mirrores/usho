<style>
    .capture{line-height: 30px;}
</style>

<div id="page_head"> 
    <p class="title">微博管理</p>
</div>

<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#D1DDAA" style="margin-top:8px">
  <tr height="50" bgcolor="#FFFFFF" onmouseout="javascript:this.bgColor = '#FFFFFF';" onmousemove="javascript:this.bgColor = '#FCFDEE';">
    <td style="padding-left: 20px; text-align: left" width="100">一键抓取微博</td>
    <td style="padding-left: 20px; text-align: left">已抓取：<span id="finish_count">0</span> 状态：<span id="capture_status"></span></td>
    <td width="100" align="center"><a href="javascript:start_capture();" class="btn btn-green">开始</a></td>
  </tr>
  <tr height="50" bgcolor="#FFFFFF" onmouseout="javascript:this.bgColor = '#FFFFFF';" onmousemove="javascript:this.bgColor = '#FCFDEE';">
    <td style="padding-left: 20px; text-align: left">一键转发微博</td>
    <td style="padding-left: 20px; text-align: left">日期:
	<?php  
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(  
            'language'=>'zh_cn',  
            'name'=>'repost[start]',  
            //'value'=>$query['start']?$query['start']:Date('Y-m-d'),
			'value'=>Date('Y-m-d',  time()-86400*7),  
            'options'=>array(  
                        'showAnim'=>'fold',  
                        'showOn'=>'both',  
                        'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.gif',  
                        'maxDate'=>'new Date()',  
                        'buttonImageOnly'=>true,  
                        'dateFormat'=>'yy-mm-dd',  
            ),  
            'htmlOptions'=>array(  
                        'style'=>'height:18px;width:70px;margin:0;',  
                        'maxlength'=>8,  
            ),  
    ));  
    ?>
     - 
    <?php  
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'language'=>'zh_cn',  
            'name'=>'repost[end]',  
            //'value'=>$query['start']?$query['start']:Date('Y-m-d'),
			'value'=>Date('Y-m-d'),  
            'options'=>array(  
                        'showAnim'=>'fold',  
                        'showOn'=>'both',  
                        'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.gif',  
                        'maxDate'=>'new Date()',  
                        'buttonImageOnly'=>true,  
                        'dateFormat'=>'yy-mm-dd',  
            ),  
            'htmlOptions'=>array(  
                        'style'=>'height:18px;width:70px;margin:0;',  
                        'maxlength'=>8,  
            ),  
    ));  
    ?> 条件：<input type="checkbox" name="retweeted_status" id="retweeted_status"value="1" checked="checked" />原创 
    <input type="checkbox" name="comments_count" id="comments_count" value="1" checked="checked" />跟贴数最多 
    前 <input type="text" name="number" id="number" value="10" style="width:30px;margin:0;text-align: center;" /> 条 
    状态：<span id="repost_status"></span> <span id="repost_finish_count">0</span>
    </td>
    <td align="center"><a href="javascript:start_repost();" class="btn btn-green">开始</a></td>
  </tr>
  <tr height="50" bgcolor="#FFFFFF" onmouseout="javascript:this.bgColor = '#FFFFFF';" onmousemove="javascript:this.bgColor = '#FCFDEE';">
    <td style="padding-left: 20px; text-align: left">&nbsp;</td>
    <td style="padding-left: 20px; text-align: left">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>

<script type="text/javascript" language="javascript">
//一键转发
function start_repost(){
    $.getJSON(
            "/admin/Weibostatus/ajaxrepost/rand/"+Math.random()+
            '/number/'+$('#number').val()+
            '/retweeted_status/'+$('#retweeted_status').val()+
            '/comments_count/'+$('#comments_count').val()+
            '/repost_start/'+$('#repost_start').val()+
            '/repost_end/'+$('#repost_end').val(),
            function(data){
                if(data.status == 'finish'){
                    $('#repost_status').html('完毕');
                    if(data.not_find == 'yes'){
                        $('#repost_status').html('完毕,无符合条件的记录!');
                        $('#repost_finish_count').html('0');
                        alert('无符合条件的记录!');
                    }
                    //$('#finish_count').html('50 条,重复 '+data.repetition+' 条,新增 '+(50-data.repetition)+' 条');
                    clearTimeout(st);
                }else{
                    st = setTimeout("start_repost()",100);
                    if(data.status == 'repost-over'){
                        $('#repost_finish_count').html('0');
                        $('#repost_status').html('重新获取数据...');
                    }else{
                        $('#repost_finish_count').html(data.number);
                        $('#repost_status').html('正在转发到微博...');
                    }
                }
                
           });
}


//一键抓取微博
var st;
function start_capture(){
    $.getJSON(
            "/admin/Weibostatus/ajaxcapture/rand/"+Math.random(),
            function(data){
                if(data.status == 'finish'){
                    $('#capture_status').html('完毕');
                    $('#finish_count').html('50 条,重复 '+data.repetition+' 条,新增 '+(50-data.repetition)+' 条');
                    clearTimeout(st);
                }else{
                    st = setTimeout("start_capture()",100);
                    if(data.status == 'capture-over'){
                        $('#finish_count').html('0');
                        $('#capture_status').html('重新获取数据...');
                    }else{
                        $('#finish_count').html(data.number);
                        $('#capture_status').html('正在写入数据库...');
                    }
                }
              });
}
</script>