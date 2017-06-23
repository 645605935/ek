<?php
namespace Common\Controller;
use Think\Controller;
use Think\Auth;

class AuthController extends Controller {
    protected function _initialize() {
        //网站配置信息
        $web_set=D('config')->find(1);
        $this->web_set=$web_set;


        //是否已登录
    	$sess_auth=session('auth');

    	if(!$sess_auth){
    		$this->error('非法访问，正在跳转到登录页',U('Admin/Login/index'));
    	}

    	// 如果是超级管理员的话，就不用验证权限了，给予所有权限
        $_uid_=$sess_auth['uid'];
    	if($sess_auth['gid']!=427){
            //下面执行权限判断
            $auth = new Auth();
            $_auth_=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
            // echo $_uid_."<br>";
            // echo $_auth_;die;
            if(!$auth->check($_auth_, $_uid_)){
                $this->error('没有权限',U('Admin/Index/index'));
            }
        }
    	
    }
    
}

?>