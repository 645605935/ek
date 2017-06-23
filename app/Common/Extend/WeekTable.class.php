<?php
namespace Common\Extend;
class WeekTable {
    public $arr;
    public $week=array(
                '1'=>'一',
                '2'=>'二',
                '3'=>'三',
                '4'=>'四',
                '5'=>'五',
                '6'=>'六',
                '7'=>'日',
            );
    public function __construct($arr) {
        $this->arr=$arr;
    }
    public function style1(){
        $html=$this->head();
        $html.='<tr><td class="bg_f4f4f4">上午</td>';
        foreach ($this->week as $key => $value) {
                $html.='<td>';
                    if(in_array(intval($key.'1'), $this->arr)){
                        $html.='<span>√</span>';
                    }
                $html.='</td>';
        }                              
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td class="bg_f4f4f4">下午</td>';
            foreach ($this->week as $key => $value) {
                $html.='<td>';
                    if(in_array(intval($key.'2'), $this->arr)){
                        $html.='<span>√</span>';
                    }
                $html.='</td>';
            }                              
        $html.='</tr>';
        $html.='<tr>';
        $html.='<td class="bg_f4f4f4">晚上</td>';
        foreach ($this->week as $key => $value) {
            $html.='<td>';
                if(in_array(intval($key.'3'), $this->arr)){
                    $html.='<span>√</span>';
                }
            $html.='</td>';
        }
        $html.=$this->foot();
        return $html;
    }
    public function head(){
        $html='<table class="tdDate"><tbody><tr class="bg_f4f4f4"><td></td>';
            for ($i=0; $i <7 ; $i++) { 
                $html.='<td>';
                $html.='星期'.$this->week[$i];
                $html.='</td>';
            }
        $html.='</tr>';
        return $html;
    }
    public function foot(){
        $html='</tr></tbody></table>';
        return $html;
    }
}   