<?php
/**
* 网站配置缓存
* @param $clear int 0清理 1获取
* return array
*/
function cacheConfig($clear=1){
	switch ($clear) {
		case '0':
			S("Config/setting",null);
			break;
		case '1':
			$cache=S("Config/setting");
			if(empty($cache)){
				$cache = array_merge(C(),M('Config')->find());
			    S("Config/setting",$cache);
			}
			break;
	}
	return $cache;
}
/**
* 所有插件配置缓存
* @param $clear int 0清理 1获取
* return array
*/
function cacheAddons($clear=1){
	switch ($clear) {
		case '0':
			S('addons',null);
			break;
		case '1':
			$cache=S('addons');
			if(empty($cache)){
				$cache=M('Addons')->select();
				S('addons',$cache);
			}
			break;
	}
	return $cache;
}
//缓存icomoon
function cacheIcomoon($type='',$clear=1){
	switch ($clear) {
		case '0':
			S("Icomoon",null);
			break;
		case '1':
			$cache=S("Icomoon");
			if(empty($cache)){
				$cache =M('Icomoon')->getField('class',true);
			    S("Icomoon",$cache);
			}
			break;
	}
	return $cache;
}
/**
 * 获得所有城市的缓存
 * @param 0为清除缓存 1为获取缓存
 * @return array 请求数据结构         这个废除
 */
function getDistrict($clear=1){
	switch ($clear) {
		case '0':
			S('District',NULL);
			break;
		case '1':
			$cache=S('District');
		if(empty($cache)){
			$cache = M('District')->select();
			S('District',$cache);
		}
		break;
	}
	return $cache;
}
/**
 * 获得所有城市的缓存
 * @param 0为清除缓存 1为获取缓存
 * @return array 请求数据结构
 */
function cacheDistrict($clear=1){
	switch ($clear) {
		case '0':
			S('District',NULL);
			break;
		case '1':
			$cache=S('District');
		if(empty($cache)){
			$cache = M('District')->select();
			S('District',$cache);
		}
		break;
	}
	return $cache;
}
/**
 * 获得所有学校的缓存
 * @param 0为清除缓存 1为获取缓存
 * @return array 请求数据结构
 */
function getSchool($clear=1){
	switch ($clear) {
		case '0':
			S('School',NULL);
			break;
		case '1':
			$cache=S('School');
		if(empty($cache)){
			$cache = M('School')->select();
			S('School',$cache);
		}
		break;
	}
	return $cache;
}
/**
 * 获得所有分类的缓存
 * @param 0为清除缓存 1为获取缓存
 * @return array 请求数据结构
 */
function cacheType($clear=1){
	switch ($clear) {
		case '0':
			S('type',null);
			break;
		case '1':
			$cache=S('type');
			if(empty($cache)){
				$cache=M('Type')->order('sort asc')->select();
				S('type',$cache);
			}
			break;
	}
	return $cache;
}
/**
 * 根据地区id获得地区名字
 * @param $id 地区id
 * @return string 地区名字
 */
function getDistrictName($id){
	$district=cacheDistrict(1);
	foreach ($district as $key => $value) {
		if($value['id']==$id){
			return $value['title'];
		}
	}
}
/**
 * 根据分类id获得分类名字
 * @param $id 分类id
 * @return string 分类名字
 */
function getTypeRow($id){
	$type=cacheType(1);
	foreach ($type as $key => $value) {
		if($value['id']==$id){
			return $value;
		}
	}
}
/**
 * 根据分类id获得分类名字
 * @param $id 分类id
 * @return string 分类名字
 */
function getTypeName($id){
	$type=cacheType(1);
	foreach ($type as $key => $value) {
		if($value['id']==$id){
			return $value['title'];
		}
	}
}
/**
 * 根据分类id获得分类字段
 * @param $id 分类id
 * @param $field 字段名
 * @return string 分类名字
 */
function getTypeField($id,$field){
	$type=cacheType(1);
	foreach ($type as $key => $value) {
		if($value['id']==$id){
			if($field=='*'){
				return $value;
			}else{
				return $value[$field];
			}
		}
	}
}
?>