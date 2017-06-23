$(function() {

    var site_url = $("#footer").attr("data-url");
});
function getUrl(strs) {
    var url = $("#footer").attr("data-url") + strs;
    return url
}
function goUrl(url) {
    if (url == -1) {
        history.go(-1)
    } else {
        document.location.href = url
    }
}
function checkInputBlur(obj) {
    var default_words = obj.attr("data-default");
    if (obj.val() == "") {
        obj.val(default_words);
        obj.css({
            "color": "#a9a9a9"
        })
    }
}
function checkInputFocus(obj) {
    var default_words = obj.attr("data-default");
    if (obj.val() == default_words) {
        obj.val("").css({
            "color": "#333333"
        })
    }
}
function blurInputLoginBox(obj) {
    var v = obj.val();
    if (v == "") {
        obj.removeClass("form_input-focus");
        obj.prev("div").removeClass("item_tip_focus")
    } else {
        obj.addClass("form_input-focus");
        obj.prev("div").addClass("item_tip_focus")
    }
}
function focusInputLoginBox(obj) {
    obj.addClass("form_input-focus");
    obj.prev("div").addClass("item_tip_focus")
}



function getLoginError(obj, tip) {
    obj.next(".error").text(tip).show();
}
function getLoginRight(obj) {
    obj.next(".error").hide();
    obj.nextAll(".icon-loginright").css({"display": "inline-block"});
}
function checkEmailPattern(email) {
    var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
    if (!pattern.test(email)) {
        return false;
    }
}
function showSuccessTip(data) {
    $("#msg-box").show();
    $("#msg-box-content").html(data);
    setTimeout("hideMsgBox()", 2000)
}

function focusInputLoginArea(obj) {
    obj.next(".error").hide();
    obj.addClass("form_input-focus");
    obj.prev("div").addClass("item_tip_focus");
    obj.nextAll(".grey").show();
    obj.nextAll(".icon-loginright").hide();
}

function blurInputLoginArea(obj, is_sub) {
    var val = obj.val();
    var minlength = obj.attr("data-minlength");
    var maxlength = obj.attr("data-maxlength");
    var type = obj.attr("data-type");
    var equal = obj.attr("data-equal");
    var time_error = 0;
    if (val == "") {
        obj.removeClass("form_input-focus");
        obj.prev("div").removeClass("item_tip_focus");
        getLoginError(obj, "不能为空");

    } else {
        if (minlength > 0 && val.length < minlength) {
            getLoginError(obj, "长度至少" + minlength + "位");
            time_error++;
        }
        if (maxlength > 0 && val.length > maxlength) {
            getLoginError(obj, "长度最多" + maxlength + "位");
            time_error++;
        }
        if (type == 'email' && checkEmailPattern(val) == false) {
            getLoginError(obj, "邮箱格式不正确");
            time_error++;
        }
        if (equal != undefined && val != $(equal).val()) {
            getLoginError(obj, obj.attr("data-equal-error"));
            time_error++;
        }
        if (time_error == 0 && is_sub != 1) {
            if (type == 'username') {
                $.post(getUrl('Ajax/checkUsername'), {
                    username: val
                }, function(data) {
                    if (data == -1) {
                        getLoginError(obj, '该用户名已被注册');
                    } else {
                        getLoginRight(obj);
                    }
                })
            } else if (type == 'email') {
                $.post(getUrl('Ajax/checkEmail'), {
                    email: val
                }, function(data) {
                    if (data == -1) {
                        getLoginError(obj, '该电子邮箱已被注册');
                    } else {
                        getLoginRight(obj);
                    }
                })
            } else {
                getLoginRight(obj);
            }
        }
        obj.addClass("form_input-focus");
        obj.prev("div").addClass("item_tip_focus");
    }
    obj.nextAll(".grey").hide();  
}

