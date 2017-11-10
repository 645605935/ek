<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class SiteController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 设备列表
     */
    public function device(){
        global $user;

        $this->display();
    }

    /**
     * @cc 模具管理
     */
    public function mould(){
        global $user;

        $this->display();
    }

    /**
     * @cc 车型管理
     */
    public function carts_1(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 零件管理
     */
    public function parts_1(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 托盘管理
     */
    public function tuopan(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 板料和托盘信息
     */
    public function banliao(){
        global $user;

        $this->display();
    }

    /**
     * @cc 班次管理
     */
    public function banci_2(){
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
     * @cc 人员管理
     */
    public function banzu(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc KPI目标
     */
    public function bbtarget(){
        global $user;

        $this->display();
    }
    

}

?>