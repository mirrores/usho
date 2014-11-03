<!--body-->
<div class="m m_b14"><!---->
    <div class=" fl_left w_1000">
        <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/search_1.jpg" style="display:block;" />
        <div class="member_m">
            <!--right-->
            <div class="member_right">
                <div class="site">位置：会员中心 － <span>我的信息</span></div>
                <div class="body_myinfo">
                    <form action="<?= Yii::app()->createUrl('user')?>" id="user_form" method="POST">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="100" class="r_p25">登陆帐号：</td>
                                <td class="l_p25"><?= $user_info['account']; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">姓名：</td>
                                <td class="t"><?= $user_info['name']; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">学校：</td>
                                <td class="t"><?= $user_info->alumni->name; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">职位：</td>
                                <td class="t"><?= $user_info['position']; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">身份类别：</td>
                                <td class="t"><?= $user_info['role'] ? $user_info['role'] : '学校老师'; ?></td>
                            </tr>
                            <tr>
                                <td class="r_p25">联系地址：</td>
                                <td class="t"><input type="text" name="address" value="<?= $user_info['address']; ?>" class="ipt1" /></td>
                            </tr>
                            <tr>
                                <td class="r_p25">联系电话：</td>
                                <td class="t"><input type="text" name="tel" value="<?= $user_info['tel']; ?>" class="ipt1" /></td>
                            </tr>
                            <tr>
                                <td class="r_p25">手机：</td>
                                <td class="t"><input type="text" name="mobile" value="<?= $user_info['mobile']; ?>" class="ipt1" /></td>
                            </tr>
                            <tr>
                                <td class="r_p25">传真：</td>
                                <td class="t"><input type="text" name="fax" value="<?= $user_info['fax']; ?>" class="ipt1" /></td>
                            </tr>
                            <tr>
                                <td class="r_p25">QQ：</td>
                                <td class="t"><input type="text" name="qq" value="<?= $user_info['qq']; ?>" class="ipt1" /></td>
                            </tr>
                        </table>
                        <div class="my_info_post"><a href="javascript:void(0);" onclick="$('#user_form').submit();">保存</a></div>
                    </form>
                </div>
            </div>
            <!--left-->
            <div class="member_left">
                <img src="<?= Yii::app()->request->baseUrl; ?>/static/images/member_1.jpg" />
                <div class="bg">
                    <ul>
                        <li><a href="<?= Yii::app()->createUrl('user')?>" class="ico_11 on">我的信息<i></i></a></li><!--on 选中样式-->
                        <li><a href="<?= Yii::app()->createUrl('user/mark')?>" class="ico_12">我的关注</a></li>
                        <li><a href="<?= Yii::app()->createUrl('user/message')?>" class="ico_13">我的留言</a></li>
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
