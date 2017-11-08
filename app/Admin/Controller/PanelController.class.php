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

    /**
     * @cc 板料库存管理
     */
    public function panel_00(){
        global $user;
        $this->cur_v='Panel-panel_00';

        $page="Panel/panel_00";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display(); 
    }

    /**
     * @cc 线上临时库存
     */
    public function panel_11(){
        global $user;
        $this->cur_v='Panel-panel_11';

        $page="Panel/panel_11";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 板料追溯
     */
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

    /**
     * @cc 板料出入库管理
     */
    public function panel_12(){
        global $user;
        $this->cur_v='Panel-panel_12';

        $page="Panel/panel_12";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 托盘管理
     */
    public function panel_33(){
        global $user;
        $this->cur_v='Panel-panel_33';

        $page="Panel/panel_33";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    /**
     * @cc 板料和托盘信息
     */
    public function panel_44(){
        global $user;
        $this->cur_v='Panel-panel_44';

        $page="Panel/panel_44";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    

}

?>