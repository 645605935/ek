/**
* 添加标签的函数
* @param els
* @param tags
* @return
*/
function imgSelectorInit() {
    $('#imgSelectorChoice').delegate('img', 'click', function () {
        var el = $(this);
        if (!el.hasClass('selected'))
            buildSelectedImg(el);
    }).delegate('img', 'mouseenter', function () {
        $(this).addClass('hovered');
    }).delegate('img', 'mouseleave', function () {
        $(this).removeClass('hovered');
    });
}
function ipostSortInit() {
    $('.ipost-list').sortable({
        items: '> .post',
        containment: 'parent',
        appendTo: 'parent',
        tolerance: 'pointer',
        axis: 'y',
        placeholder: 'holder',
        forceHelperSize: true,
        forcePlaceholderSize: true,
        opacity: 0.8,
        cursor: 'ns-resize'
    });
}
function addFile(image) {
    //alert(image.img);return;
    // var _li='<li class="post file" data-post-id="' + image.id + '">'
    //      + '<input type="hidden" value="' + image.img + '" name="pics[image][]">'
    //      + '<input type="hidden" value="' + 0 + '" name="pics[flag][]">'
    //      +'<input type="hidden" value="'+ 0 +'" name="pics[id][]">'
    //     + '<a class="thumb" href="' + $config['upload'] +'/'+ image.img + '" target="_blank" title="点击查看原图，拖动排序" ><img src="'+$config['upload'] +'/'+ image.img +'"/><span class="file-thumb-title">上传成功</span></a>'//this.thumb
    //     + '<dl class="form data">'
    //         + '<dt>标题</dt><dd class="title"><input type="text" class="text" placeholder="无标题请留空" name="pics[title][]" value="' + (image.title || '') + '" /></dd>' //this.title
    //         + '<dt>描述</dt><dd class="description"><textarea name="pics[desc][]">' + (image.desc || '') + '</textarea></dd>'
    //     + '</dl>'
    //     + '<ul class="action">'
    //     +'<input type="hidden" name="tid" value="'+image.tid+'"/>'
    //     + '<li class="delete"><a class="ir">删除</a></li>'
    //     + '<li class="sort"><a class="ir">排序</a></li>'
    //     + '</ul>'
    // + '</li>';



                        var _li ="<li class='post file imgli' data-post-id=''>";
                            _li+="<input type='hidden' value='"+ image.img +"' name='pics[image][]'>";
                            _li+= "<a class='thumb' onclick='javascript:return false;'>";
                            _li+="<img src='"+$config["upload"] +"/"+ image.img +"'/>";
                            _li+="<span class='delimgli'>×</span>";
                            _li+="</a>";      
                            _li+="<dl class='imginfo'>";
                            _li+="<input type='text' class='title' placeholder='标题' name='pics[title][]' value='' />";
                            _li+= "<textarea class='desc' placeholder='我是描述' name='pics[desc][]'></textarea>";
                            _li+= "</dl>";
                            _li+= "</li>";
                                    
                                




























     var el ;
    if($('#fileList').children('li').length==0){
        el = $(_li).appendTo($('#fileList'));
    }else{
        el = $(_li).insertBefore($('#fileList').children('li:first'));
    } 
    return el;
}
function initUpload(el,count,op,url,delurl,swfurl) {
    var c = count - $("li.file").length;
    el.uploadify({
        'swf': swfurl,
        'uploader': url,
        'cancelImage': 'uploadify-cancel.png',
        'buttonClass': 'btn pl_add btn-primary',
        'removeTimeout': 0,
        'fileSizeLimit': '300kb',
        'buttonText': '<i class="icon-plus-sign"></i> 添加图片',
        'formData': op,
        'buttonCursor': 'pointer',
        'fileTypeDesc': '图片格式',
        'fileTypeExts': '*.jpg;*.bmp;*.png; *.jpeg',
        'queueSizeLimit': 100,
        'uploadLimit': c<=0?1:c,
        'onUploadError': function (file, errorCode, errorMsg, errorString, queue) { alert(file.name + "上传失败") },
        'onUploadStart': function (file) {
            $('#file_upload-button').html('<i class="icon-plus-sign"></i> 继续上传');
            if ($("#bsubmit").length == 0) { $('#file_upload-button').parent().append(' <button id="bsubmit" type="submit" class="btn bsub" data-loading-text="提交中...">保存</button>') }
        },
        'onInit': function(instance) {
            if ((count - $("li.file").length) <= 0) {
                var button = $("#file_upload-button");
                button.addClass("disabled").attr("style", "z-index: 999;")
                button.html('上传已达限制...');
            }
        },
        'onUploadSuccess': function (file, data, response) {
            var json = $.parseJSON(data);
            if (!json.img) {
                G.ui.tips.info(json.message || data);
                return;
            }else{
				addFile(json);
			}
        } 

    }); 
    $('#fileList').delegate('.ir', 'click', function (e) {
        var _el = el;
        $.fallr('show', {
            buttons: {
                button1: {
                    text: '确定', danger: true, onclick: function () {
                        var el = $(e.target).closest('li.file');
                        $.post(delurl, {
                            "id": el.data('postId'),     
							"url": el.children().eq(0).val()
                        });
                        el.remove(); 
                        _el.uploadify('settings', 'uploadLimit', ++count);
                        $.fallr('hide');

                    }
                },
                button2: {
                    text: '取消'
                }
            },
            content: '<p>你确定要删除这张图片吗？</p>',
            icon: 'trash'
        });

    })

}

