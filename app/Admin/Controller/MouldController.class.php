<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class MouldController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 模具状态管理
     */
    public function index_1(){
        global $user;

        $this->display();
    }

    /**
     * @cc 模具工单
     */
    public function index_2(){
        global $user;

        $this->display();
    }

    /**
     * @cc 模具维修工时报表
     */
    public function index_3(){
        global $user;

        $this->display();
    }

    /**
     * @cc 模具信息
     */
    public function index_4(){
        global $user;

        $this->display();
    }

    /**
     * @cc 模具年度预检计划
     */
    public function index_5(){
        global $user;

        $this->display();
    }

  

   
}