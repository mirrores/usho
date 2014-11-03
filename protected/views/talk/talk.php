<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8' />
        <style type="text/css">
            <!--
            .chat_wrapper {
                width: 980px;
                margin-right: auto;
                margin-left: auto;
                background: #CCCCCC;
                border: 1px solid #999999;
                padding: 10px;
                font: 12px 'lucida grande',tahoma,verdana,arial,sans-serif;
            }
            .message_box{
                width: 680px;
                float: left;
            }
            .user_list{
                width: 270px;
                height: 520px;
                background: #FFFFFF;
                border: 1px solid #999999;
                float: left;
                overflow: auto;
            }
            .list li{
                padding: 2px;
            }
            .chat_wrapper .message_box {
                background: #FFFFFF;
                height: 500px;
                overflow: auto;
                padding: 10px;
                border: 1px solid #999999;
            }
            .chat_wrapper .panel input{
                padding: 2px 2px 2px 5px;
                height: 30px;
                margin-top: 5px; 
            }
            #send-btn{
                padding:  5px;
            }
            #tt{
                padding: 5px;
                color: #00a0e9;
            }
            .system_msg{color: #BDBDBD;font-style: italic;}
            .user_name{font-weight:bold;}
            .user_message{color: #88B6E0;}
            -->
        </style>
    </head>
    <body>	
        <?php
        $colours = array('007AFF', 'FF7000', 'FF7000', '15E25F', 'CFC700', 'CFC700', 'CF1100', 'CF00BE', 'F00');
        $user_colour = array_rand($colours);
        ?>
        <script language="javascript" type="text/javascript">
            $(document).ready(function() {
                //create a new WebSocket object.
                var wsUri = "ws://localhost:9000/server.php";
                websocket = new WebSocket(wsUri);

                websocket.onopen = function(ev) { // connection is open 
                    $('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
                }

                $('#send-btn').click(function() { //use clicks message send button	
                    var mymessage = $('#message').val(); //get message text
                    var myname = $('#name').val(); //get user name

                    if (myname == "") { //empty name?
                        alert("Enter your Name please!");
                        return;
                    }
                    if (mymessage == "") { //emtpy message?
                        alert("请输入信息!");
                        return;
                    }

                    //prepare json data
                    var msg = {
                        message: mymessage,
                        name: myname,
                        color: '<?php echo $colours[$user_colour]; ?>'
                    };
                    //convert and send data to server
                    websocket.send(JSON.stringify(msg));
                });
                $('#message').keypress(function(e){
                   if(e.keyCode==13){
                    var mymessage = $('#message').val(); //get message text
                    var myname = $('#name').val(); //get user name

                    if (myname == "") { //empty name?
                        alert("Enter your Name please!");
                        return;
                    }
                    if (mymessage == "") { //emtpy message?
                        alert("请输入信息!");
                        return;
                    }
                       var msg = {
                           message: mymessage,
                           name: myname,
                           color: '<?php echo $colours[$user_colour];?>'
                       };
                       websocket.send(JSON.stringify(msg));
                   }
                });

                //#### Message received from server?
                websocket.onmessage = function(ev) {
                    var msg = JSON.parse(ev.data); //PHP sends Json data
                    var type = msg.type; //message type
                    var umsg = msg.message; //message text
                    var uname = msg.name; //user name
                    var ucolor = msg.color; //color

                    if (type == 'usermsg')
                    {
                        $('#message_box').append("<div><span class=\"user_name\" style=\"color:#" + ucolor + "\">" + uname + "</span> : <span class=\"user_message\">" + umsg + "</span></div>");
                    }
                    if (type == 'system')
                    {
                        $('#message_box').append("<div class=\"system_msg\">" + umsg + "</div>");
                    }

                    $('#message').val(''); //reset text
                };

                websocket.onerror = function(ev) {
                    $('#message_box').append("<div class=\"system_error\">Error Occurred - " + ev.data + "</div>");
                };
                websocket.onclose = function(ev) {
                    $('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");
                };
            });
        </script>
        <div class="chat_wrapper">
            <div class="message_box" id="message_box"></div>
            <div class="user_list" id="user_list">
                <div id="tt"><h1>在线人员:</h1></div>
                <div class="list"></div>

            </div>
            <div class="panel" style="clear:both">
                <?php if (Yii::app()->user->id) { ?>
                    <?php $date = Alumni::model()->findBySql('select a.name from alumni as a left join user as u on u.alumni_id=a.id where u.id=:id', array(':id' => Yii::app()->user->id)) ?>
                    <input type="text" name="name" id="name" readonly="readonly" style="width:20%"  value="<?= $date->name ?>---<?= Yii::app()->user->name; ?>">
                <?php } elseif ($this->userInfo) { ?>
    <?php $date = Alumni::model()->findBySql('select a.name from alumni as a left join user as u on u.alumni_id=a.id where u.id=:id', array(':id' => $this->userInfo->id)) ?>
                    <input type="text" name="name" id="name" readonly="readonly" style="width:20%"  value="<?= $date->name ?>---<?= $this->userInfo->name; ?>">
                <?php } else { ?>
                    <span>
                        <input type="text" name="name" id="message"  style="width:20%"  value="游客">
                    </span>
<?php } ?>
                <input type="text" name="message" id="message" placeholder="Message"  style="width:74%" />
                <button id="send-btn">Send</button>
            </div>
        </div>

    </body>
</html>
<script type="text/javascript">
jQuery(function($) {
    var List = $('.list');
    function updateUser(){
        List.html("Loading...");
        $.ajax({
            url: "<?= $this->createUrl('/talk/data') ?>",
            dataType: 'json',
            cache: false,
            success: function(data) {
                var out = "<ol>";
                $(data).each(function(){
                    out+="<li>"+this.name+"----"+this.user_id+"</li>";
                });
                out += "</ol>";
                List.html(out);
            }
        });
    }
    updateUser();
    setInterval(function(){
        updateUser()
    }, 60000);
});
</script>