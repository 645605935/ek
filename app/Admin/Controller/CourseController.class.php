<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class CourseController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Course';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    //生产排成
    public function index(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-index';

        $page="Card/index";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    //工单列表
    public function index_2(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-index_2';

        $page="Card/index_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //工单列表
    public function _iframe_1(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-_iframe_1';

        $this->display();
    }

    //工单列表
    public function index_wljh(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-index_wljh';

        $this->display();
    }

    //节拍报表
    public function baobiao(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-baobiao';

        $page="Card/baobiao";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //料架管理
    public function liaojia(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-liaojia';

        $page="Card/liaojia";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //产量统计报表
    public function baobiao1(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-baobiao1';

        $page="Card/baobiao1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //产线报表
    public function baobiao2(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-baobiao2';

        $page="Card/baobiao2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    

   
}

?>