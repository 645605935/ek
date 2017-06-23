<?php 
namespace Think\Template\TagLib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();

class E extends TagLib{ 
    protected $tags   =  array( 
        // 标签定义：attr 属性列表close 是否闭合（0 或者1 默认1）alias 标签别名level 嵌套层次 
        'loop'=>array('attr'=>'table,limit,order,where,field,name,offset,length,relation,key','level'=>3),
        'row'=>array('attr'=>'table,order,where,field,name,relation','level'=>3,'close'=>0),
        'count'=>array('attr'=>'table,count','level'=>3,'close'=>0),

        ); 

    public function _loop($tag,$content){

        $name   = $tag['name'];

        $table  = $tag['table'];

        $where  = $tag['where'];

        $field  = $tag['field'];

        $order  = $tag['order'];

        $limit  = $tag['limit'];

        $key  = $tag['key'];

        $relation  = $tag['relation'];

        if($tag['offset'] != ''|| $tag['offset'] == '0'){

            $offset ='offset="'.$tag['offset'].'"';

        }else{

            $offset = '';

        }

        $length = !empty($tag['length'])?'length="'.$tag['length'].'"':'';

        $key    = !empty($tag['key'])?'key="'.$tag['key'].'"':'';

        $parse  = '<?php $e_list=D("'.$table.'")';

        $parse .= !empty($where)?'->where("'.$where.'")':'';

        $parse .= !empty($field)?'->field("'.$field.'")':'';

        $parse .= !empty($order)?'->order("'.$order.'")':'';

        $parse .= !empty($limit)?'->limit("'.$limit.'")':'';

        $parse .= !empty($relation)?'->relation('.$relation.')':'';

        $parse .= '->select();?>';

        $parse .= '<volist name="e_list" id="'. $name .'" '.$offset.' '.$length.' '.$key.' >';

        $parse .= $content;

        $parse .= '</volist>';

        return $parse;

    }

    public function _row($tag,$content){

        $name   = $tag['name'];

        $table  = $tag['table'];

        $where  = $tag['where'];

        $field  = $tag['field'];

        $order  = $tag['order'];

        $key  = $tag['key'];

        $relation  = $tag['relation'];

        $parse  = '<?php $'.$name.'=D("'.$table.'")';

        $parse .= !empty($where)?'->where("'.$where.'")':'';

        $parse .= !empty($field)?'->field("'.$field.'")':'';

        $parse .= !empty($order)?'->order("'.$order.'")':'';

        $parse .= !empty($relation)?'->relation('.$relation.')':'';

        $parse .= '->find();?>';

        return $parse;

    }

    public function _count($tag,$content){


        $name   = $tag['name'];

        $table  = $tag['table'];

        $where  = $tag['where'];

        $parse  = '<?php $'.$name.'=D("'.$table.'")';

        $parse .= !empty($where)?'->where("'.$where.'")':'';

        $parse .= '->count();?>';

        $parse .= $content;

        return $parse;

    }

}

?> 