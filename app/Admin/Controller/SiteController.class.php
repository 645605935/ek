<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class SiteController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Site';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    /**
     * @cc 设备列表
     */
    public function device(){
        global $user;
        $this->cur_v='Site-device';

        $page="Site/device";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 模具管理
     */
    public function mould(){
        global $user;
        $this->cur_v='Site-mould';

        $page="Site/mould";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 车型管理
     */
    public function carts_1(){
        global $user;
        $this->cur_v='Site-carts_1';

        $page="Site/carts_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 零件管理
     */
    public function parts_1(){
        global $user;
        $this->cur_v='Site-parts_1';

        $page="Site/parts_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 托盘管理
     */
    public function tuopan(){
        global $user;
        $this->cur_v='Site-tuopan';

        $page="Site/tuopan";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 板料和托盘信息
     */
    public function banliao(){
        global $user;
        $this->cur_v='Site-banliao';

        $page="Site/banliao";
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
        $this->cur_v='Site-banci_2';

        $page="Site/banci_2";
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
        $this->cur_v='Site-liaojia';

        $page="Site/liaojia";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc 人员管理
     */
    public function banzu(){
        global $user;
        $this->cur_v='Site-banzu';

        $page="Site/banzu";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    /**
     * @cc KPI目标
     */
    public function bbtarget(){
        global $user;
        $this->cur_v='Site-bbtarget';

        $page="Site/bbtarget";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }
    

}

?>