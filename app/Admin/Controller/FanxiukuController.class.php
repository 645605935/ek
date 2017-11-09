<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class FanxiukuController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Fanxiuku';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    /**
     * @cc 返修库管理
     */
    public function index_1(){
        global $user;
        $this->cur_v='Fanxiuku-index_1';

        $page="Fanxiuku/index_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 返修工单
     */
    public function index_2(){
        global $user;
        $this->cur_v='Fanxiuku-index_2';

        $page="Fanxiuku/index_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 返修工时报表
     */
    public function index_3(){
        global $user;
        $this->cur_v='Fanxiuku-index_3';

        $page="Fanxiuku/index_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }
    

}