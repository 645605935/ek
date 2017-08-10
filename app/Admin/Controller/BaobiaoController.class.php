<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class BaobiaoController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Baobiao';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    public function index_1(){
        global $user;
        $this->cur_v='Baobiao-index_1';
        
        $this->display();
    }

    public function index_2(){
        global $user;
        $this->cur_v='Baobiao-index_2';
        
        $this->display();
    }

    

   
}

?>