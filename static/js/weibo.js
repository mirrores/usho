// 2014-06-05 rihong.rao

$(document).ready(function (){
    //
    $(".thumbnail li img").click(function(){
        //$(".zoompic img").hide().attr({ "src": $(this).attr("href"), "title": $("> img", this).attr("title") });
        var obj = $(this).parent().parent().parent().parent().parent().find('.zoompic img');
        obj.attr('src',$(this).attr('src').replace('/square/', '/bmiddle/'));
        $(".thumbnail li.current").removeClass("current");
        $(this).parents("li").addClass("current");
        return false;
    });
    
    
    $('.btn-right').click(function() {
        var $slider = $(this).parent().find('.slider ul');
        var $slider_child_l = $(this).parent().find('.slider ul li').length;
        ///var $slider_width = objmain.next().find('.slider ul li').width();  获取不到，检查
        var $slider_width = 60;
        $slider.width($slider_child_l * $slider_width);
        
        var slider_count = $(this).parent().find('.slider_count').val()*1;
        
        
        
        if ($slider_child_l < 9 || slider_count >= $slider_child_l - 9) {
            return false;
        }
        
        slider_count++;
        $(this).parent().find('.slider_count').val(slider_count);
        $slider.animate({left: '-=' + $slider_width + 'px'}, 'fast');
        
        if (slider_count >= $slider_child_l - 9) {
            $(this).parent().find('.btn-right').css({cursor: 'auto'});
            $(this).parent().find('.btn-right').addClass("dasabled");
        }
        else if (slider_count > 0 && slider_count <= $slider_child_l+1 - 9) {
            $(this).parent().find('.btn-left').css({cursor: 'pointer'});
            $(this).parent().find('.btn-left').removeClass("dasabled");
            $(this).parent().find('.btn-right').css({cursor: 'pointer'});
            $(this).parent().find('.btn-right').removeClass("dasabled");
        }
        else if (slider_count <= 0) {
            $(this).parent().find('.btn-left').css({cursor: 'auto'});
            $(this).parent().find('.btn-left').addClass("dasabled");
        }
        
    });
    
    
    $('.btn-left').click(function() {
        var $slider = $(this).parent().find('.slider ul');
        var $slider_child_l = $(this).parent().find('.slider ul li').length;
        ///var $slider_width = objmain.next().find('.slider ul li').width();  获取不到，检查
        var $slider_width = 60;
        $slider.width($slider_child_l * $slider_width);
        
        var slider_count = $(this).parent().find('.slider_count').val()*1;

        if (slider_count <= 0) {
            return false;
        }

        slider_count--;
        $(this).parent().find('.slider_count').val(slider_count);
        $slider.animate({left: '+=' + $slider_width + 'px'}, 'fast');
        if (slider_count >= $slider_child_l - 9) {
            $(this).parent().find('.btn-right').css({cursor: 'auto'});
            $(this).parent().find('.btn-right').addClass("dasabled");
        }
        else if (slider_count > 0 && slider_count <= $slider_child_l - 9) {
            $(this).parent().find('.btn-left').css({cursor: 'pointer'});
            $(this).parent().find('.btn-left').removeClass("dasabled");
            $(this).parent().find('.btn-right').css({cursor: 'pointer'});
            $(this).parent().find('.btn-right').removeClass("dasabled");
        }
        else if (slider_count <= 0) {
            $(this).parent().find('.btn-left').css({cursor: 'auto'});
            $(this).parent().find('.btn-left').addClass("dasabled");
        }
    });

});

function zoom_image(obj,ts) {
    if (obj.hasClass('photoBox')) {
        //morePic(obj);
        obj.next().find('.slider_count').val(0);
        if (obj.next().find('.slider ul li').length < 9) {
            obj.next().find('.btn-right').css({cursor: 'auto'});
            obj.next().find('.btn-right').addClass("dasabled");
        }

        var load = obj.find('.loadingBox');
        load.show();
        var img = obj.next().find('.zoompic img');
        if (img.attr('src') == 'about:blank') {
            // img.attr('src', obj.find('img').attr('src').replace('m.', 'l.'));
            img.attr('src', $(ts).attr('src').replace('/square/', '/bmiddle/'));
            img.load(function() {
                obj.hide();
                obj.next().show();
            });
        } else {
            obj.hide();
            obj.next().show();
        }
    } else {
        // alert($(ts).attr('src'));
        $(ts).attr('src','about:blank');
        $(ts).parent().next().find('.slider ul').css('left','0px');
        obj.hide();
        obj.prev().show();
        obj.prev().find('.loadingBox').hide();
        // $(ts).parent().next().find('.slider ul').width(0);
    }
}