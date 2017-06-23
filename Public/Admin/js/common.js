//选中所有复选框
function checkAll(sel)
{
	if(sel.checked)
	{
		$("input:checkbox").attr("checked",true);
	}
	else
	{
		$("input:checkbox").attr("checked",false);
	}
}
//针对选取学校的选中所有复选框
function ScheckAll(sel)
{
    var aid = $('.areaid').val();
    if(sel.checked)
    {
        $(".school"+aid+" input:checkbox").attr("checked",true);
    }
    else
    {
        $(".school"+aid+" input:checkbox").attr("checked",false);
    }
}

//弹出窗口编辑

function popupedit(id,title,parentid,order_number,list_tpl,detail_tpl)

{

	$.openPopupLayer({

	name: "myStaticPopup",

	width: popupwidth,

	height:poputheight,

	target: "myHiddenDiv"

	});

	html	=	$('#myHiddenDiv').html();

	$('#insert_txt').show();

	$('#sel_country_province').hide();

	$("#popup").remove();

	$('#id').val(id);

	$('#title').val(title);

	$('#parentid').val(parentid);

	$('#order_number').val(order_number);

	$('#list_tpl').val(list_tpl);

	$('#detail_tpl').val(detail_tpl);

}

//删除记录

function del(id)

{
	if(confirm('确认此记录？'))

	{

		jQuery.ajax({

			url:delurl,

			type:'post',

			data: {'ids':id},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},
			dataType:'json',
			contentType: "application/x-www-form-urlencoded; charset=utf-8"
		});
	}
}

//删除选中记录

function delall()

{

	if(confirm('确认所选记录？'))

	{

		var selectedItems = new Array();

		$("input[@name='ids[]']:checked").each(function() {

			if(parseInt($(this).val())>0)

			{

				selectedItems.push($(this).val());

			}

		});

		if(selectedItems.length<1)

		{

			alert('尚未选中记录');

			return false;

		}

		jQuery.ajax({

			url:delurl,

			type:'post',

			data: {'ids':selectedItems},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}
//取消屏蔽记录
function noshi(id)
{
    if(confirm('确认取消屏蔽此记录？'))
    {
        jQuery.ajax({

            url:noshield,

            type:'post',

            data: {'ids':id},

            success:function(json){

                alert(json.txt);

                window.location.reload()

                $("input:checkbox").attr("checked",false);

            },

            dataType:'json',

            contentType: "application/x-www-form-urlencoded; charset=utf-8"

        });

    }

}
//取消屏蔽

function noshield()

{

    if(confirm('确认取消屏蔽所选记录？'))

    {

        var selectedItems = new Array();

        $("input[@name='ids[]']:checked").each(function() {

            if(parseInt($(this).val())>0)

            {

                selectedItems.push($(this).val());

            }

        });

        if(selectedItems.length<1)

        {

            alert('尚未选中记录');

            return false;

        }

        jQuery.ajax({

            url:noshield,

            type:'post',

            data: {'ids':selectedItems},

            success:function(json){

                alert(json.txt);

                window.location.reload()

                $("input:checkbox").attr("checked",false);

            },

            dataType:'json',

            contentType: "application/x-www-form-urlencoded; charset=utf-8"

        });

    }

}

function yanZheng(id)

{

	if(confirm('确认验证所选订单吗？'))

	{

		jQuery.ajax({

			url:yanzhengUrl,

			type:'post',

			data: {'id':id},

			success:function(json){

				if(json.status==1){

					alert(json.info);

					window.location.reload()

				}else{

					alert(json.info);

				}

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//--------------------------------------------微采集屏蔽-------------------------------------------------//

//屏蔽记录

function ban(id)

{

	if(confirm('确认屏蔽此记录？'))

	{

		$.ajax({

			url:banurl,

			type:'post',

			data: {'ids':id},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//屏蔽记录

function nearbyBan(id)

{

	if(confirm('确认屏蔽此记录？'))

	{

		$.ajax({

			url:'?s=/Admin/NearbyStatuses/ban',

			type:'post',

			data: {'ids':id},

			success:function(json){

				if(json.status==1){

					$("#ns_"+id).fadeOut(2000);	

				}else{

					alert('屏蔽失败');

				}

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//屏蔽选中记录

function banAll()

{

	if(confirm('确认屏蔽所选记录？'))

	{

		var selectedItems = new Array();

		$("input[@name='ids[]']:checked").each(function() {

			if(parseInt($(this).val())>0)

			{

				selectedItems.push($(this).val());

			}

		});

		if(selectedItems.length<1)

		{

			alert('尚未选中记录');

			return false;

		}

		jQuery.ajax({

			url:banurl,

			type:'post',

			data: {'ids':selectedItems},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//--------------------------------------------/微采集屏蔽-------------------------------------------------//



//--------------------------------------------微采集摘录-------------------------------------------------//

//摘录记录

function pass(id)

{

	if(confirm('确认摘录此记录？'))

	{

		$.ajax({

			url:passurl,

			type:'post',

			data: {'ids':id},

			success:function(json){

				alert(json.txt);

				//window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//摘录选中记录

function passAll()

{

	if(confirm('确认摘录所选记录？'))

	{

		var selectedItems = new Array();

		$("input[@name='ids[]']:checked").each(function() {

			if(parseInt($(this).val())>0)

			{

				selectedItems.push($(this).val());

			}

		});

		if(selectedItems.length<1)

		{

			alert('尚未选中记录');

			return false;

		}

		jQuery.ajax({

			url:passurl,

			type:'post',

			data: {'ids':selectedItems},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//--------------------------------------------/微采集摘录-------------------------------------------------//

//--------------------------------------------用户禁言-------------------------------------------------//

//摘录记录

function gag(id)

{

	if(confirm('确认禁言此用户吗？'))

	{

		$.ajax({

			url:gagurl,

			type:'post',

			data: {'ids':id},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//摘录选中记录

function gagAll()

{

	if(confirm('确认禁言所选用户吗？'))

	{

		var selectedItems = new Array();

		$("input[@name='ids[]']:checked").each(function() {

			if(parseInt($(this).val())>0)

			{

				selectedItems.push($(this).val());

			}

		});

		if(selectedItems.length<1)

		{

			alert('请选择用户');

			return false;

		}

		jQuery.ajax({

			url:gagurl,

			type:'post',

			data: {'ids':selectedItems},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//--------------------------------------------/用户禁言-------------------------------------------------//

//--------------------------------------------用户解除禁言-------------------------------------------------//

//摘录记录

function relieve(id)

{

	if(confirm('确认？'))

	{

		$.ajax({

			url:relieveurl,

			type:'post',

			data: {'ids':id},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//摘录选中记录

function relieveAll()

{

	if(confirm('确认？'))

	{

		var selectedItems = new Array();

		$("input[@name='ids[]']:checked").each(function() {

			if(parseInt($(this).val())>0)

			{

				selectedItems.push($(this).val());

			}

		});

		if(selectedItems.length<1)

		{

			alert('请选择用户');

			return false;

		}

		jQuery.ajax({

			url:relieveurl,

			type:'post',

			data: {'ids':selectedItems},

			success:function(json){

				alert(json.txt);

				window.location.reload()

				$("input:checkbox").attr("checked",false);

			},

			dataType:'json',

			contentType: "application/x-www-form-urlencoded; charset=utf-8"

		});

	}

}

//--------------------------------------------/用户禁言-------------------------------------------------//

//保存记录

function popupsave()

{

	var id=$('#id').val();

	var title=$.trim($("#title").val());

	var parentid=$("#parentid").val();

	var order_number=$("#order_number").val();

	var list_tpl=$("#list_tpl").val();

	var detail_tpl=$("#detail_tpl").val();

	if(title=='')

	{

		alert('请填写名称！');

		$('#title').focus();

		$('#title').val('');

		return false;

	}

	var url=addurl;

	if(parseInt(id)>0)

	{

		url=editurl;

	}

	jQuery.ajax({

		url:url,

		type:'post',

		data: 'title='+title+'&parentid='+parentid+'&id='+id+'&order_number='+order_number+'&list_tpl='+list_tpl+'&detail_tpl='+detail_tpl,

		success:function(json){

			$("#title").val('');

			if(parseInt(id)>0)

			{

				$('#txt').html(title+'编辑成功');

				popupcancel();

			}

			else

			{

				$('#txt').html(title+'添加成功');

				$('#title').focus();

				$('#title').val('');

			}

			$("input:checkbox").attr("checked",false);

		},

		dataType:'json',

		contentType: "application/x-www-form-urlencoded; charset=utf-8"

	});

};
// 做插件时加
//dom加载完成后执行的js
$(function(){

	//全选的实现
	$(".check-all").click(function(){
		$(".ids").prop("checked", this.checked);
	});
	$(".ids").click(function(){
		var option = $(".ids");
		option.each(function(i){
			if(!this.checked){
				$(".check-all").prop("checked", false);
				return false;
			}else{
				$(".check-all").prop("checked", true);
			}
		});
	});

    //ajax get请求
    $('.ajax-get').click(function(){
        var target;
        var that = this;
        if ( $(this).hasClass('confirm') ) {
            if(!confirm('确认要执行该操作吗?')){
                return false;
            }
        }
        if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
            $.get(target).success(function(data){
                if (data.status==1) {
                    if (data.url) {
                        updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
                    }else{
                        updateAlert(data.info,'alert-success');
                    }
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
                            $('#top-alert').find('button').click();
                        }else{
                            location.reload();
                        }
                    },1500);
                }else{
                    updateAlert(data.info);
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else{
                            $('#top-alert').find('button').click();
                        }
                    },1500);
                }
            });

        }
        return false;
    });

    //ajax post submit请求
    $('.ajax-post').click(function(){
        var target,query,form;
        var target_form = $(this).attr('target-form');
        var that = this;
        var nead_confirm=false;
        if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
            form = $('.'+target_form);

            if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
            	form = $('.hide-data');
            	query = form.serialize();
            }else if (form.get(0)==undefined){
            	return false;
            }else if ( form.get(0).nodeName=='FORM' ){
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                if($(this).attr('url') !== undefined){
                	target = $(this).attr('url');
                }else{
                	target = form.get(0).action;
                }
                query = form.serialize();
            }else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
                form.each(function(k,v){
                    if(v.type=='checkbox' && v.checked==true){
                        nead_confirm = true;
                    }
                })
                if ( nead_confirm && $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.serialize();
            }else{
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.find('input,select,textarea').serialize();
            }
            $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
            $.post(target,query).success(function(data){
                if (data.status==1) {
                    if (data.url) {
                        updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
                    }else{
                        updateAlert(data.info ,'alert-success');
                    }
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
                            $('#top-alert').find('button').click();
                            $(that).removeClass('disabled').prop('disabled',false);
                        }else{
                            location.reload();
                        }
                    },1500);
                }else{
                    updateAlert(data.info);
                    setTimeout(function(){
                        if (data.url) {
                            location.href=data.url;
                        }else{
                            $('#top-alert').find('button').click();
                            $(that).removeClass('disabled').prop('disabled',false);
                        }
                    },1500);
                }
            });
        }
        return false;
    });

	/**顶部警告栏*/
	var content = $('#main');
	var top_alert = $('#top-alert');
	top_alert.find('.close').on('click', function () {
		top_alert.removeClass('block').slideUp(200);
		// content.animate({paddingTop:'-=55'},200);
	});

    window.updateAlert = function (text,c) {
		text = text||'default';
		c = c||false;
		if ( text!='default' ) {
            top_alert.find('.alert-content').text(text);
			if (top_alert.hasClass('block')) {
			} else {
				top_alert.addClass('block').slideDown(200);
				// content.animate({paddingTop:'+=55'},200);
			}
		} else {
			if (top_alert.hasClass('block')) {
				top_alert.removeClass('block').slideUp(200);
				// content.animate({paddingTop:'-=55'},200);
			}
		}
		if ( c!=false ) {
            top_alert.removeClass('alert-error alert-warn alert-info alert-success').addClass(c);
		}
	};

    //按钮组
    (function(){
        //按钮组(鼠标悬浮显示)
        $(".btn-group").mouseenter(function(){
            var userMenu = $(this).children(".dropdown ");
            var icon = $(this).find(".btn i");
            icon.addClass("btn-arrowup").removeClass("btn-arrowdown");
            userMenu.show();
            clearTimeout(userMenu.data("timeout"));
        }).mouseleave(function(){
            var userMenu = $(this).children(".dropdown");
            var icon = $(this).find(".btn i");
            icon.removeClass("btn-arrowup").addClass("btn-arrowdown");
            userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
            userMenu.data("timeout", setTimeout(function(){userMenu.hide()}, 100));
        });

        //按钮组(鼠标点击显示)
        // $(".btn-group-click .btn").click(function(){
        //     var userMenu = $(this).next(".dropdown ");
        //     var icon = $(this).find("i");
        //     icon.toggleClass("btn-arrowup");
        //     userMenu.toggleClass("block");
        // });
        $(".btn-group-click .btn").click(function(e){
            if ($(this).next(".dropdown").is(":hidden")) {
                $(this).next(".dropdown").show();
                $(this).find("i").addClass("btn-arrowup");
                e.stopPropagation();
            }else{
                $(this).find("i").removeClass("btn-arrowup");
            }
        })
        $(".dropdown").click(function(e) {
            e.stopPropagation();
        });
        $(document).click(function() {
            $(".dropdown").hide();
            $(".btn-group-click .btn").find("i").removeClass("btn-arrowup");
        });
    })();

    // 独立域表单获取焦点样式
    $(".text").focus(function(){
        $(this).addClass("focus");
    }).blur(function(){
        $(this).removeClass('focus');
    });
    $("textarea").focus(function(){
        $(this).closest(".textarea").addClass("focus");
    }).blur(function(){
        $(this).closest(".textarea").removeClass("focus");
    });
});

/* 上传图片预览弹出层 */
$(function(){
    $(window).resize(function(){
        var winW = $(window).width();
        var winH = $(window).height();
        $(".upload-img-box").click(function(){
        	//如果没有图片则不显示
        	if($(this).find('img').attr('src') === undefined){
        		return false;
        	}
            // 创建弹出框以及获取弹出图片
            var imgPopup = "<div id=\"uploadPop\" class=\"upload-img-popup\"></div>"
            var imgItem = $(this).find(".upload-pre-item").html();

            //如果弹出层存在，则不能再弹出
            var popupLen = $(".upload-img-popup").length;
            if( popupLen < 1 ) {
                $(imgPopup).appendTo("body");
                $(".upload-img-popup").html(
                    imgItem + "<a class=\"close-pop\" href=\"javascript:;\" title=\"关闭\"></a>"
                );
            }

            // 弹出层定位
            var uploadImg = $("#uploadPop").find("img");
            var popW = uploadImg.width();
            var popH = uploadImg.height();
            var left = (winW -popW)/2;
            var top = (winH - popH)/2 + 50;
            $(".upload-img-popup").css({
                "max-width" : winW * 0.9,
                "left": left,
                "top": top
            });
        });

        // 关闭弹出层
        $("body").on("click", "#uploadPop .close-pop", function(){
            $(this).parent().remove();
        });
    }).resize();

    // 缩放图片
    function resizeImg(node,isSmall){
        if(!isSmall){
            $(node).height($(node).height()*1.2);
        } else {
            $(node).height($(node).height()*0.8);
        }
    }
})

//标签页切换(无下一步)
function showTab() {
    $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();
}

//标签页切换(有下一步)
function nextTab() {
     $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
        showBtn();
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();

    $("#submit-next").click(function(){
        $(".tab-nav li.current").next().click();
        showBtn();
    });
}

// 下一步按钮切换
function showBtn() {
    var lastTabItem = $(".tab-nav li:last");
    if( lastTabItem.hasClass("current") ) {
        $("#submit").removeClass("hidden");
        $("#submit-next").addClass("hidden");
    } else {
        $("#submit").addClass("hidden");
        $("#submit-next").removeClass("hidden");
    }
}
