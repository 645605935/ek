<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class CardController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Card';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    //工单列表
    public function index(){
        global $user;
        $this->cur_v='Card-index';

        if($_POST){
            $this->_POST=$_POST;
        }
        
        $this->display();
    }

    //工单原因
    public function index2(){
        global $user;
        $this->cur_v='Card-index2';

        if($_POST){
            $this->_POST=$_POST;
        }

        $this->display();
    }

    //工时统计
    public function index3(){
        global $user;
        $this->cur_v='Card-index3';

        if($_POST){
            $this->_POST=$_POST;
        }

        $this->display();
    }

    //模具维修工时报表
    public function index3_1(){
        global $user;
        $this->cur_v='Card-index3_1';

        $page="Card/index3_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //模具保养工时报表
    public function index3_2(){
        global $user;
        $this->cur_v='Card-index3_2';

        $page="Card/index3_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //设备维修工时报表
    public function index3_3(){
        global $user;
        $this->cur_v='Card-index3_3';

        $page="Card/index3_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //模具工单管理
    public function index4(){
        global $user;
        $this->cur_v='Card-index4';

        $page="Card/index4";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }
    
    //生产工单
    public function index5(){
        global $user;
        $this->cur_v='Card-index5';

        $page="Card/index5";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //设备工单
    public function index6(){
        global $user;
        $this->cur_v='Card-index6';

        $page="Card/index6";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //过程工单
    public function index7(){
        global $user;
        $this->cur_v='Card-index7';

        $page="Card/index7";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //成品维修工单
    public function index8(){
        global $user;
        $this->cur_v='Card-index8';

        $page="Card/index8";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

   
}

?>