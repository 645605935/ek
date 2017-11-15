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

        if(!$_POST && $_SERVER['PATH_INFO']!='Site/tuopan' && $_SERVER['PATH_INFO']!='Panel/panel_33'&& $_SERVER['PATH_INFO']!='Panel/panel_12'){


            if($_SERVER['PATH_INFO']=='Stop/echart_2_1'||$_SERVER['PATH_INFO']=='Banji/index_2'||$_SERVER['PATH_INFO']=='Banji/index_3'){

                if($_SERVER['PATH_INFO']=='Banji/index_2'){
                    $__time__start=strtotime(date('Y-m-d 00:00:00'));
                    $__time__end=strtotime(date('Y-m-d 08:30:00'));
                    $__time__now=time();
                    if($__time__now>$__time__start&&$__time__now<$__time__end){
                        $_POST['start']=date("Y-m-d 08:30:00",strtotime("-1 day"));
                        $_POST['end']=date('Y-m-d 08:30:00');
                    }else{
                        $_POST['start']=date("Y-m-d 08:30:00");
                        $_POST['end']=date('Y-m-d 08:30:00',strtotime("+1 day"));
                    }
                }elseif($_SERVER['PATH_INFO']=='Stop/echart_2_1'){
                    $__time__start=strtotime(date('Y-m-d 00:00:00'));
                    $__time__end=strtotime(date('Y-m-d 08:30:00'));
                    $__time__now=time();
                    if($__time__now>$__time__start&&$__time__now<$__time__end){
                        $_POST['Date1']=date("Y-m-d 08:30:00",strtotime("-1 day"));
                        $_POST['Date2']=date('Y-m-d 08:30:00');
                    }else{
                        $_POST['Date1']=date("Y-m-d 08:30:00");
                        $_POST['Date2']=date('Y-m-d 08:30:00',strtotime("+1 day"));
                    }
                }else{
                    $_POST['start']=date('Y-m-d');
                    $_POST['end']=date('Y-m-d');
                }
            }else{
                $_POST['Date1']=date('Y-m-d', strtotime('-30 days'));
                $_POST['Date2']=date('Y-m-d');
                
                $_POST['start']=date('Y-m-d', strtotime('-30 days'));
                $_POST['end']=date('Y-m-d');
            }

            $this->_POST=$_POST;
        }




        //左侧菜单选中状态
        $cur_arr=explode('/', $_SERVER['PATH_INFO']);
        $this->cur_c=$cur_arr[0];
        $this->cur_v=$_SERVER['PATH_INFO'];

        //页面按钮权限
        $page=$_SERVER['PATH_INFO'];
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        //用户组
        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }
    
}

?>