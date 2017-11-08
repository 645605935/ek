<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class StopController extends AuthController {

	public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Stop';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    /**
     * @cc 停线管理
     */
    public function index(){
        global $user;
        $this->cur_v='Stop-index';

        $page="Card/index";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    /**
     * @cc 停线原因时长统计
     */
    public function echart_1_1(){
        global $user;
        $this->cur_v='Stop-echart_1_1';

        $page="Card/echart_1_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 模具停线时长统计
     */
    public function echart_1_2(){
        global $user;
        $this->cur_v='Stop-echart_1_2';

        $page="Card/echart_1_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }


}