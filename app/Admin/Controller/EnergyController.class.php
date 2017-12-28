<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class EnergyController extends AuthController {

    public function _initialize() {
        parent::_initialize();

        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 电能仪表明细表
     */
    public function index1(){
        global $user;

        $this->display();
    }

    /**
     * @cc 产量能耗报表
     */
    public function index2(){
        global $user;

        $this->display();
    }

    /**
     * @cc 能耗趋势报表
     */
    public function index3(){
        global $user;

        $this->display();
    }

    /**
     * @cc 耗量统计
     */
    public function index4(){
        global $user;

        $this->display();
    }
}
