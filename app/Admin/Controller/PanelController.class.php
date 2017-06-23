<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class PanelController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Panel';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    public function panel_00(){
        global $user;
        $this->cur_v='Panel-panel_00';

        $page="Card/panel_00";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display(); 
    }

    //板料
    public function panel_11(){
        global $user;
        $this->cur_v='Panel-panel_11';

        $page="Card/panel_11";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //板料
    public function panel_22(){
        global $user;
        $this->cur_v='Panel-panel_22';

        $page="Card/panel_22";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        // dump($_POST);

        $this->display();
    }

    //来料
    public function panel_1(){
        global $user;
        $this->cur_v='Panel-panel_1'; 
        $this->display();
    }

    //板料
    public function panel_12(){
        global $user;
        $this->cur_v='Panel-panel_12';

        $page="Card/panel_12";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //来料详情
    public function panel_1_1(){
        global $user;
        $this->cur_v='Panel-panel_1';
        $this->display();
    }

    //板料
    public function panel_2(){
        global $user;
        $this->cur_v='Panel-panel_2';
        $this->display();
    }

    //板料
    public function panel_3(){
        global $user;
        $this->cur_v='Panel-panel_3';
        $this->display();
    }

    //托盘管理
    public function panel_33(){
        global $user;
        $this->cur_v='Panel-panel_33';

        $page="Card/panel_33";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    //托盘日志
    public function panel_44(){
        global $user;
        $this->cur_v='Panel-panel_44';
        $this->display();
    }

    

}

?>