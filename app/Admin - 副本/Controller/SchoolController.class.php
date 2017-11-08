<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class SchoolController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='School';
    }

    //合作院校列表页
    public function index(){
        global $user;

        $d =D('School');
        $map=array();

        if(IS_POST){
            if($_POST['title']){
                $map['title']=array('like',"%".$_POST['title']."%");
            }
            if($_POST['status']){
                $map['status']=$_POST['status'];
            }
            $this->title=$_POST['title'];
            $this->status=$_POST['status'];
        }
        
        $list = $d->order('id desc')->where($map)->select();
        $this->assign('list',$list);
        $this->cur_v='School-index';
        $this->display();
    }

    // 添加学校
    public function add(){
        global $user;
        $this->user=$user;

        $d=D('School');
        if(IS_POST){
            if(!$_POST['title']){
                $this->error('合作院标名称不能为空');
            }else{
                // 查重
                $where=array();
                $where['title']=$_POST['title'];
                if($d->where($where)->find()){
                    $this->error('该学校名称已存在，不可以重复添加');
                }
            }
            

            $data['title'] =I('title');
            $data['total'] =I('total');
            $data['url'] =I('url');
            $data['status'] =I('status');
            $data['start_time'] =NOW_TIME;
            $data['end_time'] =strtotime(I('end_time'));
            $data['time']       =NOW_TIME;

            if($id=$d->add($data)){
                if($_FILES['img']['size']>0){
                    $image=new \Common\Extend\Image();
                    $img=$image->upload($_FILES['img'],filePath($id,'School'),'thumb');
                    $update['img']      =$img['origin_'];
                    $update['id']=$id;
                    $d->save($update);
                }

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('添加成功',U('Admin/School/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->cur_v='School-add';
            $this->display();
        }
    }

    // 编辑学校
    public function edit(){
        global $user;

        if(IS_POST){
            if(!$_POST['title']){$this->error('标题不能为空');exit;};
            $d=D('School');        
            $data=$d->create();
            $data['end_time'] =strtotime(I('end_time'));
            $data['time']       =NOW_TIME;

            if($_FILES['img']['size']>0){
                $image=new \Common\Extend\Image();
                $img=$image->upload($_FILES['img'],filePath($data['id'],'School'),'thumb');
                $data['img']    =$img['origin_'];
            }else{
                unset($data['img']);
            }

            if($d->save($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('编辑成功',U('Admin/School/index'));
            }else{
                $this->error('编辑失败');
            }

        }else{
            $this->row=M('School')->where('id='.$_GET['id'])->find();
            $this->cur_v='School-edit';
            $this->display();
        }
    }

    //设置教师（列表页）
    public function setTeacher(){
        global $user;

        $where['sid']=I('id');
        $where['role']=3;
        $where['gid']=3;
        $this->list=D('User')->where($where)->relation(true)->select();
        // var_dump($this->list);die;
        $this->sid=I('id');
        $this->cur_v='School-setTeacher';
        $this->display();
    }

    //添加教师
    public function addTeacher(){
        global $user;
        $this->user=$user;

        if(IS_POST){
            if(!$_POST['username']){$this->error('登录用户名不能为空');exit;};

            if(D('User')->where(array('username'=>$_POST['username']))->find()){
                $this->error('用户名已存在');exit;
            }

            $d=D('User');        
            $data['username']   =I('username');
            $data['truename']   =I('truename');
            $data['password']   =md5(I('password'));
            $data['phone']   =I('phone');
            $data['email']   =I('email');
            $data['auths']   =implode(',', I('auth_rule'));

            $data['role']   = 3;
            $data['gid']   = 3;
            $data['sid']   = I('sid');
            $data['register_time']   =NOW_TIME;
            $data['time']   =NOW_TIME;

            if($_FILES['img']['size']>0){
                $image=new \Common\Extend\Image();
                $img=$image->upload($_FILES['img'],filePath($data['id'],'Course'),'thumb');
                $data['img']    =$img['origin_'];
            }else{
                unset($data['img']);
            }

            if($d->add($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('添加教师成功',U('Admin/School/index'));
            }else{
                $this->error('添加教师失败');
            }

        }else{
            // 教师组权限列表
            $teacher_auth=D('AuthGroup')->find(3);
            $teacher_auth_arr=explode(',', $teacher_auth['rules']);

            $teacher_auth_list=D('AuthRule')->where(array('id'=>array('in',$teacher_auth_arr)))->select();
            $pids_arr=D('AuthRule')->field('pid')->distinct(true)->where(array('id'=>array('in',$teacher_auth_arr)))->select();

            foreach ($pids_arr as $key => $value) {
                $pids[]=$value['pid'];
            }

            foreach ($pids as $key => $value) {
                $temp_parent=D('AuthRule')->find($value);

                $list[$key]['_parent']=$temp_parent;

                foreach ($teacher_auth_list as $ko => $vo) {
                    if($vo['pid']==$value){
                        $list[$key]['_children'][]=$vo;
                    }
                }
            }

            $this->list=$list;
            $this->cur_v='School-addTeacher';
            $this->display();
        }
    }

    //编辑教师
    public function editTeacher(){
        global $user;

        if(IS_POST){
            if(!$_POST['username']){$this->error('登录用户名不能为空');exit;};

            $d=D('User');        
            $data['id']   =I('id');
            $data['username']   =I('username');
            $data['truename']   =I('truename');

            if($_POST['password']){
                $data['password']   =md5(I('password'));
            }

            $data['phone']   =I('phone');
            $data['email']   =I('email');
            $data['auths']   =implode(',', I('auth_rule'));

            $data['time']   =NOW_TIME;

            if($_FILES['img']['size']>0){
                $image=new \Common\Extend\Image();
                $img=$image->upload($_FILES['img'],filePath($data['id'],'Course'),'thumb');
                $data['img']    =$img['origin_'];
            }else{
                unset($data['img']);
            }

            if($d->save($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('编辑教师成功',U('Admin/School/setTeacher',array('id'=>I('sid'))));
            }else{
                $this->error('编辑教师失败');
            }

        }else{
            $row=M('User')->where('id='.$_GET['id'])->find();
            $this->auths=explode(',', $row['auths']);
            $this->row=$row;

            // 教师组权限列表
            $teacher_auth=D('AuthGroup')->find(3);
            $teacher_auth_arr=explode(',', $teacher_auth['rules']);

            $teacher_auth_list=D('AuthRule')->where(array('id'=>array('in',$teacher_auth_arr)))->select();
            $pids_arr=D('AuthRule')->field('pid')->distinct(true)->where(array('id'=>array('in',$teacher_auth_arr)))->select();

            foreach ($pids_arr as $key => $value) {
                $pids[]=$value['pid'];
            }

            foreach ($pids as $key => $value) {
                $temp_parent=D('AuthRule')->find($value);

                $list[$key]['_parent']=$temp_parent;

                foreach ($teacher_auth_list as $ko => $vo) {
                    if($vo['pid']==$value){
                        $list[$key]['_children'][]=$vo;
                    }
                }
            }

            $this->list=$list;
            $this->cur_v='School-editTeacher';
            $this->display();
        }
    }

    //设置课程
    public function setCourse(){
        global $user;
        
        if(IS_POST){
            $d=D('School');   
            $data=array();   
            $data['courses']   =implode(',',I('courseId'));
            $data['id']=I('id');

            if($d->save($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('设置成功',U('Admin/School/index'));
            }else{
                $this->error('设置失败');
            }

        }else{
            $row=D('School')->find(I('id'));
            $this->courses=explode(',', $row['courses']);
            $list = D('Course')->select();
            $this->list = $list;
            $this->row = $row;
            $this->cur_v='School-setCourse';
            $this->display();
        }
    }

    //删除教师
    public function delTeacher(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $result=M('User')->where($map)->delete();
                foreach ($ids as  $id) {
                    $dir=STATIC_PATH.filePath2($id,'User');
                    delDir( $dir );
                }
            }else{
                $map['id'] = $ids;
                $result=M('User')->where($map)->delete();
                $dir=STATIC_PATH.filePath2($ids,'User');
                delDir( $dir );
            }

            // 日志记录  start
            $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
            $model=MODULE_NAME;
            $controller=CONTROLLER_NAME;
            $action=ACTION_NAME;
            $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
            if(!$title){$title['title']="暂无规则";}
            D('Log')->addLog($title,$url,$model,$controller,$action);
            // 日志记录  end

            $txt='删除成功';
        }else{
            $txt='删除失败';
        }
        echo json_encode(array('txt'=>$txt));
    }

    //删除
    public function del(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $result=M('School')->where($map)->delete();
                foreach ($ids as  $id) {
                    $dir=STATIC_PATH.filePath2($id,'School');
                    delDir( $dir );
                }
            }else{
                $map['id'] = $ids;
                $result=M('School')->where($map)->delete();
                $dir=STATIC_PATH.filePath2($ids,'School');
                delDir( $dir );
            }

            // 日志记录  start
            $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
            $model=MODULE_NAME;
            $controller=CONTROLLER_NAME;
            $action=ACTION_NAME;
            $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
            if(!$title){$title['title']="暂无规则";}
            D('Log')->addLog($title,$url,$model,$controller,$action);
            // 日志记录  end
            
            $txt='删除成功';
        }else{
            $txt='删除失败';
        }
        echo json_encode(array('txt'=>$txt));
    }
}

?>