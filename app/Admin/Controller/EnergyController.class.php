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
    }

// 电能仪表明细表/产量能耗报表/能耗趋势报表

    //电能仪表明细表
    public function index1(){
        global $user;
        $this->cur_v='Energy-index1';

        $page="Card/index1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //产量能耗报表
    public function index2(){
        global $user;
        $this->cur_v='Energy-index2';

        $page="Card/index2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //能耗趋势报表
    public function index3(){
        global $user;
        $this->cur_v='Energy-index3';

        $page="Card/index3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }
}

?>