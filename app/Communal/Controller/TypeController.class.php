<?php
namespace Communal\Controller;
use Think\CommonController;
class TypeController extends CommonController{
    public $all;
    public function _initialize() {
        parent::_initialize();    
        $this->all=cacheType(1);
    }
    //获得所有地区
    public function getAll(){
        return $this->all;
    }
    //获得某个id下的下一集分类
    public function getSon($id){
        $child = array();
        foreach ($this->all as $key => $value)
            if($value['pid']==$id) $child[]=$value;
        return $child;
    }
    //获得某个点下的所有子
    public function getChilds($id,$flag=null){
        return pid_list($this->all,$id);
    }
    //获得son的id
    public function getSonId($id){
        $ids = array();
        foreach ($this->all as $key => $value)
            if($value['pid']==$id) $ids[]=$value['id'];
        return $ids;
    }
    //获得selectOption
    public function selectOption($all,$id,$selected_id=null,$focus=null,$root=0,$disabled=array()){
        return selectOption($all,$selected_id,$focus,$id,$disabled);
    }
    //获得某个点下的selectOption
    public function getOptionById($id,$selected_id,$disabled=array()){
        return $this->selectOption($this->getChilds($id),$id,$selected_id,'','',$disabled);
    }
    //获得某一个点
    public function getRow($id){
        foreach ($this->all as $key => $value) 
        if($value['id']==$id) return $value;
    }
    //将城市变成树形结构
    public function getTree(){
        return list_to_tree($this->all);
    }
    //获得某个点下的树形结构 root填主节点的id即可
    public function getChildTree($root = 0,$pk = 'id', $pid = 'pid', $child = '_child' ){
        return list_to_tree($this->all,$pk,$pid,$child,$root);
    }
    //获得某个点下的所有子 一级
    public function getAllChild($id){
        return pid_list($this->all,$id,'type_'.$id);
    }
    //获得某个点下的所有子的id
    public function getAllChildId($id){
        $ids=array();
        foreach ($this->getAllChild($id) as $key => $value) 
            $ids[]=$value['id'];
        return $ids;
    }
    //获得某个殿下的所有id和自己的id
    public function getSelfAndChildId($id){
        return array_merge(array($id),$this->getAllChildId($id));
    }

}