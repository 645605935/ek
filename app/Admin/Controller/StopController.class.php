<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class StopController extends AuthController {

	public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 停线管理
     */
    public function index(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 停线原因时长统计
     */
    public function echart_2_1(){
        global $user;

        $this->display();
    }

    /**
     * @cc 模具停线时长统计
     */
    public function echart_1_2(){
        global $user;

        $this->display();
    }


}