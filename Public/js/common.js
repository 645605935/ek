/*
 * 处理图片前缀
 * $pre:前缀
 * $path:原图地址
 * return:加上前缀的地址
 */
function imgPrefix($pre,$path){
    if($path!='' && $path !=undefined){
        var s=$path.match(/(.*)[^\/]+\//);
        return s[0]+$pre+$path.replace(s[0],''); 
    }else{
        return '';
    }
    
}
/*
 *信息提示
 *msg 提示信息 (必填)
 *flag [成功][失败](默认调用成功)
 *time 默认 2秒 (0 为一直显示)
 *url 跳转地址
 */
function popMsg(msg,time,flag,url){
    var artTip = art.dialog({
        id: 'Tips',
        zIndex: 99999,
        title: false,
        cancel: false,
        fixed: true,
        lock: true
    });

    flag = (flag || 'success');
    //默认调用成功
    if(flag == 'error') {
        artTip.content('<div class="promptMsg clearfix"><div class="icon error"></div><div class="msg">' + msg + '</div><div class="clear"></div></div><span class="sd sd-br4"></span>');
    } else if(flag == 'success') {
        artTip.content('<div class="promptMsg clearfix"><div class="icon ok"></div><div class="msg">' + msg + '</div><div class="clear"></div></div><span class="sd sd-br4"></span>');
    } else if(flag == 'loading') {  //加载中
        artTip.content('<div class="promptMsg clearfix"><div class="icon loading"></div><div class="msg">' + msg + '</div></div><span class="sd sd-br4"></span>');
    } else if(flag == 'tip') {
        artTip.content('<div class="promptMsg clearfix"><div class="icon tip"></div><div class="msg">' + msg + '</div></div><span class="sd sd-br4"></span>');
    }
    if(url!=0 && url!='' && url!=undefined){
        setTimeout(function(){window.location=url},(time*1000) || 0);
    }else{
        if(time != 0){
            setTimeout(function(){art.dialog.get('Tips').close();},(time*1000) || 1600);
        }
    }
    
}
/**
 * 确认
 * @param   {String}    消息内容
 * @param   {Function}  确定按钮回调函数
 * @param   {Function}  取消按钮回调函数
 */
function popConfirm(content, yes, no) {
    return artDialog({
        id: 'Confirm',
        icon: 'question',
        fixed: true,
        lock: true,
        opacity: .1,
        content: content,
        ok: function (here) {
            return yes.call(this, here);
        },
        cancel: function (here) {
            return no && no.call(this, here);
        }
    });
};
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
//EZ事件
var eEvent = {
    delUrl:'',
    del:function(id){
        if(confirm('确认此记录？'))
        {
            $.ajax({
                url:eEvent.delUrl,
                type:'post',
                data: {'ids':id},
                success:function(data){
                    if(data.status=='1'){
                        popMsg(data.info,2,'success',window.location);
                    }else{
                        popMsg(data.info,2,'error',0);
                    }
                    $("input:checkbox").attr("checked",false);
                },
                dataType:'json',
                contentType: "application/x-www-form-urlencoded; charset=utf-8"
            });
        }
    },
    delAll:function(){
        if(confirm('确认所选记录？'))
        {
            var selectedItems = new Array();
            $("input[name='ids[]']:checked").each(function() {
                if(parseInt($(this).val())>0)
                {
                    selectedItems.push($(this).val());
                }
            });
            if(selectedItems.length<1)
            {
                popMsg('尚未选中记录',2,'error',0);
                return false;
            }
            $.ajax({
                url:eEvent.delUrl,
                type:'post',
                data: {'ids':selectedItems},
                success:function(data){
                    if(data.status=='1'){
                        popMsg(data.info,2,'success',window.location);
                    }else{
                        popMsg(data.info,2,'error',0);
                    }
                    $("input:checkbox").attr("checked",false);
                },
                dataType:'json',
                contentType: "application/x-www-form-urlencoded; charset=utf-8"
            });
        }
    }
};
/** 
 * js截取字符串，中英文都能用 
 * @param str：需要截取的字符串 
 * @param len: 需要截取的长度 
 */  
function cutstr(str,len)  
{  
   var str_length = 0;  
   var str_len = 0;  
      str_cut = new String();  
      str_len = str.length;  
      for(var i = 0;i<str_len;i++)  
     {  
        a = str.charAt(i);  
        str_length++;  
        if(escape(a).length > 4)  
        {  
         //中文字符的长度经编码之后大于4  
         str_length++;  
         }  
         str_cut = str_cut.concat(a);  
         if(str_length>=len)  
         {  
         str_cut = str_cut.concat("...");  
         return str_cut;  
         }  
    }  
    //如果给定字符串小于指定长度，则返回源字符串；  
    if(str_length<len){  
     return  str;  
    }  
} 
//这个是去html的  但是不够完善  img就去不了
function delHtmlTag(str)
{   
    return str.replace(/<[^>]+>/ig,"");//去掉所有的html标记
}
/** 
 * 和PHP一样的in_array
 * @param  {string} stringToSearch  要查的 
 * @param  {array}    arrayToSearch 数组
 * @return {bool}            
 * var a = Array(1,2,3,4,5);
 */
function ez_in_array(stringToSearch, arrayToSearch) {
 for (s = 0; s < arrayToSearch.length; s++) {
  thisEntry = arrayToSearch[s].toString();
  if (thisEntry == stringToSearch) {
   return true;
  }
 }
 return false;
}

/** 
 * 和PHP一样的时间戳格式化函数 
 * @param  {string} format    格式 
 * @param  {int}    timestamp 要格式化的时间 默认为当前时间 
 * @return {string}           格式化的时间字符串 
 */
function ez_date(format, timestamp){  
    var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date()); 
    var pad = function(n, c){ 
        if((n = n + "").length < c){ 
            return new Array(++c - n.length).join("0") + n; 
        } else { 
            return n; 
        } 
    }; 
    var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]; 
    var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"}; 
    var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];  
    var f = { 
        // Day 
        d: function(){return pad(f.j(), 2)}, 
        D: function(){return f.l().substr(0,3)}, 
        j: function(){return jsdate.getDate()}, 
        l: function(){return txt_weekdays[f.w()]}, 
        N: function(){return f.w() + 1}, 
        S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'}, 
        w: function(){return jsdate.getDay()}, 
        z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0}, 
        
        // Week 
        W: function(){ 
            var a = f.z(), b = 364 + f.L() - a; 
            var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1; 
            if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){ 
                return 1; 
            } else{ 
                if(a <= 2 && nd >= 4 && a >= (6 - nd)){ 
                    nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31"); 
                    return date("W", Math.round(nd2.getTime()/1000)); 
                } else{ 
                    return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0); 
                } 
            } 
        }, 
        // Month 
        F: function(){return txt_months[f.n()]}, 
        m: function(){return pad(f.n(), 2)}, 
        M: function(){return f.F().substr(0,3)}, 
        n: function(){return jsdate.getMonth() + 1}, 
        t: function(){ 
            var n; 
            if( (n = jsdate.getMonth() + 1) == 2 ){ 
                return 28 + f.L(); 
            } else{ 
                if( n & 1 && n < 8 || !(n & 1) && n > 7 ){ 
                    return 31; 
                } else{ 
                    return 30; 
                } 
            } 
        }, 
        
        // Year 
        L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0}, 
        //o not supported yet 
        Y: function(){return jsdate.getFullYear()}, 
        y: function(){return (jsdate.getFullYear() + "").slice(2)}, 
        
        // Time 
        a: function(){return jsdate.getHours() > 11 ? "pm" : "am"}, 
        A: function(){return f.a().toUpperCase()}, 
        B: function(){ 
            // peter paul koch: 
            var off = (jsdate.getTimezoneOffset() + 60)*60; 
            var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off; 
            var beat = Math.floor(theSeconds/86.4); 
            if (beat > 1000) beat -= 1000; 
            if (beat < 0) beat += 1000; 
            if ((String(beat)).length == 1) beat = "00"+beat; 
            if ((String(beat)).length == 2) beat = "0"+beat; 
            return beat; 
        }, 
        g: function(){return jsdate.getHours() % 12 || 12}, 
        G: function(){return jsdate.getHours()}, 
        h: function(){return pad(f.g(), 2)}, 
        H: function(){return pad(jsdate.getHours(), 2)}, 
        i: function(){return pad(jsdate.getMinutes(), 2)}, 
        s: function(){return pad(jsdate.getSeconds(), 2)}, 
        //u not supported yet 
        // Timezone 
        //e not supported yet 
        //I not supported yet 
        O: function(){ 
            var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4); 
            if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t; 
            return t; 
        }, 
        P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))}, 
        //T not supported yet 
        //Z not supported yet 
        
        // Full Date/Time 
        c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()}, 
        //r not supported yet 
        U: function(){return Math.round(jsdate.getTime()/1000)} 
    }; 
    //原return format.replace(/[\]?([a-zA-Z])/g, function(t, s){ 
    return format.replace(/\]?([a-zA-Z])/g, function(t, s){ 
        if( t!=s ){ 
            // escaped 
            ret = s; 
        } else if( f[s] ){ 
            // a date function exists 
            ret = f[s](); 
        } else{ 
            // nothing special 
            ret = s; 
        } 
        return ret; 
    }); 
}
/*
* 这是有设定过期时间的使用示例：
* h是指小时，如12小时则是：h12 
* s20是代表20秒 
* d是天数，30天则：d30 
* setCookie("name","hayden","s20");
*/
function getsec(str)
{ 
   var str1=str.substring(1,str.length)*1; 
   var str2=str.substring(0,1); 
   if (str2=="s")
   { 
        return str1*1000; 
   }
   else if (str2=="h")
   { 
       return str1*60*60*1000; 
   }
   else if (str2=="d")
   { 
       return str1*24*60*60*1000; 
   } 
} 

//读取cookies 
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+config.cookie.prefix+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]); 
    else 
        return null; 
} 
//删除cookies 
function delCookie(name) 
{ 
    var exp = new Date(); 
    exp.setTime(exp.getTime() - 1); 
    var cval=getCookie(name); 
    if(cval!=null) 
    document.cookie= config.cookie.prefix+name + "="+cval+";expires="+exp.toGMTString() + ";path="+config.cookie.path+";"; //domain="+config.cookie.domain+";
} 
//写cookies 
function setCookie(name,value,time)
{ 
    var strsec = getsec(time); 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + strsec*1); 
    document.cookie = ""+config.cookie.prefix+name+"="+escape(value)+";expires="+exp.toGMTString()+";path="+config.cookie.path+";";//domain="+config.cookie.domain+";
}
//学校的全选和反选
function SchoolcheckAll(sel)
{
    if(sel.checked)
    {
        $(".sch input[type='checkbox']").attr("checked",true);
    }
    else
    {
        $(".sch input[type='checkbox']").attr("checked",false);
    }
}
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
//获得json长度
function getJsonLength(jsonData){
    var jsonLength = 0;
    for(var item in jsonData){
        jsonLength++;
    }
    return jsonLength;
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
