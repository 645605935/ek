<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
    //登陆界面
    public function index(){
		if(IS_POST){
            $username = I('username');
            $password =  I('password');

            $where=array();
            $where['username']=$username;
            $where['password']=md5($password);
          	$row=D('User')->where($where)->relation(true)->find();
            if($row){
                // 组织左侧菜单是否显示信息
                $auth_row=D('AuthGroup')->find($row['gid']);
                $auths=explode(',', $auth_row['rules']);

                $auth_action_list=D('AuthRule')->where(array('id'=>array('in',$auths)))->select();
                foreach ($auth_action_list as $key => $value) {
                    $auth_action_names[]=$value['name'];
                }
                
                $pids_arr=D('AuthRule')->field('pid')->distinct(true)->where(array('id'=>array('in',$auths)))->select();
                foreach ($pids_arr as $key => $value) {
                    $pids[]=$value['pid'];
                }
                foreach ($pids as $key => $value) {
                    $auth_controller_list[]=D('AuthRule')->find($value);
                }
                foreach ($auth_controller_list as $key => $value) {
                    $auth_controller_names[]=$value['name'];
                }


                $login=array();
                $login['uid']=$row['id'];
                $login['username']=$row['username'];
                $login['gid']=$row['gid'];
                $login['avatar']=$row['img'];


                if($row['gid']==427){
                    $login['group']="超级管理员";               
                }elseif($row['gid']>1){
                    $login['auth_controller_names']=$auth_controller_names;
                    $login['auth_action_names']=$auth_action_names;
                }else{
                    $this->error('用户名或密码错误');
                }

                if(count($login)){
                    session('auth',$login);

                    // 日志记录  start
                    $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                    $model=MODULE_NAME;
                    $controller=CONTROLLER_NAME;
                    $action=ACTION_NAME;
                    $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                    if(!$title){$title['title']="暂无规则";}
                    D('Log')->addLog($title,$url,$model,$controller,$action);
                    // 日志记录  end

                    // 记住我  start
                    $remember=$_POST['remember'];
                    if($remember==1){
                        cookie('remember_password',trim($_POST['password']),3600*24*30); // 指定密码保存一个月
                        cookie('remember_username',trim($_POST['username']),3600*24*30); // 指定用户名保存一个月
                        cookie('remember_remember',trim($_POST['remember']),3600*24*30); // 指定用户名保存一个月
                    }else{
                        cookie(null,'ez_');//  清空指定前缀的所有cookie值
                    }
                    // 记住我  end
                   // $this->success('登录成功！');

                   $this->success('登录成功！',U('Admin/Index/index'));
                }
            }else{
                $redirect_url=$_SERVER['HTTP_ORIGIN'];
                $this->error('用户不存在',$redirect_url);
            }

            
        }else{
             
            // 记住我  start
            $password = cookie('remember_password');
            $username = cookie('remember_username');
            $remember = cookie('remember_remember');
            
            if($password && $username){
                $this->assign('password',$password);
                $this->assign('username',$username);
                $this->assign('remember',$remember);
            }
            // 记住我  end
            
            $this->display();
        }
    }	
	
    

    // 用户登出
    public function logout() {
        $user=session('auth');
        if($user['gid']==4||$user['gid']==3){
            session('[destory]');
            $this->success('退出成功',"http://".$_SERVER['SERVER_NAME']);
        }else{
            session('[destory]');
            $this->success('退出成功',"http://".$_SERVER['SERVER_NAME']);
        }
    }	

}