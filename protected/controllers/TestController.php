<?php

class TestController extends Controller {

    //中分分词测试
    public function actionIndex() {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $text = '上海财经大学云南校友会成立';
        echo $text;
        echo '<br>';
        $so = scws_new();
        $so->set_charset('utf8');
        //忽略标点符号
        $so->set_ignore(true);

        //设定是否将闲散文字自动以二字分词法聚合
        $so->set_duality(true);

        $so->set_multi(0);

        //返回一系列切好的词汇
        $so->send_text($text);
        while ($tmp = $so->get_result()) {
            dump($tmp);
        }
        //关闭释放资源，使用结束后可以手工调用该函数或等系统自动回收
        $so->close();
        exit;
    }

    //mail
    public function actionMail() {
        
       $message = new YiiMailMessage;
        //邮件模板
       $message->view = "bodytest";
        //邮件主题
       $message->subject ='感谢您为中国高校校友会工作所做的贡献！';
        //设置并渲染邮件正文
        $message->setBody(array(), 'text/html');
        //发送给测试人员
       $message->addTo('37294812@qq.com');
       $swiftAttachment = Swift_Attachment::fromPath('./member.xls');
        $message->attach($swiftAttachment);
        //使用163邮局发送
        $message->from = array('ushosales@163.com' => '友笑网络');
        $start = Yii::app()->mail163->send($message);
    }

}
