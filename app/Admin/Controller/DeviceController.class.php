<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class DeviceController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Device';
    }


    //设备列表
    public function index(){
        global $user;
        $this->cur_v='Device-index';
        $this->display();
    }
}

?>