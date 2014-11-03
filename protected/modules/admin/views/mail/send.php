<style type="text/css">
    input[type=button]{padding: 5px 20px;font-size: 14px}
</style>

<div style="margin:20px auto;width:1000px;background: #fff;padding: 20px">
    总发送进度:<span id="sent_num"><?= ($monthly->sent_num / $user_count) * 100 ?></span>%,共<?= $user_count ?>份：
    <div style="width: 100%;background: #eee;padding:4px;border: 1px solid #999;margin: 10px 0">
        <div style="width: 1%;background: #009933;height:10px;" id="progress_bar"></div>
    </div>
    <input type="button" value="发送测试邮件" class="btn btn-green" onclick="sendtest()" id="test_btn"/>
    <input type="button" value="开始发送" class="btn btn-green" onclick="sendmail()" id="start_btn" disabled2="disabled"/>
    <input type="button" value="暂停" class="btn btn-green" onclick="power()" id="power_btn"/>
</div>

<script type="text/javascript">
    var test_btn = $('#test_btn');
    var start_btn = $('#start_btn');
    var power_btn = $('#power_btn');
    var sent_num = $('#sent_num');
    var progress_bar = $('#progress_bar');
    var user_count =<?= $user_count ?>;
    var send_start = 'start';

    //开关
    function power() {

        if (send_start == 'start') {
            send_start = 'stop';
            power_btn.val('继续发送');
        }
        else {
            send_start = 'start';
            start_btn.removeAttr('disabled').val('继续发送中...');
            power_btn.val('暂停');
        }
    }

    //进度控制
    function progressBar(num) {
        var percentage = Math.round((num / user_count) * 100);
        sent_num.html(percentage);
        progress_bar.css('width', percentage + '%');
    }

    //正式发送
    function sendmail() {
        if (send_start == 'stop') {
            start_btn.attr('disabled', 'disabled').val('已暂停');
            return false;
        }

        $.ajax({
            type: "post",
            url: "<?= $this->createUrl('sendmail', array('id' => $monthly->id)); ?>",
            dataType: "text",
            async: true,
            beforeSend: function() {
                start_btn.attr('disabled', 'disabled').val('正在发送，请稍候...');
            },
            error: function() {
                start_btn.attr('disabled', 'disabled').val('系统出错，可能是发送已经达到最大数量！');
            },
            success: function(text) {
                if (text >= 1) {
                    progressBar(text);
                    start_btn.val('发送成功，继续发...');
                    setTimeout(function() {
                        sendmail();
                    }, 300);
                }
                else if (text == 'no user') {
                    start_btn.attr('disabled', 'disabled').val('无发送对象');
                }
                else if (text == 'complete') {
                    start_btn.attr('disabled', 'disabled').val('发送完毕');
                }
                else if (text == 'invalid email') {
                    start_btn.attr('disabled', 'disabled').val('发送失败，无效的email');
                    setTimeout(function() {
                        sendmail();
                    }, 3000);
                }
                else if (text == 'failure') {
                    start_btn.attr('disabled', 'disabled').val('错误出错');
                }
                else {
                    start_btn.val('发送失败，重试').removeAttr("disabled");
                }
            }
        });
    }

    //发送测试邮件
    function sendtest() {
        $.ajax({
            type: "post",
            url: "<?= $this->createUrl('sendmail', array('id' => $monthly->id,'test' =>1)); ?>",
            dataType: "text",
            async: true,
            beforeSend: function() {
                test_btn.attr('disabled', 'disabled').val('正在发送...');
            },
            success: function(text) {
                if (text == 'success') {
                    test_btn.val('发送成功');
                }
                else {
                    test_btn.val('发送失败，重试');
                }
                test_btn.removeAttr("disabled");
            }
        });
    }
    //显示上次发送进度
    progressBar(<?=$monthly->sent_num?>);
</script>
