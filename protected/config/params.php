<?php

//应用程序参数
return array(
    // 网站名称
    'site_name' => '友笑网',
    //首页标题
    'home_title' => '友笑网',
    //网站关键字
    'keywords' => '友笑网，中国高校校友会最新动态及信息展示，交流平台',
    //网站描述
    'description' => '',
    //管理员邮箱
    'admin_email' => 'admin@gmail.com',
    'ueditor' => require(dirname(__FILE__) . '/ueditor.php'),
    //微博使用到的“常量”
    'WB_AKEY' => 467728865,
    'WB_SKEY' => '13fa408bba988fbdf5e8c2ee0074daf5',
    'WB_CALLBACK_URL' => 'http://www.usho.cn/weibo/callback',
    'ACCESS_TOKEN' => '2.00YMM3bF0xdXeV238286b111I_YeaC',
    'USHO_USER_ID' => 5132678714,
    //可选的邮件发送服务器
    //对应config/main.php stmp处设置
    'smtp_sohu' => array(
        'smtp_name' => 'mail',
        'sender' => 'service@mail.usho.cn',
        'from' => array('service@mail.usho.cn' => '友笑网络')
    ),
    'smtp_163' => array(
        'smtp_name' => 'mail163',
        'sender' => 'ushosales@163.com',
        'from' => array('ushosales@163.com' => '友笑网络')
    )
);
