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

    /**
     * @cc 生产计划
     */
    public function index(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-index';

        $page="Course/index";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    /**
     * @cc 生产记录
     */
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

    /**
     * @cc SPM报表
     */
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

    /**
     * @cc 料架管理
     */
    public function liaojia(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-liaojia';

        $page="Course/liaojia";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 产量统计报表
     */
    public function baobiao1(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-baobiao1';

        $page="Course/baobiao1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 班次管理
     */
    public function banci_2(){
        global $user;
        $this->user=$user;
        $this->cur_v='Course-banci_2';

        $page="Course/banci_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }
   
}
