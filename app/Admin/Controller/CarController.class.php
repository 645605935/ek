<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class CarController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Car';
    }

    //车型信息维护
    public function index(){
        global $user;
        $this->cur_v='Car-index';
        $this->display();
    }

    //车型-零件关联
    public function index2(){
        global $user;
        $this->cur_v='Car-index2';
        $this->display();
    }

    //车型消耗统计
    public function index3(){
        global $user;
        $this->cur_v='Car-index3';
        $this->display();
    }

    

   
}

?>