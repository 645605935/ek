<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class BanjiController extends AuthController {

	public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Banji';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    //线尾检测
    public function index_1(){
        global $user;
        $this->cur_v='Banji-index_1';

        $page="Card/index_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //线尾检测
    public function index_2(){
        global $user;
        $this->cur_v='Banji-index_2';

        $page="Card/index_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //线尾检测
    public function index_3(){
        global $user;
        $this->cur_v='Banji-index_3';

        $page="Card/index_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;


        $this->display();
    }

    //线尾检测
    public function index_3_2(){
        global $user;
        $this->cur_v='Banji-index_3_2';
        $this->display();
    }

    //线尾检测
    public function index_3_3(){
        global $user;
        $this->cur_v='Banji-index_3_3';
        $this->display();
    }

    //成品库存
    public function index_4(){
        global $user;
        $this->cur_v='Banji-index_4';

        $page="Card/index_4";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }


}

?>