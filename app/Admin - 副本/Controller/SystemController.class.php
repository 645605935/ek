<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class SystemController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='System';
    }


    //能源列表
    public function index(){
        global $user;
        $this->cur_v='System-index';
        $this->display();
    }
}

?>