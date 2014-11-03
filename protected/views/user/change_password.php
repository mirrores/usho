<!--body-->
<div class="m m_b14"><!---->
    <div class=" fl_left w_1000">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/search_1.jpg" style="display:block;" />
        <div class="member_m">
            <!--right-->
            <div class="member_right">
                <div class="site">位置：会员中心 － <span>修改密码</span></div>
                <div class="body_myinfo">
                    <form action="<?= Yii::app()->createUrl('user/changepassword') ?>" id="password_form" method="POST">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="100" class="r_p25">登陆帐号：</td>
                                <td class="l_p25"><?= $user_info['account']; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">姓名：</td>
                                <td class="t"><?= Yii::app()->user->name; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">新密码：</td>
                                <td class="t"><input type="password" id="password" name="password" class="ipt1" />&nbsp;&nbsp;&nbsp;&nbsp;<span id="password_prompt">密码长度限制为5-20个字符</span></td>
                            </tr>
                            <tr>
                                <td class="r_p25">确认密码：</td>
                                <td class="t"><input type="password" id="check_password" name="check_password" class="ipt1" />&nbsp;&nbsp;&nbsp;&nbsp;<span id="check_prompt"></span></td>
                            </tr>
                        </table>
                        <div class="my_info_post"><a href="javascript:void(0);" onclick="checkPassword();">保存</a></div>
                    </form>
                    <script type="text/javascript">
                        function checkPassword() {
                            var password = $('#password').val();
                            var check = $('#check_password').val();
                            if (password.length > 20 || password.length < 5) {
                                $('#password').css('border', '1px solid red');
                                $('#password_prompt').html('密码长度错误，限制长度为5-20个字符！');
                                $('#password_prompt').css('color', 'red');
                            } else if (password != check) {
                                $('#check_password').css('border', '1px solid red');
                                $('#check_prompt').html('两次密码输入不同！');
                                $('#check_prompt').css('color', 'red');
                            } else {
                                $('#password_form').submit();
                            }
                            return false;
                        }

                        $(document).ready(function() {
                            $('#password').click(function() {
                                $('#password').css('border', '1px solid rgb(236, 236, 236)');
                                $('#password_prompt').html('密码长度限制为5-20个字符');
                                $('#password_prompt').css('color', '#666');
                            });

                            $('#check_password').click(function() {
                                $('#check_password').css('border', '1px solid rgb(236, 236, 236)');
                                $('#check_prompt').html('');
                            });
                        })
                    </script>
                </div>
            </div>
            <!--left-->
            <div class="member_left">
                <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/member_1.jpg" />
                <div class="bg">
                    <ul>
                        <li><a href="<?= Yii::app()->createUrl('user')?>" class="ico_11 ">我的信息<i></i></a></li><!--on 选中样式-->
                        <li><a href="<?= Yii::app()->createUrl('user/mark')?>" class="ico_12">我的关注</a></li>
                        <li><a href="<?= Yii::app()->createUrl('user/message')?>" class="ico_13">我的留言</a></li>
                        <li><a href="<?= Yii::app()->createUrl('user/changepassword')?>" class="ico_14 on">修改密码</a></li>
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
