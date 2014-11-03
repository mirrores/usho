<link rel="stylesheet" href="<?=Yii::app()->baseUrl?>/static/websocket/js/style.css" type="text/css" media="all" />
<script type="text/javascript" src="<?=Yii::app()->baseUrl?>/static/websocket/js/jquery.websocket.js"  media="all"></script>
<script type="text/javascript">
//WS_STATIC_URL = 'http://127.0.0.1/usho/static';
WS_HOST = '127.0.0.1';
WS_PORT = 8082;

$(function(){
	var t = $('.message');
	$.wsmessage( 'msg', function( data ){
		t.append( data );
		$('.message').animate( { scrollTop: $('.message')[0].scrollHeight } ,0 );
	});
	
	$.wsmessage( 'chat', function( data ){
		t.append( data );
		$('.message').animate( { scrollTop: $('.message')[0].scrollHeight } ,0 );
	});
	
	$.wsmessage( 'name', function( data ) {
		if ( data ) {
			$('.msg.info.name').remove();
		}
		
	});
	
	$.wsmessage( 'list', function( data ) {
		if ( !data ) {
			return false;
		}
		$.each( data, function( k, v ){
			if ( v[1] ) {
				var w = $( '<li>' + v[0] + '</li>' ).click(function(){
					$('.send .chat').val( '@' + v[0] + ' ' );
				});
				$('.list ul').append( w );
			} else {
				$(".list ul li").each(function(){
					if ( $(this).html() == v[0] ) {
						$(this).remove();
						return false;
					}
				});
			}
		});
		$('.online').html( $('.list ul li').size() );
	});
	$.wsclose(function( data ){
		$(".list ul li").html('');
		$('.online').html( 0 );
		t.append( '<div class="msg info">连接已断开, 6秒后自动重试</div>' );
	});
	
	
	$.wsopen( function( data ) {
		t.append( '<div class="msg info">连接服务器成功</div>' );
        var w = t.append( '<div class="msg info name">您的名称为:\n\
            <?php if(Yii::app()->user->id){?><input type="text" class="name" name="name" id="texts" readonly="readonly" value="<?=  Yii::app()->user->name?>"/>\n\
                <?php }elseif($this->userInfo){ ?><input type="text" class="name" name="name" id="texts" readonly="readonly" value="<?=$this->userInfo->name?>">\n\
                    <?php }else{ ?><input type="text" class="name" name="name" id="texts" readonly="readonly" value="游客">\n\
                        <?php } ?><input type="submit" class="submit" id="btn" name="submit" value="确认" /></div>' );
		w.find('.submit').click(function(){
			$.wssend('name=' + w.find('input.name').val() );
			return false;
		});
	});
	
	
	
	
	$('.send .submit').click(function(){
		if ( $('.send .chat').val() ) {
			
			$.wssend($.param( { chat : $('.send .chat').val() } ) );
			$('.send .chat').val('');
		}
		return false;
	});
	$('.send  .chat').keydown(function (e) {
		if ( ( e.ctrlKey && e.keyCode == 13 ) || ( e.altKey && e.keyCode == 83 ) ) {
			$('.send .submit').click();
			return false;
		}
	})
	
	$('.tool .empty').click(function(){
		t.html('');
	})
});
</script>
</head>
<body>
<div class="content">
	<div class="message"></div>
	<div class="tool">
		<span class="empty">清空记录</span>
	</div>
	<div class="send">
		<textarea class="chat" name="chat"></textarea>
		<p><input type="submit" class="submit" id="btn" name="submit" value="发送" /></p>
	</div>
	<div class="list">
		<h3>在线用户<strong class="online">0</strong></h3>
		<ul>
		</ul>
	</div>
</div>