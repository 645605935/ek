<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class PanelController extends AuthController {

    public function _initialize() {
        parent::_initialize();

        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 板料库存管理
     */
    public function panel_00(){
        global $user;

        $this->display();
    }

    /**
     * @cc 线上临时库存
     */
    public function panel_11(){
        global $user;

        $this->display();
    }

    /**
     * @cc 板料追溯
     */
    public function panel_22(){
        global $user;

        $this->display();
    }

    /**
     * @cc 板料出入库管理
     */
    public function panel_12(){
        global $user;

        $this->display();
    }

    /**
     * @cc 托盘管理
     */
    public function panel_33(){
        global $user;

        $this->display();
    }

    /**
     * @cc 板料和托盘信息
     */
    public function panel_44(){
        global $user;

        $this->display();
    }

    /**
     * @cc 供应商不合格板料控制
     */
    public function panel_55(){
        global $user;

        $this->display();
    }



}
