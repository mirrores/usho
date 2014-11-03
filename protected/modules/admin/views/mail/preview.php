<html>
    <head>
        <title><?= $mail->name ?> 邮件预览</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="/static/js/jQuery-1.9.1.js"></script>
    </head>
    <body>
        <div>
            <?= $body ?>
        </div>

        <div style=" margin: 10px;border:2px dotted #ccc;padding:20px;padding-bottom: 150px;font-size: 12px;">
            <table id="sendtable" style="width:1300px">
                <tr>
                    <td colspan="2">指定发送对象：</td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="object"  id="default_object" value="default"  <?= !$user_id ? 'checked="checked"' : null; ?>/> <label for="default_object"><?= $mail->userList ? $mail->userList->name : '所有订阅用户' ?></label><br />
                        <input type="radio"  name="object" id="custom_object" value="custom"  <?= $user_id ? 'checked="checked"' : null; ?>/> <label for="custom_object">指定单用户ID或邮箱(默认为自己)：</label> <input type="text" id="custom_user_id" value="<?= $user_id ?>"  style="width:400px"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        发送进度：共计<?= $total_count ?>份，已发送<span id="send_progress"></span>；
                    </td>
                </tr>
                <tr>
                    <td >
                        <div style="width: 100%;background: #f8f8f8;padding:2px;border: 1px solid #eee;margin: 10px 0;inset 0 1px 2px rgba(0,0,0,0.1);box-shadow: inset 0 1px 2px rgba(0,0,0,0.1); overflow: hidden">
                            <div style="width: 1%;background: #009933;height:15px;" id="progress_bar"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td >
                        <input type="button" value="确定发送" class="btn btn-green" onclick="send()" id="start_btn" />
                        <input type="button" value="暂停" class="btn btn-green" onclick="power()" id="power_btn"/>
                    </td>
                </tr>

            </table>


        </div>

        <script type="text/javascript">
            var start_btn = $('#start_btn');
            var power_btn = $('#power_btn');
            var send_progress = $('#send_progress');
            var progress_bar = $('#progress_bar');
            var total_user =<?= $total_count ?>;
            var total_send = <?= isset($mail->logsCount) ? $mail->logsCount : 0; ?>;
            var send_start = 'start';
            var custom_user_id = $('#custom_user_id');
            //开关
            function power() {
                if (send_start == 'start') {
                    send_start = 'stop';
                    power_btn.val('继续发送');
                }
                else {
                    send_start = 'start';
                    send();
                    start_btn.removeAttr('disabled').val('正在发送，请稍候...');
                    power_btn.val('暂停');
                }
            }

            //进度控制
            function progressBar() {
                if (arguments[0] == '+1') {
                    total_send += 1;
                }
                var percentage = Math.round((total_send / total_user) * 100);
                console.log(arguments[0]);
                send_progress.html(percentage + '%');
                progress_bar.css('width', percentage + '%');
            }

            //验证数字
            function isNumber(oNum) {
                if (!oNum)
                    return false;
                var strP = /^\d+(\.\d+)?$/;
                if (!strP.test(oNum))
                    return false;
                try {
                    if (parseFloat(oNum) != oNum)
                        return false;
                }
                catch (ex)
                {
                    return false;
                }
                return true;
            }

            //正式发送
            function send() {

                var url = "<?= $this->createUrl('send', array('id' => $mail->id)); ?>";
                var postdata = null;
                var object_val = $("input[name='object']:checked").val();

                if (send_start == 'stop') {
                    start_btn.attr('disabled', 'disabled').val('已暂停');
                    return false;
                }

                if (object_val == 'custom') {
                    postdata = 'user_id=' + $('#custom_user_id').val();
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: postdata,
                    dataType: "text",
                    async: true,
                    beforeSend: function() {
                        start_btn.attr('disabled', 'disabled').val('正在发送，请稍候...');
                    },
                    error: function() {
                        start_btn.attr('disabled', 'disabled').val('发送失败，请检查SMTP配置或发送限额！');
                    },
                    success: function(status) {
                        if (status >= 1) {
                            progressBar('+1');
                            start_btn.val('发送成功，继续发...');
                            setTimeout(function() {
                                send();
                            }, 3000);
                        }
                        else if (status == 'not user') {
                            start_btn.val('指定用户不存在，请重试').removeAttr("disabled");
                            ;
                        }
                        else if (status == 0) {
                            progressBar('+1');
                            start_btn.val('发送失败，继续发送下一个...');
                            setTimeout(function() {
                                send();
                            }, 3000);
                        }
                        else if (status == 'invalid email') {
                            progressBar('+1');
                            start_btn.val('地址错误，继续发送下一个...');
                            setTimeout(function() {
                                send();
                            }, 3000);
                        }
                        else if (status == 'complete') {
                            start_btn.attr('disabled', 'disabled').val('发送完毕').removeAttr("disabled");
                        }
                        else {
                            start_btn.val('系统错误，请检查邮件配置或配额!').removeAttr("disabled");
                        }
                    }
                });
            }
            //显示上次发送进度
            progressBar();
        </script>

    </body>
</html>