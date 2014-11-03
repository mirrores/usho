<script  type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/esl.js"></script>  
<div id="main" style="height:400px"></div>
   <script type="text/javascript">
    // Step:3 conifg ECharts's path, link to echarts.js from current page.
    // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
    require.config({
        paths:{ 
            echarts:'<?= Yii::app()->baseUrl ?>/static/js/echarts',
            'echarts/chart/bar' : '<?= Yii::app()->baseUrl ?>/static/js/echarts-map',
            'echarts/chart/line': '<?= Yii::app()->baseUrl ?>/static/js/echarts-map',
            'echarts/chart/map' : '<?= Yii::app()->baseUrl ?>/static/js/echarts-map'
        }
    });
    
    // Step:4 require echarts and use it in the callback.
    // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径
//    require(
//        [
//            'echarts',
//            'echarts/chart/bar',
//            'echarts/chart/line',
//            'echarts/chart/map'
//        ],
            
         require(
           [
                'echarts',
                'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
            ],
                 function(ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('main'));

                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data: ['热度']
                    },
                    xAxis: [
                        {
                            axisLabel: {rotate:45},
                            type: 'category',
                            data:['1','2','3']
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value'
                          
                        }
                    ],
                    series: [
                        {
                            name: "热度",
                            type: "bar",
                            data: global.graph.data,
                            color: "#99cc99"
                        }
                    ]
                };

                // 为echarts对象加载数据 
                myChart.setOption(option);
            }
    );
            
//        function (ec) {
//            //--- 折柱 ---
//            var myChart = ec.init(document.getElementById('main'));
//            myChart.setOption({
//                tooltip : {
//                    trigger: 'axis'
//                },
//                legend: {
//                    data:['点击量']
//                },
//                toolbox: {
//                    show : true,
//                    feature : {
//                        mark : {show: true},
//                        dataView : {show: true, readOnly: false},
//                        magicType : {show: true, type: ['line', 'bar']},
//                        restore : {show: true},
//                        saveAsImage : {show: true}
//                    }
//                },
//                calculable : true,
//                xAxis : [
//                    {
//                        type : 'category',
//                        data : fetchXname()
//                    }
//                ],
//                yAxis : [
//                    {
//                        type : 'value',
//                        splitArea : {show : true}
//                    }
//                ],
//                series : [
//                    {
//                        name:'点击量',
//                        type:'bar',
//                        data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
//                    },
//                ]
//            });
//               }
//    );
//
//function fetchXname(){ 
//        var arr=new Array(); 
//        $.ajax( 
//        { 
//            url:"<?= $this->createUrl('/monthly/show') ?>", 
//            dataType:"text", 
//            success:function(data) 
//            { 
//            //调用函数获取值，转换成数组模式 
//              var ss=eval(data); 
//              for(var i=0;i<ss.length;i++) 
//              { 
//                arr.push(ss[i].name); 
//              } 
//             } 
//            }); 
//                   
//        return arr; 
//               
//        } 
 </script>
