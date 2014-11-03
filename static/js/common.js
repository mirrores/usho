//常用的前端方法集合

//复选框单选框全选
//selectAll(this, "checklist", "button")
function selectAll(checker, scope, type) {
    if (scope) {
        if (type == 'button') {
            $('#' + scope + ' input').each(function() {
                $(this).attr("checked", true);
            });
        }
        else if (type == 'checkbox') {
            $('#' + scope + ' input').each(function() {
                $(this).attr("checked", checker.checked);
            });
        }
    }
    else {
        if (type == 'button') {
            $('input').each(function() {
                $(this).attr("checked", true)
            });
        }
        else if (type == 'checkbox') {
            $('input').each(function() {
                $(this).attr("checked", checker.checked);
            });
        }
    }
}

//单选框复选框反选
function selectReverse(scope) {
    if (scope) {
        $('#' + scope + ' input').each(function() {
            $(this).attr("checked", !$(this).attr("checked"))
        });
    }
    else {
        $('input').each(function() {
            $(this).attr("checked", !$(this).attr("checked"))
        });
    }
}


//关闭顶部提示框
function closeFlashBox(id, time) {
    var $div = jQuery('#' + id);
    $div.fadeTo(time, 0, function() {
        $div.remove();
    });
}


//判断变量是否定义
function is_defined(obj) {
    if ((typeof obj) != 'undefined' && obj != false) {
        return true;
    } else {
        return false;
    }
}


//ajaxForm表单提交
//form_id:表单id
//opts:传递参数
var ajaxForm = function(form_id, opts) {

    if (!is_defined(form_id)) {
        alert('未指定表单id');
        return false;
    }
    ;
    this.form = $('#' + form_id);
    if (this.form.length < 0) {
        alert('未找到' + form_id + '表单对象！');
        return false;
    }
    ;
    //默认值
    var def = {
        formid: form_id,
        action: false,
        method: 'post',
        dataType: 'json',
        timeout: 10000,
        url: false,
        clearForm: false,
        errorDisplayType: 'formError',
        loading: false,
        btn: false,
        redirect: false,
        callback: false,
        before: false,
        error: false,
        statusTools: false,
        submitButton: 'submit_button',
        textSuccess: '成功发送',
        textSending: '发送中',
        textError: '重试'
    };
    //继承参数
    this.opts = $.extend({}, def, opts);
};
//ajaxSubmit提交前执行
ajaxForm.prototype.before = function() {

    //提交前先执行用户定义的方法
    if (typeof this.opts.before == 'function') {
        this.opts.before();
    }

    if (!this.opts.url) {
        this.opts.url = this.form.attr('action');
    }

    //优先在当前表单寻找提交按钮
    this.opts.btn = this.form.find('#' + this.opts.submitButton);
    if (!this.opts.btn.length) {
        this.opts.btn = $("#aui_buttons").find(".aui_state_highlight");
    }
    if (!this.opts.btn.length) {
        this.opts.btn = $("#" + this.opts.submitButton);
    }

    //状态提示框
    this.opts.statusTools = $('#' + this.opts.formid + 'statusTools');
    if (this.opts.statusTools.length == 0) {
        this.form.after('<div id="' + this.opts.formid + 'statusTools" style="clear:both;margin:5px;padding:5px;"><img src="/demoyii/images/loading.gif"></div>');
        this.opts.statusTools = $('#' + this.opts.formid + 'statusTools');
    }
    else {
        this.opts.statusTools.removeClass('ajaxform_err');
        this.opts.statusTools.html('<img src="/demoyii/images/loading.gif">');
        this.opts.statusTools.fadeIn(200);
    }

    //让提交按钮暂时不可用，并显示发送状态
    if (this.opts.btn.get(0).tagName == 'INPUT') {
        this.opts.btn.attr('disabled', true);
        this.opts.btn.attr('value', this.opts.textSending);
    } else {
        this.opts.btn.attr('disabled', true);
        this.opts.btn.html(this.opts.textSending);
    }
};
//ajax提交表单
ajaxForm.prototype.send = function() {
    this.before();
    this.opts.success = function(data) {
        var is_keerect = false;
        var errorString = false;
        //返回json格式
        if (this.dataType == 'json') {
            if (data.status == 1) {
                is_keerect = true;
            }
            else {
                errorString = data.error;
            }
        }
        //返回html格式
        else if (this.dataType == 'html') {
            if (data.indexOf("err#") >= 0) {
                errorString = data.replace("err#", "");
            }
            else {
                is_keerect = true;
            }
        }
        //返回内容为空
        else {
            is_keerect = true;
        }

        //返回正确内容-----------------------------------------------------
        if (is_keerect) {
            //重置按钮
            if (this.btn.get(0).tagName == 'INPUT') {
                this.btn.attr('value', this.textSuccess);
            }
            else if (this.btn.get(0).tagName == 'BUTTON') {
                this.btn.html(this.textSuccess);
            }
            else {
            }
            //移除消息框
            this.statusTools.html('');
            //成功后调整到某一个页面
            if (this.redirect) {
                window.location.href = this.redirect;
                return false;
            }
            //用户自定义成功后方法
            if (typeof this.callback == 'function') {
                this.callback(data);
            }
        }
        //返回错误信息---------------------------------
        else {
            if (this.btn.get(0).tagName == 'INPUT') {
                this.btn.attr('disabled', false);
                this.btn.attr('value', this.textError);
            }
            else if (this.btn.get(0).tagName == 'BUTTON') {
                this.btn.attr('disabled', false);
                this.btn.html(this.textError);
            }
            else {
            }
            //在表单底部提示错误
            if (this.errorDisplayType == 'formError') {
                this.statusTools.addClass('ajaxform_err');
                this.statusTools.html(errorString);
                this.statusTools.hide();
                this.statusTools.fadeIn(400);
                var statusTools = this.statusTools;
                setTimeout(function() {
                    statusTools.fadeOut(400);
                }, 3000);
            }
            //系统弹出窗口
            else if (this.errorDisplayType == 'alert') {
                this.statusTools.html('');
                alert(errorString);
            }
            //facebox弹出窗
            else if (this.errorDisplayType == 'dialogbox') {
                this.statusTools.html('');
                errorAlert(errorString);
            }
            else {
            }
        }

        //重新激活重试提交
        this.btn.attr('disabled', false);
    };
    //请求错误信息
    this.opts.error = function(xhr) {

        this.statusTools.addClass('ajaxform_err');

        if (xhr.readyState == 4 && xhr.status == 0) {
            this.statusTools.html('很抱歉，请求超时，请重试或与管理员联系!');
        }
        else if (xhr.readyState == 4 && xhr.status == 200) {
            this.statusTools.html('程序出错，请重试或与管理员联系!');
        }
        else if (xhr.readyState == 4 && xhr.status == 404) {
            this.statusTools.html('很抱歉，请求文件不存在!');
        }
        else if (xhr.readyState == 4 && xhr.status == 500) {
            this.statusTools.html('很抱歉，服务器遇到了意料不到的情况，请与管理员联系！');
        }
        else if (xhr.readyState == 0 && xhr.status == 0 && xhr.statusText == 'timeout') {
            this.statusTools.html('很抱歉，内容发送超时，请刷新浏览器或稍后重试！');
        }
        else {
            this.statusTools.html('很抱歉，数据发送失败，可能是程序有问题，请重试或与管理员联系！');
        }
        this.opts.btn.attr('disabled', false);
        this.btn.attr('value', this.textError);

    };
    this.opts.dataType = this.opts.dataType;
    this.form.ajaxSubmit(this.opts);
    return false;
};

