<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$flashChart = new EOFC2;
$flashChart->begin();
$flashChart->setLegend('x', '新闻', '{color:#1835ff;font-size:30px;}');
$flashChart->setLegend('y', '总数', '{color:#1835ff;font-size:15px;}');

//红色部分是作为options，可设置range, label, colour, grid_colour等属性
//'range'=>array(min,max,step) 设置范围和步进
//'label'为标记文字，若不设置，则按range的范围和步进显示相应数字

$flashChart->axis('x', array('labels' => array('缘定浙大', '清华校友会', '复旦周年校庆',
        '五四青年节', '清华校友名片', '校友总会启动计划', '浙大校友工作交流会', '孟兵被报道',
        'Voice of Alumni', '西安交大校友返校', '济南校友会户外活动', '浙复校友畅游遂昌',
        '政法大学建校62周年校友活动', '南开校友会会长论坛举行')));
$flashChart->axis('y', array('range' => array(0, 30, 1)));
//$dataArray是数组，可以是一维数组，也可以是多维数组
//{n}是读出数组的序号，如上例，读取的将是$dataArray[0],$dataArray[1],$dataArray[2]...
//若定义多维数组，例如：
$dataArray[0]['value'] = 6;
$dataArray[1]['value'] = 17;
$dataArray[2]['value'] = 14;
$dataArray[3]['value'] = 7;
$dataArray[4]['value'] = 16;
$dataArray[5]['value'] = 3;
$dataArray[6]['value'] = 2;
$dataArray[7]['value'] = 1;
$dataArray[8]['value'] = 1;
$dataArray[9]['value'] = 1;
$dataArray[10]['value'] = 1;
$dataArray[11]['value'] = 3;
$dataArray[12]['value'] = 1;
$dataArray[13]['value'] = 5;

//则可以如下来设置参数：
$flashChart->setData($dataArray, '{n}', false, 'dataArray');
$flashChart->setTitle('五月份新闻数量点击');
//第三个参数false是labelPaths，表示鼠标放上时显示的文字，但我按照例子测试line无效，bar有效=
$flashChart->renderData('line_dot', array('colour' => '#009900', 'key' => array('新闻点击次数', '14')), 'dataArray');
$flashChart->render('100%', '500');



//模块
$flashChart->begin();
$flashChart->setLegend('x', '模块', '{color:#1835ff;font-size:30px;}');
$flashChart->setLegend('y', '总数', '{color:#1835ff;font-size:15px;}');
$flashChart->axis('x', array('labels' => array('user/changepassword', 'user/message', 'user/mark', 'news/ajaxLogin', 'about/contact',
        'site/login', 'event/index', 'site/error', 'news/view')));
$flashChart->axis('y', array('range' => array(0, 400, 8)));
$datas[0]['value'] = 4;
$datas[1]['value'] = 5;
$datas[2]['value'] = 2;
$datas[3]['value'] = 3;
$datas[4]['value'] = 1;
$datas[5]['value'] = 3;
$datas[6]['value'] = 168;
$datas[7]['value'] = 187;
$datas[8]['value'] = 329;
$flashChart->setData($datas, '{n}', false, 'datas');
$flashChart->setTitle('话题数量点击');
$flashChart->renderData('line_dot', array('colour' => '#009900', 'key' => array('话题点击次数', '14')), 'datas');
$flashChart->render('100%', '800');

//话题
$flashChart->begin();
$flashChart->setLegend('x', '话题', '{color:#1835ff;font-size:30px;}');
$flashChart->setLegend('y', '总数', '{color:#1835ff;font-size:15px;}');
$flashChart->axis('x', array('labels' => array('校友总会应该成为高校的核心部门', '在友笑网，您想看到什么?', '我国大学校友会现状及其出路分析（推荐文章）')));
$flashChart->axis('y', array('range' => array(0, 100, 2)));
$date[0]['value'] = 36;
$date[1]['value'] = 3;
$date[2]['value'] = 75;
$flashChart->setData($date, '{n}', false, 'date');
$flashChart->setTitle('话题数量点击');
$flashChart->renderData('line_dot', array('colour' => '#009900', 'key' => array('话题点击次数', '14')), 'date');
$flashChart->render('100%', '800');



//活动
$flashChart->begin();
$flashChart->setLegend('x', '活动', '{color:#1835ff;font-size:30px;}');
$flashChart->setLegend('y', '总数', '{color:#1835ff;font-size:15px;}');
$flashChart->axis('x', array('labels' => array('北京航空航天大学2014年全球校友工作会', '2014东华大学 “再见，那些年”毕业舞会', '复旦校友创业俱乐部第六期创业沙龙',
        '南京大学大纽约地区校友年度聚会')));
$flashChart->axis('y', array('range' => array(0, 30, 1)));
$dat[0]['value'] = 1;
$dat[1]['value'] = 12;
$dat[2]['value'] = 4;
$dat[3]['value'] = 2;
$flashChart->setData($dat, '{n}', false, 'dat');
$flashChart->setTitle('活动数量点击');
$flashChart->renderData('line_dot', array('colour' => '#009900', 'key' => array('活动点击次数', '14')), 'dat');
$flashChart->render('100%', '500');
?>
