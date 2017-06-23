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


    //设备列表
    public function device(){
        global $user;
        $this->cur_v='Site-device';

        $page="Site/device";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //table
    public function table(){
        global $user;
        $this->cur_v='Site-table';

        $page="Site/table";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //模具列表
    public function mould(){
        global $user;
        $this->cur_v='Site-mould';

        $page="Site/mould";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //托盘列表
    public function pallet(){
        global $user;
        $this->cur_v='Site-pallet';

        $page="Site/pallet";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型列表
    public function carts(){
        global $user;
        $this->cur_v='Site-carts';

        $page="Site/carts";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //零件列表
    public function parts(){
        global $user;
        $this->cur_v='Site-parts';

        $page="Site/parts";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //零件列表
    public function echart_1(){
        global $user;
        $this->cur_v='Site-echart_1';

        $page="Site/echart_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //零件列表
    public function echart_2(){
        global $user;
        $this->cur_v='Site-echart_2';

        $page="Site/echart_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型
    public function carts_1(){
        global $user;
        $this->cur_v='Site-carts_1';

        $page="Site/carts_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型
    public function carts_2(){
        global $user;
        $this->cur_v='Site-carts_2';

        $page="Site/carts_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型
    public function carts_3(){
        global $user;
        $this->cur_v='Site-carts_3';

        $page="Site/carts_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型
    public function parts_1(){
        global $user;
        $this->cur_v='Site-parts_1';

        $page="Site/parts_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型
    public function parts_2(){
        global $user;
        $this->cur_v='Site-parts_2';

        $page="Site/parts_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //车型
    public function parts_3(){
        global $user;
        $this->cur_v='Site-parts_3';

        $page="Site/parts_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //线尾检测
    public function test(){
        global $user;
        $this->cur_v='Site-test';

        $page="Site/test";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    //生产排成
    public function paicheng(){
        global $user;
        $this->cur_v='Site-paicheng';

        $page="Site/paicheng";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //仪表管理
    public function yibiao(){
        global $user;
        $this->cur_v='Site-yibiao';

        $page="Site/yibiao";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //托盘管理
    public function tuopan(){
        global $user;
        $this->cur_v='Site-tuopan';

        $page="Site/tuopan";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //板料管理
    public function banliao(){
        global $user;
        $this->cur_v='Site-banliao';

        $page="Site/banliao";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //工序管理
    public function gongxu(){
        global $user;
        $this->cur_v='Site-gongxu';

        $page="Site/gongxu";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //班次
    public function banci_1(){
        global $user;
        $this->cur_v='Site-banci_1';

        $page="Site/banci_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //班次
    public function banci_2(){
        global $user;
        $this->cur_v='Site-banci_2';

        $page="Site/banci_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //料架
    public function liaojia(){
        global $user;
        $this->cur_v='Site-liaojia';

        $page="Site/liaojia";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }
    

}

?>