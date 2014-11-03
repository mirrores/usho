<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jQuery-1.9.1.js"></script>
<div style="width: 484px; height: 30px; line-height: 30px; font-size: 14px; color: #686868; text-align: center; "> 尊敬的<?= isset($user_info->name) ? $user_info->name : ''; ?>老师,感谢您登陆网站.如果您是第一次登陆,初始密码为123456.</div>

<div style="width: 384px; margin-left: 100px; margin-top: 10px;">
    <form action="<?= Yii::app()->createUrl('site/ajaxLogin'); ?>" id="login_form" method="POST">
        <div style="color: #FF6A6A; font-size: 14px; "><?= Yii::app()->user->getFlash('error'); ?></div>
        <table>
            <tbody>
            <input type="hidden" name="uid" value="<?= isset($user_info->id) ? $user_info->id : ''; ?>">
                <tr style="height: 40px; line-height: 40px;">
                    <td style="text-align:right; font-size: 12px; color: #686868;">邮箱&nbsp;&nbsp;</td>
                    <td style="text-align:left"><input type="text" name="account" id="account" value="<?= isset($user_info->account) ? $user_info->account : ''; ?>" style="width:200px; height: 25px; line-height: 16px;"></td>
                </tr>
                <tr style="height: 40px; line-height: 40px;">
                    <td style="text-align:right; font-size: 12px; color: #686868;">密码&nbsp;&nbsp;</td>
                    <td style="text-align:left"><input type="password" name="password" id="password" style="width:200px; height: 25px; line-height: 16px;"></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="rememberme" value="0">
                    </td>
                    <td style="height:30px">
                        <input id="rememberme" type="checkbox" name="rememberMe" value="1">
                        <label for="rememberme" style="font-weight: normal; font-size: 12px;color:#333">下次自动登录</label>                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td height="35" colspan="2">
                        <input type="button" value="登录" id="login_button" style=" background: #005EAC;width:80px;height:27px;font-size:14px; padding: 6px 20px; border-color: #B8D4E8 #114681 #114681 #B8D4E8; border-width: 1px; color: #FFFFFF; cursor: pointer">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#login_button').click(function() {
                if ($('#account').val() == '') {
                    $('#account').css('border', '1px solid red');
                    return false;
                }
                if ($('#password').val() == '') {
                    $('#password').css('border', '1px solid red');
                    return false;
                }
                $('#login_form').submit();
            })
        })
    </script>
</div>