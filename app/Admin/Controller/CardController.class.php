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

    /**
     * @cc 设备维修工时报表
     */
    public function index3_3(){
        global $user;
        $this->cur_v='Card-index3_3';

        $page="Card/index3_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 设备工单
     */
    public function index6(){
        global $user;
        $this->cur_v='Card-index6';

        $page="Card/index6";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 过程工单
     */
    public function index7(){
        global $user;
        $this->cur_v='Card-index7';

        $page="Card/index7";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

  

   
}