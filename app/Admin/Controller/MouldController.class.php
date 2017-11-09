<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class MouldController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Mould';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    /**
     * @cc 模具状态管理
     */
    public function index_1(){
        global $user;
        $this->cur_v='Mould-index_1';

        $page="Mould/index_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 模具工单
     */
    public function index_2(){
        global $user;
        $this->cur_v='Mould-index_2';

        $page="Mould/index_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 模具维修工时报表
     */
    public function index_3(){
        global $user;
        $this->cur_v='Mould-index_3';

        $page="Mould/index_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 模具信息
     */
    public function index_4(){
        global $user;
        $this->cur_v='Mould-index_4';

        $page="Mould/index_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 模具年度预检计划
     */
    public function index_5(){
        global $user;
        $this->cur_v='Mould-index_5';

        $page="Mould/index_5";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

  

   
}