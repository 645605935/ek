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

        $this->block_1='1、返修率（Repair rate）';
        $this->block_2='2、返修率（Repair rate）';
        $this->block_3='3、零件Repair rate';
        $this->block_4='4、Repair rate列表';
        $this->block_5='5、单件Repair rate列表';
        $this->block_6='6、单件Repair rate趋势';
        
        $this->display();
    }
    
    /**
     * @cc 报废率报表
     */
    public function index_4_4(){
        global $user;

        $this->block_1='1、报废率（Scrap rate）';
        $this->block_2='2、报废率（Scrap rate）';
        $this->block_3='3、零件Scrap rate';
        $this->block_4='4、Scrap rate列表';
        $this->block_5='5、单件Scrap rate列表';
        $this->block_6='6、单件Scrap rate趋势';
        
        $this->display();
    }

    /**
     * @cc 一次通过率
     */
    public function index_4_10(){
        global $user;

        $this->block_1='1、一次通过率（FTT）';
        $this->block_2='2、一次通过率（FTT）';
        $this->block_3='3、零件FTT';
        $this->block_4='4、FTT列表';
        $this->block_5='5、单件FTT列表';
        $this->block_6='6、单件FTT趋势';
        
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
     * @cc 产量完成率报表
     */
    public function index_5(){
        global $user;
        
        $this->display();
    }

    

   
}