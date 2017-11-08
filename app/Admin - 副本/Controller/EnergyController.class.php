<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class EnergyController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Energy';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

// 电能仪表明细表/产量能耗报表/能耗趋势报表

    //电能仪表明细表
    public function index1(){
        global $user;
        $this->cur_v='Energy-index1';

        $page="Energy/index1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //产量能耗报表
    public function index2(){
        global $user;
        $this->cur_v='Energy-index2';

        $page="Energy/index2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //能耗趋势报表
    public function index3(){
        global $user;
        $this->cur_v='Energy-index3';

        $page="Energy/index3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }
}

?>