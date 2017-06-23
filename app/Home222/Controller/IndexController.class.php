<?php

namespace Home\Controller;

use Think\Controller;
use ThinkOauth;

class IndexController extends Controller {

    public function index() {
        header("Content-type: text/html; charset=utf-8");
        $assignArr = array(
            "title" => "首页 - 素材火",
        );
        $this->assign($assignArr);
        $this->display();
    }

    public function bind() {
        $assignArr = array(
            "title" => "绑定已有账号 - 素材火",
            "nickname" => getSessionCookie('nickname')
        );
        $this->assign($assignArr);
        $this->display();
    }

    public function login($type = null) {
        empty($type) && $this->error('参数错误');
        import('Org.ThinkSDK.ThinkOauth');


        $sns = ThinkOauth::getInstance($type);
//echo $sns->getRequestCodeURL();exit;
//        //跳转到授权页面
        redirect($sns->getRequestCodeURL());
    }

    public function callback($type = null, $code = null) {
        header("Content-type: text/html; charset=utf-8");
        (empty($type) || empty($code)) && $this->error('参数错误');
        import('Org.ThinkSDK.ThinkOauth');
        $sns = ThinkOauth::getInstance($type);

        //腾讯微博需传递的额外参数
        $extend = null;
        if ($type == 'tencent') {
            $extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
        }
        $tokenArr = $sns->getAccessToken($code, $extend);
        $openid = $tokenArr['openid'];
        $token = $tokenArr['access_token'];
        setSessionCookie("openid", $openid);
        setSessionCookie("access_token", $token);
//        $con = "openid:".$openid."\n"."token".$token;
//	file_put_contents("1.txt", $con);
        //获取当前登录用户信息
        if ($openid) {
            $field = strtolower($type);
            setSessionCookie("field", $field);
            $userinfo = M("user")->field('id,name')->where("" . $field . "= '" . $openid . "'")->find();

            if ($userinfo) { //若是有该账号就登录
                setSessionCookie("userid", $userinfo['id']);
                setSessionCookie("username", $userinfo['name']);
                echo "<script>document.location.href='" . __APP__ . "';</script>";
                exit;
            } else { //没有的话绑定
                $userid = getSessionCookie('userid');
                $username = getSessionCookie('username');
                if ($userid != '' && $username != '') { //用户已登录，自动绑定
                    //绑定账号
                    M('user')->where("id = " . $userid . "")->save(array($field => $openid));
                    emptySessionCookie('type');
                    emptySessionCookie('openid');
                    $this->success("绑定成功！", "/");
                } else { //用户未登录，跳转到绑定页面
                    if ($filed == 'qq') { //针对新版qq互联在绑定页，要显示昵称，否则不通过***
                        $data = $sns->call('user/get_user_info');
                        $nickname = $data['nickname'];
                    } else {
                        $userinfo = A('Type', 'Event')->$type($tokenArr);
                        $nickname = $userinfo['name'];
                    }
                    setSessionCookie('nickname', $nickname);
                    $this->redirect("Index/bind");
                }
            }
        } else {
            echo "<script>alert('系统出错;请稍后再试！');document.location.href='" . __APP__ . "';</script>";
        }
    }

    public function logout() {
        emptySessionCookie("username");
        emptySessionCookie("userid");
        $r = I("get.r") ? I("get.r") : __APP__;
        header("Location: " . $r . "");
    }

}
