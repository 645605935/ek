<?php

namespace Home\Controller;

use Think\Controller;

class AjaxController extends Controller {

    public function checkUsername() {
        $username = I('post.username');
        $info = M("user")->field("id")->where("name = '" . $username . "'")->find();
        if ($info) {
            echo -1;
        }
    }

    public function checkEmail() {
        $email = I('post.email');
        $info = M("user")->field("id")->where("email = '" . $email . "'")->find();
        if ($info) {
            echo -1;
        }
    }

    public function checkLogin() {
        $is_bind = I("post.is_bind", 0, 'int');
        $pwd = I('post.pwd');
        $username = I('post.username');
        if (checkEmail($username) == 'true') {
            $info = M("user")->field("id,nickname")->where("email = '" . $username . "'  AND pwd = '" . md5($pwd) . "'")->find();
        } else {
            $info = M("user")->field("id,nickname")->where("name = '" . $username . "'  AND pwd = '" . md5($pwd) . "'")->find();
        }

        if (empty($info)) {
            echo json_encode(array("error" => "您输入的用户名/邮箱/密码无效。"));
            exit;
        } else {
            $userid = $info['id'];
        }
        $nickname = $info['nickname'];
        $tip = "登录成功！";
        if ($is_bind == 1) { //若是绑定 
            $openid = getSessionCookie("openid");
            if ($openid) {
                $field = getSessionCookie("field");

                $userinfo = M("user")->field('id,name')->where("" . $field . "= '" . $openid . "'")->find();

                if (!$userinfo) { //没有的话绑定账号，送积分和发广告，有绑定的话直接登录
                    // 绑定账号
                    M('user')->where("id = " . $userid . "")->save(array($field => $openid));

                    emptySessionCookie('type');
                    emptySessionCookie('openid');
                }
            }
        }
        setSessionCookie("userid", $userid);
        setSessionCookie("username", getNickname($username, $nickname));
        echo json_encode(array("username" => $username, "userid" => $userid, "avatar" => getUserAvatar($userid), "tip" => $tip, "error" => ""));
    }

}

?>