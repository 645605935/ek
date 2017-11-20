<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class CourseController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 生产计划
     */
    public function index(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 生产记录
     */
    public function index_2(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc SPM报表
     */
    public function baobiao(){
        global $user;

        $this->display();
    }

    /**
     * @cc 料架管理
     */
    public function liaojia(){
        global $user;

        $this->display();
    }

    /**
     * @cc 产量统计报表
     */
    public function baobiao1(){
        global $user;

        $this->display();
    }

    /**
     * @cc 班次管理
     */
    public function banci_2(){
        global $user;

        if(!$_GET['line']){
            $this->redirect('Admin/Site/banci_2', array('line' => 'A'));
        }
        
        $this->display();
    }
   
}
