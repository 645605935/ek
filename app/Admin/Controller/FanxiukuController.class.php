<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class FanxiukuController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 返修库管理
     */
    public function index_1(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 返修工单
     */
    public function index_2(){
        global $user;
      
        $this->display();
    }

    /**
     * @cc 返修工时报表
     */
    public function index_3(){
        global $user;

        $this->display();
    }
    

}