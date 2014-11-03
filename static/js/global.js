// JavaScript Document

//usho introduce
$(document).ready(function() {
    $('.uo').mouseover(function() {
        $('.uo').removeClass('on');
        $('.uo').addClass('out');
        $(this).addClass('on');
        $(this).removeClass('out');
    });

    $('.um1').mouseover(function() {
        $('.umc').addClass('display_none');
        $('#um1_content').removeClass('display_none');
    });
    $('.um2').mouseover(function() {
        $('.umc').addClass('display_none');
        $('#um2_content').removeClass('display_none');
    });
    $('.um3').mouseover(function() {
        $('.umc').addClass('display_none');
        $('#um3_content').removeClass('display_none');
    });
    $('.um4').mouseover(function() {
        $('.umc').addClass('display_none');
        $('#um4_content').removeClass('display_none');
    });


    $('#comment').keyup(function() {
        if ($('#comment').val() == '') {
            $('#put_comment').css('display', 'none');
            $('#gray_submit').css('display', '');
        } else {
            $('#gray_submit').css('display', 'none');
            $('#put_comment').css('display', '');
        }
    })
});
//ajax登陆
function ajaxLoginForm(src) {
    $.layer({
        type: 2,
        title: '登陆帐号',
        area: ['500px', '300px'],
        offset: ['200px', ''],
        closeBtn: [1, true],
        iframe: {src: src},
        end: function() {
            location.reload();
        }
    });
}

function quote_comment(id, is_guster, src) {
    if (is_guster) {
        $('#login_button').click(function() {
            ajaxLoginForm(src);
        })
    } else {
        var floor = $('#' + id + 'floor').text();
        var name = $('#' + id + 'name').text();
        var time = $('#' + id + 'time').text();
        var quote_comment = $('#' + id + 'quote_comment').html();
        var comment = $('#' + id + 'content').html();

        var quote = '引用了' + floor + name + time + '发布的评论  <a style="float:right;" href="javascript:void(0);" onclick="cancel_quote();">删除引用</a>';
        if (quote_comment) {
            quote_comment = '<div style="border: 1px solid #CECE7E;background: #FCFCF2;font-size: 12px;padding: 4px;margin-bottom: 4px;">' + quote_comment + '<span class="floor">' + floor + '</span><span class="name">' + name + '</span><span class="time">' + time + '</span><div class="content">' + comment + '</div></div>';
        } else {
            quote_comment = '<div style="border: 1px solid #CECE7E;background: #FCFCF2;font-size: 12px;padding: 4px;margin-bottom: 4px;"><span class="floor">' + floor + '</span><span class="name">' + name + '</span><span class="time">' + time + '</span><div class="content">' + comment + '</div></div>';
        }

        $('#quote').html(quote);
        $('#quote_comment').val(quote_comment);
    }
}

function cancel_quote() {
    $('#quote').html('');
    $('#quote_comment').html('');
}