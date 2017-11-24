<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class BaobiaoController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 可动率报表
     */
    public function index_1(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc ASPH报表
     */
    public function index_2(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 产量完成率报表
     */
    public function index_4(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 平均返修时间报表
     */
    public function index_4_1(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 返修率报表
     */
    public function index_4_2(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 换模时间报表
     */
    public function index_4_3(){
        global $user;
        
        $this->display();
    }
    
    /**
     * @cc 报废率报表
     */
    public function index_4_4(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 生产时间完成率报表
     */
    public function index_4_5(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 板料PPM报表
     */
    public function index_4_6(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 计划调试已维修时间报表
     */
    public function index_4_7(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 首百件生产时间报表
     */
    public function index_4_8(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 冲压件PPM统计
     */
    public function index_4_9(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 一次通过率
     */
    public function index_4_10(){
        global $user;
        
        $this->display();
    }


    /**
     * @cc 产量完成率报表
     */
    public function index_5(){
        global $user;
        
        $this->display();
    }

    

   
}