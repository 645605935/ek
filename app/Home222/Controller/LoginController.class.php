<?php

namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller {

    public function lists() {
        $c_userid = cookie('userid');
        if ($c_userid > 0) {
            $info = M("user")->field("name")->where(" id= '" . $c_userid . "'")->find();
            if (!empty($info['name'])) {
                session('username', $info['name']);
                session('userid', $c_userid);
            }
        }
        $assignArr = array(
            "title" => "会员登录 - 素材火",
        );
        $this->assign($assignArr);
        $this->display("Index:login");
    }

    

}

?>
