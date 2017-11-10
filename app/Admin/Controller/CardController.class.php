<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class CardController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 设备维修工时报表
     */
    public function index3_3(){
        global $user;

        $this->display();
    }

    /**
     * @cc 设备工单
     */
    public function index6(){
        global $user;

        $this->display();
    }

    /**
     * @cc 过程工单
     */
    public function index7(){
        global $user;
      
        $this->display();
    }

  

   
}