<?php
// OneThink常量定义
const PINGZI_VERSION    = '1.0';
const PINGZI_ADDON_PATH = './Addons/';
/**
 * 生成唯一的订单号 20110809 111259 2323 12
 * 2011-年日期
 * 08-月份
 * 09-日期
 * 11-小时
 * 12-分
 * 59-秒
 * 2323-微秒
 * 12-随机值
 * @return string
 */
function trade_no() {
    list($usec, $sec) = explode(" ", microtime());
    $usec = substr(str_replace('0.', '', $usec), 0 ,4);
    $str  = rand(10,99);
    return date("YmdHis").round($usec).$str;
}
function articleUrl($id,$url=null,$action=null){
    if(empty($url)){
        return U($action,array('id'=>$id));
    }else{
        return $url;
    }
}
/**
* 通过学校id获得学校名字
* @access public
* @param int $school_id 学校id
* @return string
*/
function getSchoolName($school_id){
    $school=getSchool(1);
    foreach ($school as $key => $value) {
        if($value['id']==$school_id){
            return $value['title'];
        }
    }
}
/**
* 通过学校id获得城市信息
* @access public
* @param int $school_id 学校id
* @return array
*/
function getCityBySchoolId($school_id){
    $school=getSchool(1);
    $city=getDistrict(1);
    foreach ($school as $key => $value) {
        if($value['id']==$school_id){
            $cityid=$value['cityid'];
            break;
        }
    }
    foreach ($city as $key => $value) {
        if($value['id']==$cityid){
            return $value;
        }
    }
}
/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 处理分类跳转地址
 * @param string $action   方法
 * @param $tid 分类id
 * @param $str 
 * @return string
 */
function typeUrl($action,$tid,$str=null){

}
/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
    \Think\Hook::listen($hook,$params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name){
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name){
    $class = get_addon_class($name);
    if(class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    }else {
        return array();
    }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 */
function addons_url($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Addons/execute', $params);
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
function str2arr($str, $glue = ','){
    return explode($glue, $str);
}


/**
 * 是否包含子串
 */

function strexists($string, $find) {
    return !(strpos($string, $find) === FALSE);
}
/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
function arr2str($arr, $glue = ','){
    return implode($glue, $arr);
}

//统计总数
function eCount($result){
    return $result?count($result):0;
}
/////////////////////////////////
/**
 *
 * 把对象转成数组
 * @param $object 要转的对象$object
 */

function objectToArray($object){ 

    $result = array(); 

    $object = is_object($object) ? get_object_vars($object) : $object;

    foreach ($object as $key => $val) { 

        $val = (is_object($val) || is_array($val)) ? objectToArray($val) : $val; 

        $result[$key] = $val; 

    } 

    return $result; 

}

//这个json是数据库读出来的

function jsonToArray($json){

    return objectToArray(json_decode($json));

}

//获得某天前的最后一秒时间戳

function xtime($day){

    $day = intval($day);

    return mktime(23,59,59,date("m"),date("d")-$day,date("y"));

}

//获得当前ip地址  return string

function getIp()

{

    if(!empty($_SERVER["HTTP_CLIENT_IP"])){

      $ip = $_SERVER["HTTP_CLIENT_IP"];

    }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){

      $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];

    }elseif(!empty($_SERVER["REMOTE_ADDR"])){

      $ip = $_SERVER["REMOTE_ADDR"];

    }else{

      $ip = 'error';//无法获取

    }

    return $ip;

}

// 获取时间颜色

function get_color_date($type='Y-m-d H:i:s',$time,$color='red'){

    if($time > xtime(1)){

        return '<font color="'.$color.'">'.date($type,$time).'</font>';

    }else{

        return date($type,$time);

    }

}

//获得树结构

function genTree($items) {

    foreach ($items as $item) {

    $items[$item['id']]=$item;

    $items[$item['pid']]['son'][$item['id']] = &$items[$item['id']];

    }

    return isset($items[0]['son']) ? $items[0]['son'] : array();

    } 

//获得树

function getTreeList($array,$tid='')
    {
        foreach ($array as $key => $value) {
           if(is_array($value[son]))
           {
                $mark='';
                for ($i=1; $i < $value[level]; $i++) {

                    $mark.='&nbsp;&nbsp;';

                }

                if($tid==$value[id]) 
                {
                  $selected="selected=selected";}
                else{
                    $selected='';
                }
                echo '<option value="'.$value[id].'" '.$selected.'>'.$mark.$value[title].'</option>';
                getTreeList($value[son],''.$tid.'');
           }else{

                $mark='';

                for ($i=1; $i < $value[level]; $i++) { 

                    $mark.='&nbsp;&nbsp;';

                }

                if($tid==$value[id]) 

                {

                    $selected="selected=selected";

                }

                else{

                    $selected='';

                }

                echo '<option value="'.$value[id].'" '.$selected.'>'.$mark.$value[title].'</option>';

           }

        }

    }



//根据日期获得某天的开始与结束时间戳 $data格式 比如 Y-m-d

function getTimeByDate($date){

    $time[start]=strtotime($date.' 00:00:00');

    $time[end]=strtotime($date.' 23:59:59');

    return $time;

}

//判断时间戳是否为今天

//参数 $time int 时间戳

function isTodayTime($time){

    $start_end=getTimeByDate(date('Y-m-d',time()));

    if($start_end[start]<=$time && $time<=$start_end[end] ){

        return 1;

    }else{

        return 0;

    }

}

//根据键值和值返回对应的数组

//参数$arr 要取值的数组  $key=>$val

//返回多维数组 array

function seekarr($arr=array(),$key,$val){

    $res = array();

    $str = json_encode($arr);   

    preg_match_all("/\{[^\{]*\"".$key."\"\:\"".$val."\"[^\}]*\}/",$str, $m);

    if($m && $m[0]){

    foreach($m[0] as $val) $res[] = json_decode($val,true);

    }

    return $res;

}
function str_replace_json($search, $replace, $subject){ 
     return json_decode(str_replace($search, $replace,  json_encode($subject))); 
}

/**
 * 创建Tree
 */

 function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
    $tree = array();
    if (is_array($list)) {

        // 创建基于主键的数组引用

        $refer = array();

        foreach ($list as $key => $data) {

            $refer[$data[$pk]] = & $list[$key];

        }

        foreach ($list as $key => $data) {

            // 判断是否存在parent

            $parentId = $data[$pid];

            if ($root == $parentId) {
                $tree[] = & $list[$key];
               
            } else {

                if (isset($refer[$parentId])) {

                    $parent = & $refer[$parentId];

                    $parent[$child][] = & $list[$key];

                }

            }

        }


    }

    return $tree;

 }
/**
 * 返回某个子数组 以树形的结构
 */
 function pid_list_to_tree( $id ,$list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0){
    $list=list_to_tree($list, $pk, $pid, $child, $root);
    foreach ($list as $key => $value) {
        if($value['id']==$id){
            return $value;
        }
    }
 }
 /**
 * pid 获得子数组
 */
function pid_list($list,$pid,$flag='e') {
    static $tree=array();
    if(!isset($tree[$flag])) $tree[$flag]=array();
    foreach($list as $vo) {
        if ($vo['pid'] == $pid) {
            array_push($tree[$flag],$vo);
            pid_list($list,$vo['id']);
        }
    }
    return $tree[$flag];
}
 /**
 * 获得所有分类下的某个父级下的及本身的数组
 */
 function get_list_by_pid($list,$pid){
    $plist=array();
    //父级放第一个
    foreach ($list as $value) {
        if($value['id']==$pid){
            $plist[] = $value;
            break;
        }
    }
    $child = pid_list($list,$pid);
    foreach ($child as $v) {
        array_push($plist,$v);
    }
    return $plist;
 }

 /**
 * 根据学校id获得当前城市下的所有区域
 */
 function getDistrictBySchool($sid){
    return getDistrictByCity(M('School')->where(array('id'=>$sid))->getField('cityid'));
 }
  /**
 * 获得某个城市下的所有区
 */
  function getDistrictByCity($cityid){
    return M('District')->where(array('pid'=>$cityid))->select();
  }


//给图片加前缀
function imgPrefix($prefix,$string){
    list($name,$type)=explode('.',basename($string));
    return dirname($string).'/'.$prefix.$name.".{$type}";
}


//判断是否地址存在 如果不存在用其他的替换
function checkImg($path){
    $c=C('TMPL_PARSE_STRING');
    if(file_exists(STATIC_PATH.$path) && !empty($path)){
        return $c['__UPLOAD__'].'/'.$path;
    }else{

        return $c['__PUBLIC__'].'/Pz/img/wu.jpg';

    }

}

/**
 * 获得地区select option
 */

function areaSelectOption($all,$pid=null,$focus=null){
    foreach($all as $k => $r) {
        $array[$r['id']] = $r;
    }

    $str  = "<option value='\$id' \$selected \$disabled >\$spacer \$title</option>";
    $Tree = new \Common\Extend\Tree();
    $Tree->init($array);
    return $select = $Tree->get_tree_multi(515, $str, $pid);

}
/**

 * 获得select option

 */

function selectOption($all,$pid=null,$focus=null,$root=0,$disabled=array()){
    foreach($all as $k => $r) {
        if($r['level']==$disabled['level']){
            $r['disabled']='disabled=disabled';
            $array[$r['id']] = $r;
        }else{
            $array[$r['id']] = $r;
        }
        

    }

    $str  = "<option value='\$id' \$selected \$disabled ".$disabled['level'].">\$spacer \$title</option>";


    $Tree = new \Common\Extend\Tree();

    $Tree->init($array);

    return $select = $Tree->get_tree_multi($root, $str, $pid);

}

//移动到某个文件夹

//$id是数据库对应的文章id

function copyFileTo($id,$floder)

{

    $path=STATIC_PATH.'/'.filePath2($id,$floder).''; //路径

    if ( !file_exists( $path ) ) {

    if ( mkdir( $path , 0777 , true ) ) {

       //移动临时文件夹里的图片到这里

            $all_file=scandir(STATIC_PATH.'ueditor_temp/');

            if($all_file)

            {

                //复制原文件到

                foreach ($all_file as $value) {

                    copy(STATIC_PATH.'ueditor_temp/'.$value, $path.'/'.$value);

                }

                //删除原文件

                foreach ($all_file as $value) {

                    unlink(STATIC_PATH.'ueditor_temp/'.$value);

                }

                return true;

            }

        }

    }else{

         //移动临时文件夹里的图片到这里

            $all_file=scandir(STATIC_PATH.'ueditor_temp/');

            if($all_file)

            {

                //复制原文件到

                foreach ($all_file as $value) {

                    copy(STATIC_PATH.'ueditor_temp/'.$value, $path.'/'.$value);

                }

                //删除原文件

                foreach ($all_file as $value) {

                    unlink(STATIC_PATH.'ueditor_temp/'.$value);

                }

                return true;

            }

    }

}

/**

 * 删除整个目录

 * @param $dir

 * @return bool

 */

function delDir( $dir )

{

    //先删除目录下的所有文件：

    $dh = opendir( $dir );

    while ( $file = readdir( $dh ) ) {

        if ( $file != "." && $file != ".." ) {

            $fullpath = $dir . "/" . $file;

            if ( !is_dir( $fullpath ) ) {

                unlink( $fullpath );

            } else {

                delDir( $fullpath );

            }

        }

    }

    closedir( $dh );

    //删除当前文件夹：

    return rmdir( $dir );

}

//截取中文字符串方法 

function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)

{

    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";

    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";

    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";

    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

    preg_match_all($re[$charset], $str, $match);

    $str_lenth = count($match[0]);

    if(function_exists("mb_substr"))

{ 

        if($suffix && $str_lenth>$length) 

        return mb_substr($str, $start, $length, $charset)."...";

        else

        return mb_substr($str, $start, $length, $charset);

}

    elseif(function_exists('iconv_substr')) {

  if($suffix && $str_lenth>$length) 

       return iconv_substr($str,$start,$length,$charset)."...";

       else

       return iconv_substr($str,$start,$length,$charset); 

    }    

}

/**

 * 字符截取 支持UTF8/GBK

 * @param $string

 * @param $length

 * @param $dot

 */

function str_cut($string, $length, $dot = '...') {

    $strlen = strlen($string);

    if($strlen <= $length) return $string;

    $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);

    $strcut = '';

    if(strtolower(CHARSET) == 'utf-8') {

        $length = intval($length-strlen($dot)-$length/3);

        $n = $tn = $noc = 0;

        while($n < strlen($string)) {

            $t = ord($string[$n]);

            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {

                $tn = 1; $n++; $noc++;

            } elseif(194 <= $t && $t <= 223) {

                $tn = 2; $n += 2; $noc += 2;

            } elseif(224 <= $t && $t <= 239) {

                $tn = 3; $n += 3; $noc += 2;

            } elseif(240 <= $t && $t <= 247) {

                $tn = 4; $n += 4; $noc += 2;

            } elseif(248 <= $t && $t <= 251) {

                $tn = 5; $n += 5; $noc += 2;

            } elseif($t == 252 || $t == 253) {

                $tn = 6; $n += 6; $noc += 2;

            } else {

                $n++;

            }

            if($noc >= $length) {

                break;

            }

        }

        if($noc > $length) {

            $n -= $tn;

        }

        $strcut = substr($string, 0, $n);

        $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);

    } else {

        $dotlen = strlen($dot);

        $maxi = $length - $dotlen - 1;

        $current_str = '';

        $search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');

        $replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');

        $search_flip = array_flip($search_arr);

        for ($i = 0; $i < $maxi; $i++) {

            $current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];

            if (in_array($current_str, $search_arr)) {

                $key = $search_flip[$current_str];

                $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);

            }

            $strcut .= $current_str;

        }

    }

    return $strcut.$dot;

}



function cleanJs($text){

    $text = trim($text);

    $text = stripslashes($text);

    //完全过滤动态代码

    $text = preg_replace('/<\?|\?'.'>/','',$text);

    //完全过滤js

    $text = preg_replace('/<script?.*\/script>/','',$text);

    //过滤多余html

    $text = preg_replace('/<\/?(html|head|meta|link|base|body|title|style|script|form|iframe|frame|frameset|p|div)[^><]*>/i','',$text);

    //过滤on事件lang js

    while(preg_match('/(<[^><]+)(lang|onfinish|onmouse|onexit|onerror|onclick|onkey|onload|onchange|onfocus|onblur)[^><]+/i',$text,$mat)){

        $text=str_replace($mat[0],$mat[1],$text);

    }

    while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){

        $text=str_replace($mat[0],$mat[1].$mat[3],$text);

    }

    return $text;

} 

//计算文件大小

function format_bytes($size) {    

    $units = array(' B', ' KB', ' MB', ' GB', ' TB');    

    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;    

    return round($size, 2).$units[$i];

}

/**

 * 获得数组格式

 * @param $array (array) 要转换的数组

 * @param $levle (int)   层级

 * @return string

 */

function arrayval($array, $level = 0) {

    $space = '';

    for($i = 0; $i <= $level; $i++) {

        $space .= "\t";

    }

    $evaluate = "Array\n$space(\n";

    $comma = $space;

    foreach($array as $key => $val) {

        $key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;

        $val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12 || substr($val, 0, 1)=='0') ? '\''.addcslashes($val, '\'\\').'\'' : $val;

        if(is_array($val)) {

            $evaluate .= "$comma$key => ".arrayeval_r($val, $level + 1);

            } else {

            $evaluate .= "$comma$key => $val";

        }

            $comma = ",\n$space";

        }

        $evaluate .= "\n$space)";

    return $evaluate;

}

/**

 * 过滤微博表情和超链接

 * @param $text string 微博文字内容

 * @return string

 * @author HanWenbo QQ:9476400

 */

function sina_filter_text($text)

{

    $e=C('SINA_BASE_EMOTIONS');

    if(empty($e)) include_once STATIC_PATH.'emotions/emotions.php';

    return antiWord(eregi_replace('(((f|ht){1}tp://t.cn/)[a-zA-Z0-9]+)','<a href="\1" target="_blank">\1</a>',strtr(eregi_replace('我在.*[a-zA-Z0-9]','',$text),C('SINA_BASE_EMOTIONS'))));

}



//创建文件

function createFolders($path)  {
    //递归创建  

    if (!file_exists($path)){
        createFolders(dirname($path));//取得最后一个文件夹的全路径返回开始的地方  
        mkdir($path, 0777);  
    }  

}



/**

 * 上传函数 

 * @param $files 要上传的文件 如$_FILES['photo']

 * @param $folder 文件夹

 * @param $uptypes 上传类型，数组 array('jpg','png','gif')

 * @return 返回数组：array('name'=>'','path'=>'','url'=>'','path'=>'','size'=>'')

 **/

function eUpload($id,$files,$folder,$uptypes=array('jpg','png','gif','jpeg')){    

    if ($files['size']>0) {

        $path = filePath2($id,$folder);

        $dest_dir=STATIC_PATH.$path;

        createFolders($dest_dir);     //创建文件夹

        $arrType = explode('.',strtolower($files['name'])); //转小写一下 

        $type = array_pop($arrType);      //array_pop() 弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一。 

        if (in_array($type,$uptypes)) {

            $name = time().rand(1000,9999).'.'.$type;

            $dest=$dest_dir.'/'.$name;         

            unlink($dest);

            move_uploaded_file($files['tmp_name'],$dest);

            chmod($dest, 0777);

            $filesize=filesize($dest);

            if(intval($filesize) > 0){

                return array(

                    'name'=>$files['name'],

                    'path'=>$path,

                    'url'=>$path.'/'.$name,

                    'type'=>$type,

                    'size'=>$files['size'],

                );

            }else{

                return false;

            }

        }else{

            return false;

        }

    }

}

//二位数组排序

function multi_array_sort($multi_array,$sort_key,$sort=SORT_DESC)

{ 

    if(is_array($multi_array)){ 

        foreach ($multi_array as $row_array){ 

        if(is_array($row_array)){ 

            $key_array[] = $row_array[$sort_key]; 

            }else{ 

            return false; 

            } 

        } 

        }else{ 

            return false; 

    } 

    array_multisort($key_array,$sort,$multi_array); 

    return $multi_array; 

} 


/*

*垃圾词过滤

*$text  string

*return string

*/

function antiWord($text){

    global $config;

    $patterns=explode('|', $config['badwords']);

    return $result=str_replace($patterns,'**', $text);

}

//根据id生成对应的路径

function filePath($id,$floder){
    $menu2=intval($id/1000);
    $menu1=intval($menu2/1000);
    $path = strtolower($floder).'/'.$menu1.'/'.$menu2.'/'.$id;
    createFolders(STATIC_PATH.$path);
    return $path;
}

/**

 * 将上传文件移动到临时文件的函数 

 * @param $files  文件

 * @param $uptypes 上传类型，数组 array('jpg','png','gif')

 * @return 返回数组：array('name'=>'','path'=>'','url'=>'','path'=>'','size'=>'')

 * @author HanWenbo weibo.com/tiancaili123

 **/

 function filesMoveToTemp($files,$uptypes=array('jpg','png','gif','jpeg')){

    if (!$files['size']>0) return false;

    $path='temp/'.time();

    $dest_dir=STATIC_PATH.$path;

    createFolders($dest_dir);     //创建文件夹

    $arrType = explode('.',strtolower($files['name'])); //转小写一下 

    $type = array_pop($arrType);      //array_pop() 弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一。 

    if (!in_array($type,$uptypes)) return false;

    $name = rand(1000000000,9999999999).'.'.$type;

    $dest=$dest_dir.'/'.$name;         

    if(!move_uploaded_file($files['tmp_name'],$dest)) return false;

    unlink($files);

    chmod($dest, 0777);

    return array(

        'name'=>$files['name'],

        'path'=>$path,

        'url'=>$dest,

        'type'=>$type,

        'size'=>$files['size'],

    );

}

//$id 记录id $filepath 文件绝对路径 $info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高 $original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图

function thumbnail($id,$filepath,$info='thumb_,120,120|bmid_,440,440',$original=1){

   

    $image=new \Common\Extend\Image();

    $file=end(explode('/', $filepath));         //获得文件名

    $type=end(explode('.', $file));         //获得文件类型

    $filename=current(explode('.', $file));

    $path=filePath($id);

    $info_list=explode('|', $info);

    if(!$info_list) return false;

    foreach ($info_list as $v) {

        $pic_info=explode(',', $v);

        $thumbnailPath=$path.'/'.$pic_info[0].$filename.'.jpg';

        if( $image->thumb( $filepath ,  STATIC_PATH.$thumbnailPath ,$type, $pic_info[1], $pic_info[2])){

            $data[$pic_info[0]]=$thumbnailPath;

        }

    }

    if($original){

        rename($filepath, STATIC_PATH.$path.'/'.$file);

        $data['origin_']=$path.'/'.$file;

    }

    return $data;

}

//$id 记录id $filepath 文件绝对路径 $info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高 $original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图

function thumbnail2($id,$filepath,$floder,$info='thumb_,120,120|bmid_,440,440',$original=1){

   

    $image=new \Common\Extend\Image();

    $file=end(explode('/', $filepath));         //获得文件名

    $type=end(explode('.', $file));         //获得文件类型

    $filename=current(explode('.', $file));

    $path=filePath2($id,$floder);

    $info_list=explode('|', $info);

    if(!$info_list) return false;

    foreach ($info_list as $v) {

        $pic_info=explode(',', $v);

        $thumbnailPath=$path.'/'.$pic_info[0].$filename.'.jpg';

        if( $image->thumb( $filepath ,  STATIC_PATH.$thumbnailPath ,$type, $pic_info[1], $pic_info[2])){

            $data[$pic_info[0]]=$thumbnailPath;

        }

    }

    if($original){

        rename($filepath, STATIC_PATH.$path.'/'.$file);

        $data['origin_']=$path.'/'.$file;

    }

    return $data;

}
//$id 记录id $filepath 文件绝对路径 $info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高 $original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图
function thumbnailZ($id,$filepath,$floder,$info='thumb_,120,120|bmid_,440,440',$original=1){
   
    $image=new \Common\Extend\Image();
    $file=end(explode('/', $filepath));         //获得文件名
    $type=end(explode('.', $file));         //获得文件类型
    $filename=current(explode('.', $file));
    $path=filePath2($id,$floder);
    $info_list=explode('|', $info);
    if(!$info_list) return false;
    foreach ($info_list as $v) {
        $pic_info=explode(',', $v);
        $thumbnailPath=$path.'/'.$pic_info[0].$filename.'.jpg';
        if( $image->thumb2( $filepath ,  STATIC_PATH.$thumbnailPath ,$type, $pic_info[1], $pic_info[2])){
            $data[$pic_info[0]]=$thumbnailPath;
        }
    }
    if($original){
        rename($filepath, STATIC_PATH.$path.'/'.$file);
        $data['origin_']=$path.'/'.$file;
    }
    return $data;
}

function echoJson($data){

    echo json_encode($data);

    exit;

}

/**
* 使用正则验证数据
* @access public
* @param string $value  要验证的数据

* @param string $rule 验证规则

* @return boolean

*/

function regex($value,$rule) {

    $validate = array(

        'phone'     =>  '/^((\(\d{3}\))|(\d{3}\-))?1\d{10}$/',

        'require'   =>  '/\S+/',

        'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',

        'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',

        'currency'  =>  '/^\d+(\.\d+)?$/',

        'number'    =>  '/^\d+$/',
        
        'id'        =>  '/^[0-9]+$/',

        'zip'       =>  '/^\d{6}$/',

        'integer'   =>  '/^[-\+]?\d+$/',

        'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',

        'english'   =>  '/^[A-Za-z]+$/',

        'special'  =>  '/[\'.,:;*?~`!@#$%^&+=)(<{}]|\]|\[|\/|\\\|\"|\|/',//是否有特殊字符

    );

    // 检查是否有内置的正则表达式

    if(isset($validate[strtolower($rule)]))

        $rule       =   $validate[strtolower($rule)];

    return preg_match($rule,$value)===1;

}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 */

function ez_encrypt($data, $key = '', $expire = 0) {

    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);

    $data = base64_encode($data);

    $x    = 0;

    $len  = strlen($data);

    $l    = strlen($key);

    $char = '';



    for ($i = 0; $i < $len; $i++) {

        if ($x == $l) $x = 0;

        $char .= substr($key, $x, 1);

        $x++;

    }



    $str = sprintf('%010d', $expire ? $expire + time():0);



    for ($i = 0; $i < $len; $i++) {

        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);

    }

    return str_replace('=', '',base64_encode($str));

}

/**

 * 系统解密方法

 * @param  string $data 要解密的字符串 （必须是ez_encrypt方法加密的字符串）

 * @param  string $key  加密密钥

 * @return string

 */

function ez_decrypt($data, $key = ''){

    $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);

    $x      = 0;

    $data   = base64_decode($data);

    $expire = substr($data,0,10);

    $data   = substr($data,10);



    if($expire > 0 && $expire < time()) {

        return '';

    }



    $len  = strlen($data);

    $l    = strlen($key);

    $char = $str = '';



    for ($i = 0; $i < $len; $i++) {

        if ($x == $l) $x = 0;

        $char .= substr($key, $x, 1);

        $x++;

    }



    for ($i = 0; $i < $len; $i++) {

        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {

            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));

        }else{

            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));

        }

    }

    return base64_decode($str);

}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */

function is_login(){

    $user = session('vip_user');

    if (empty($user)) {

        return 0;

    } else {

        return session('user_auth_sign') == data_auth_sign($user) ? $user['id'] : 0;

    }

}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */

function data_auth_sign($data){
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识
 * @param string $model 触发行为的表名（不加表前缀）
 * @param int $rid 触发行为的记录id
 * @param int $uid 执行行为的用户id
 * @return boolean
 */

function action_log($action = null, $model = null, $rid = null, $uid = null){



    //参数检查

    if(empty($action) || empty($model) || empty($rid)){

        return '参数不能为空';

    }

    if(empty($uid)){

        $uid = is_login();

    }


    //查询行为,判断是否执行

    $action_info = M('Action')->getByName($action);

    if($action_info['status'] != 1){

        return '该行为被禁用';

    }
    //插入行为日志

    $data['aid'] = $action_info['id'];

    $data['uid'] = $uid;

    $data['action_ip'] = ip2long(get_client_ip());

    $data['model'] = $model;

    $data['rid'] = $rid;

    $data['time'] = NOW_TIME;

    M('ActionLog')->add($data);
    //解析行为
    $rules = parse_action($action, $uid);

    //执行行为
    //$over是否超过 0为未超过  1为超过
    $over = execute_action($rules, $action_info['id'], $uid);
    $result['over']=$over;
    $result['rules']=$rules[0];
    return $result;
}

/**

 * 解析行为规则

 * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]

 * 规则字段解释：table->要操作的数据表，不需要加表前缀；

 *              field->要操作的字段；

 *              condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户

 *              rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3

 *              cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次

 *              max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）

 * 单个行为后可加 ； 连接其他规则

 * @param string $action 行为id或者name

 * @param int $self 替换规则里的变量为执行用户的id

 * @return boolean|array: false解析出错 ， 成功返回规则数组

 */

function parse_action($action = null, $self){

    if(empty($action)){

        return false;

    }

    //参数支持id或者name

    if(is_numeric($action)){

        $map = array('id'=>$action);

    }else{

        $map = array('name'=>$action);

    }

    //查询行为信息

    $info = M('Action')->where($map)->find();

    if(!$info || $info['status'] != 1){

        return false;

    }

    //解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]

    $rules = $info['rule'];

    $rules = str_replace('{$self}', $self, $rules);

    $rules = explode(';', $rules);

    $return = array();

    foreach ($rules as $key=>&$rule){

        $rule = explode('|', $rule);

        foreach ($rule as $k=>$fields){

            $field = empty($fields) ? array() : explode(':', $fields);

            if(!empty($field)){

                $return[$key][$field[0]] = $field[1];

            }

        }

        //cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件

        if(!array_key_exists('cycle', $return[$key]) || !array_key_exists('max', $return[$key])){

            unset($return[$key]['cycle']);

            unset($return[$key]['max']);

        }

    }
    return $return;

}



/**

 * 执行行为

 * @param array $rules 解析后的规则数组

 * @param int $aid 行为id

 * @param array $uid 执行的用户id

 * @return boolean false 失败 ， true 成功

 */

function execute_action($rules = false, $aid = null, $uid = null){

    if(!$rules || empty($aid) || empty($uid)){

        return false;

    }

    $return = true;
    $over=0;
    foreach ($rules as $rule){

        //检查执行周期

        $map = array('aid'=>$aid, 'uid'=>$uid);

        $map['time'] = array('gt', NOW_TIME - intval($rule['cycle']) * 3600);

        $exec_count = M('ActionLog')->where($map)->count();

        if($exec_count > $rule['max']){
            $over=1;
            continue;
        }

        //执行数据库操作

        $Model = M(ucfirst($rule['table']));

        $field = $rule['field'];

        $res = $Model->where($rule['condition'])->setField($field, array('exp', $rule['rule']));

        if(!$res){

            $return = false;

        }

    }

    return $over;

}

/**
 * 设置跳转页面URL
 * 使用函数再次封装，方便以后选择不同的存储方式（目前使用cookie存储）
 */

function set_redirect_url($url){

    cookie('redirect_url', $url);

}

/**
 * 获取跳转页面URL
 * @return string 跳转页URL
 */

function get_redirect_url(){

    $url = cookie('redirect_url');

    return empty($url) ? __APP__ : $url;

}
//$id 记录id $filepath 文件绝对路径 $info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高 $original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图
function single($id,$filepath,$floder,$aid,$info='thumb_,120,120|bmid_,440,440',$original=1){
    $image=new \Common\Extend\Image();

    $file=end(explode('/', $filepath));         //获得文件名

    $type=end(explode('.', $file));         //获得文件类型

    $filename=current(explode('.', $file));
    $path=filePath2($id,$floder,$aid);
    $info_list=explode('|', $info);
    if(!$info_list) return false;
    foreach ($info_list as $v) {
        $pic_info=explode(',', $v);

        $thumbnailPath=$path.'/'.$pic_info[0].$filename.'.'.$type;
        if( $image->thumb( $filepath ,  STATIC_PATH.$thumbnailPath ,$type, $pic_info[1], $pic_info[2])){
            $data[$pic_info[0]]=$thumbnailPath;
        }
    }
    if($original){
        rename($filepath, STATIC_PATH.$path.'/'.$file);
        $data['origin_']=$path.'/'.$file;
    }
    return $data;

}

//根据用户id和帐号id生成路径

function filePath2($uid,$floder,$aid){

    $menu2=intval($uid/1000);

    $menu1=intval($menu2/1000);
    if($aid)$aid ='/'.$aid;
    $path = strtolower($floder).'/'.$menu1.'/'.$menu2.'/'.$uid.$aid;
    createFolders(STATIC_PATH.$path);
    return $path;

}

//上传图片加生成略显图
//$id 记录id $files $_FILES['cover'] 
//$info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高 
//$original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图
function uploadPicThumb($id,$files,$floder,$info='thumb_,120,120|bmid_,440,440',$original=1){
	$file_info=filesMoveToTemp($files,array('jpg','png','gif','jpeg'));
	return thumbnail2($id,$file_info['url'],$floder,$info,$original);
}
//上传图片加生成略显图
//$id 记录id $files $_FILES['cover'] 
//$info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高 
//$original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图
//裁剪成固定的高和宽
function uploadPicThumbZ($id,$files,$floder,$info='thumb_,120,120|bmid_,440,440',$original=1){
	$file_info=filesMoveToTemp($files,array('jpg','png','gif','jpeg'));
	return thumbnailZ($id,$file_info['url'],$floder,$info,$original);
}
//上传一张图片
function uploadPic($id,$files,$floder,$aid,$info='thumb_,120,120|bmid_,440,440',$original=1){
    $file_info=filesMoveToTemp($files,array('jpg','png','gif','jpeg'));
    return single($id,$file_info['url'],$floder,$aid,$info,$original);
}
//基于数组创建目录和文件
function create_dir_or_files($files){
    foreach ($files as $key => $value) {
        if(substr($value, -1) == '/'){
            mkdir($value);
        }else{
            @file_put_contents($value, '');
        }
    }
}
//纠正图片路径
function correctImage($path,$imgPrefix=''){
    $pc= C('PC');
    if(strstr($path,'/Uploads')){
        return $pc['url']."./{$path}";
    }else{
        if(file_exists(STATIC_PATH.$p)){
            if($imgPrefix){
                list($name,$type)=explode('.',basename($path));
                return STATIC_PATH.dirname($path).'/'.$imgPrefix.$name.".{$type}";
            }else{
               return STATIC_PATH.$path;
            }
        }else{
            return STATIC_PATH.$imgPrefix.'nopic.gif';
        }
    }
}
/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 */
function AU($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Pz/Index/execute', $params);
}

/**
 * M函数用于实例化一个没有模型文件的Model
 * @param string $name Model名称 支持指定基础模型 例如 MongoModel:User
 * @param string $tablePrefix 表前缀
 * @param mixed $connection 数据库连接信息  默认连接到sql server数据库
 * @return Model
 */
function MU($name='', $tablePrefix='tb_',$connection='sqlsrv') {
    static $_model  = array();
    if(strpos($name,':')) {
        list($class,$name)    =  explode(':',$name);
    }else{
        $class      =   'Think\\Model';
    }
    $guid           =   (is_array($connection)?implode('',$connection):$connection).$tablePrefix . $name . '_' . $class;
    if (!isset($_model[$guid]))
        $_model[$guid] = new $class($name,$tablePrefix,$connection);
    return $_model[$guid];
}
/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
    if($data === false || $data === null ){
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($map as $col=>$pair){
            if(isset($row[$col]) && isset($pair[$row[$col]])){
                $data[$key][$col.'_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}


// 返回本月的所有周末时间段,周末的开始时间到结束时间=====张腾瑞
function this_mouth_weeked1111111111(){
    $key=0;
    $today=getdate();//获得当天的日期时间
    $i=mktime(0,0,0,$today['mon'],1,$today['year']);//获得本月一号的时间戳
    while(1){
        $day=getdate($i);
        if ($day['mon']!=$today['mon']) break;
        if ($day['wday']==0 || $day['wday']==6) {
            $arr_weeked[$key][]=date('Y-m-d',$i);
            if($day['wday']==6){
                 $key++;
            }
        }
        $i+=24*3600;
    }

    //得到二维数组的开始时间跟结束时间=>新数组
    for ($i=0; $i < count($arr_weeked) ; $i++) { 
        if(count($arr_weeked[$i])==2){
            $this_mouth_weeked[$i]['start']=strtotime($arr_weeked[$i][0]);
            $this_mouth_weeked[$i]['end']=strtotime($arr_weeked[$i][1])+60*60*24-1;
        }else{
            $this_mouth_weeked[$i]['start']=strtotime($arr_weeked[$i][0]);
            $this_mouth_weeked[$i]['end']=strtotime($arr_weeked[$i][0])+60*60*24-1;
        }
    }
    return $this_mouth_weeked;
}

function this_mouth_weeked(){
    $today=getdate();//获得当天的日期时间
    $i=mktime(0,0,0,$today['mon'],1,$today['year']);//获得本月一号的时间戳
    while(1){
        $day=getdate($i);
        if ($day['mon']!=$today['mon']) break;
        if ($day['wday']==0 || $day['wday']==6) {
            $arr_weeked[]=strtotime(date('Y-m-d',$i));
            $key++;
        }
        $i+=24*3600;
    }
    return $arr_weeked;
}
/**
 *上传图片生成略显图 裁剪成固定的高和宽
 * @param $uid 用户id
 * @param $aid 帐号id
 * @param $id 相册id
 * @param $files $_FILES['cover'] 文件
 * @param $info 图片信息 生成图片前缀,宽,高|第二张图前缀,宽，高
 * @param $original 是保留原图 1是0否 默认为1  如果要原图 返回数组最后一个是原图
 * @return array
 */
function upAlbum($uid,$aid,$id,$files,$temp='',$info='thumb_,120,120|bmid_,440,440',$original=1){
    if($temp){
        $filepath['url']=$files;
    }else{
        $filepath=filesMoveToTemp($files,array('jpg','png','gif','jpeg'));
    }

    $image=new \Common\Extend\Image();
    $file=end(explode('/', $filepath['url']));      //获得文件名
    $type=end(explode('.', $file));                 //获得文件类型
    $ii = $image->getImageInfo($filepath['url']);
    $filename=current(explode('.', $file));
    $path=filePath2($uid,'Imagespace','image/'.$id);
    $info_list=explode('|', $info);
    if(!$info_list) return false;
    foreach ($info_list as $v) {
        $pic_info=explode(',', $v);
        $thumbnailPath=$path.'/'.$pic_info[0].$filename.".{$ii['type']}";
        if( $image->thumb( $filepath['url'] ,  STATIC_PATH.$thumbnailPath ,$ii['type'], $pic_info[1], $pic_info[2])){
            $data[$pic_info[0]]=$thumbnailPath;
        }
    }
    if($original){
        copy($filepath['url'], STATIC_PATH.$path.'/'.$filename.".{$ii['type']}");
        $data['origin_']=$path.'/'.$filename.".{$ii['type']}";
    }
    return $data;
}

    //类似地址导航   传递一个子分类ID返回所有的父级分类
    function getParents($cate,$id){
        $arr=array();
        foreach ($cate as $v) {
            if($v['id']==$id){
                $arr[]=$v;
                $arr=array_merge(getParents($cate,$v['pid']),$arr);
            }
        }
        return $arr;
    }

    //传递一个父级ID返回所有子分类ID
    function getChildsId($cate,$id){
        $arr=array();
        foreach ($cate as $v) {
            if($v['pid']==$id){
                $arr[]=$v['id'];
                $arr=array_merge($arr,getChildsId($cate,$v['id']));
            }
        }
        return $arr;
    }

    //无限级分类:小张
    function unlimitedForLayer($cate,$name="_child",$pid=903){
        $arr=array();
        foreach ($cate as $v) {
            if($v['pid']==$pid){
                $v[$name]=unlimitedForLayer($cate,$name,$v['id']);
                $arr[]=$v;
            }
        }
        return $arr;
    }

    /**
    * 导出数据为excel表格
    *@param $data    一个二维数组,结构如同从数据库查出来的数组
    *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
    *@param $filename 下载的文件名
    *@examlpe 
    $stu = M ('User');
    $arr = $stu -> select();
    exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
*/
function exportexcel($data=array(),$title=array(),$filename='report'){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");  
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);
            
        }
        echo implode("\n",$data);
    }
}

// 权限   根据name返回status
function name_to_status($name){
    if($name){
        $row=D('AuthRule')->where(array('name'=>$name,'pid'=>array('neq',1)))->find();
        // echo $row['status'];die;
        return $row['status'];
    }
}

/*复制xCopy函数用法：   
  *   xCopy("feiy","feiy2",1):拷贝feiy下的文件到   feiy2,包括子目录    
  *   xCopy("feiy","feiy2",0):拷贝feiy下的文件到   feiy2,不包括子目录    
  *参数说明：    
  *   $source:源目录名    
  *   $destination:目的目录名    
  *   $child:复制时，是不是包含的子目录 
  */
function xCopy($source, $destination, $child){
    if(!file_exists($destination)) {
        if(!mkdir(rtrim($destination, '/') , 0777)){
            return false;
        }
        @chmod($destination,0777);
    }
    if (!is_dir($source)) {
        return 0;
    }
    if (!is_dir($destination)) {
        mkdir($destination, 0777);
    }
    $handle = dir($source);
    while ($entry = $handle->read()) {
        if (($entry != ".") && ($entry != "..")) {
            if (is_dir($source . "/" . $entry)) {
                if ($child) xCopy($source . "/" . $entry, $destination . "/" . $entry, $child);
            } else {
                copy($source . "/" . $entry, $destination . "/" . $entry);
            }
        }
    }
    return 1;
}

require './app/Common/Common/cache.php';
require './app/Common/Common/oss.php';
?>