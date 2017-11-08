<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class UserController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='User';

        if($_POST){
            $this->_POST=$_POST;
        }
    }

    //删除用户，对应的权限也需要删除
    public function del(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $map2['uid']=$map['id'];

                if($result=M('User')->where($map)->delete()){
                    M('AuthGroupAccess')->where($map2)->delete();
                }
                foreach ($ids as  $id) {
                    $dir=STATIC_PATH.filePath2($id,'Banji');
                    delDir( $dir );
                }
            }else{
                $map['id'] = $ids;
                $map2['uid'] = $ids;
                if($result=M('User')->where($map)->delete()){
                    M('AuthGroupAccess')->where($map2)->delete();
                }
                $dir=STATIC_PATH.filePath2($ids,'Banji');
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


    //会员列表
    public function homeUser(){
        global $user;
        $this->user=$user;

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;


        $this->cur_v='User-homeUser';

        $page="User/index3_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        
        $this->display();
    }

    //会员列表
    public function ajax_get_user_list(){
        $map=array();
        if($_GET['username']){
            $map['username']=array('like','%'.$_GET['username'].'%');
        }
            
        if($_GET['gid']>0){
            $map['gid']=$_GET['gid'];
        }

        $map['id']=array('neq',1);
        $d = D('User');
        $list = $d->where($map)->order('id desc')->relation(true)->select();

        foreach ($list as $key => $value) {
            $list[$key]['register_time']=date('Y-m-d',$value['register_time']);
            $list[$key]['img']="./Uploads".$value['img'];
        }

        if($list){
            $data=array();
            $data['code']=0;
            $data['msg']='success';
            $data['data']=$list;
        }else{
            $data=array();
            $data['code']=1;
            $data['msg']='empty';
        }
        echo json_encode($data);
    }

    //排序
    public function ajax_sortable(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        dump($_arr);die;

        if($_arr){
            $id=$_arr['id'];

            $row = D('User')->find($id);
            if($row){
                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']=$row;
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
        }else{
            $data=array();
            $data['code']=2;
            $data['msg']='error';
        }

        echo json_encode($data);
    }

    //根据ID获取用户关联的信息
    public function ajax_get_user_relation_logs(){

        $id=$_GET['id'];
        if($id==0){
            $list = array();
        }else{
            $list = D('Log')->where(array('uid'=>$id))->order('time desc')->select();
        }

        

        echo json_encode($list);
    }

    //根据ID获取用户关联的信息
    public function ajax_get_user_relation_cases(){

        $id=$_GET['id'];
        if($id==0){
            $list = array();
        }else{
            $list = D('Case')->where(array('creater'=>$id))->order('time desc')->select();
        }

        

        echo json_encode($list);
    }

    //根据ID获取用户信息
    public function ajax_get_user_info_by_id(){

        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        if($_arr){
            $id=$_arr['id'];

            $row = D('User')->find($id);
            if($row){
                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']=$row;
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
        }else{
            $data=array();
            $data['code']=2;
            $data['msg']='error';
        }

        echo json_encode($data);
    }

    //编辑用户信息
    public function ajax_edit_user(){

        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        if($_arr){
            $id=$_arr['id'];
            $where=array('id'=>$id);

            $data=array();
            $data['truename']=$_arr['truename'];
            $data['username']=$_arr['username'];
            $data['gid']=$_arr['gid'];
            if($_arr['img']!=''){
                //删除原来的图片
                $_old_img = D('User')->where('id='.$id)->getField('img');
                unlink('./Uploads'.$_old_img);

                $data['img']=$_arr['img'];
            }
            

            $res = D('User')->where($where)->save($data);
            $row = D('User')->relation(true)->find($id);
            if($res){
                // 赋权限,如果没有则添加
                if( !$_row_=M('AuthGroupAccess')->where(array('uid'=>$id))->find() ){
                    $ga_data=array();
                    $ga_data['uid']=$id;
                    $ga_data['group_id']=$_arr['gid'];
                    M('AuthGroupAccess')->add($ga_data);
                }else{
                    $ga_data=array();
                    $ga_data['group_id']=$_arr['gid'];
                    M('AuthGroupAccess')->where(array('uid'=>$id))->save($ga_data);
                }

                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']=$row;
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
        }else{
            $data=array();
            $data['code']=2;
            $data['msg']='error';
        }

        echo json_encode($data);
    }

    //添加用户信息
    public function ajax_add_user(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        if($_arr){
            $data=array();
            $data['truename']=$_arr['truename'];
            $data['password']=md5($_arr['password']);
            $data['username']=$_arr['username'];
            $data['gid']=$_arr['gid'];
            $data['img']=$_arr['img'];
            $data['time']=time();


            if($id = D('User')->where($where)->add($data)){
                $row= D('User')->relation(true)->find($id);
                if($row){
                    // 赋权限,如果没有则添加
                    $ga_data=array();
                    $ga_data['uid']=$id;
                    $ga_data['group_id']=$_arr['gid'];
                    M('AuthGroupAccess')->add($ga_data);
                    

                    $data=array();
                    $data['code']=0;
                    $data['msg']='success';
                    $data['data']=$row;
                }else{
                    $data=array();
                    $data['code']=1;
                    $data['msg']='error';
                }
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
            
            
        }else{
            $data=array();
            $data['code']=2;
            $data['msg']='error';
        }

        echo json_encode($data);
    }

    //删除
    public function ajax_del(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);


        $ids=$_arr['ids']; 

        $ids_arr=explode(',', $ids);

        if(is_array($ids_arr)){
            foreach ($ids_arr as $key => $value) {
                $_uid=$value;
                $_user_info=M('User')->where(array('id'=>$_uid))->find();
                unlink('./Uploads'.$_user_info['img']);
                //删除相关数据表里的数据
                if(M('User')->where(array('id'=>$_uid))->delete()){
                    M('AuthGroupAccess')->where(array('uid'=>$_uid))->delete();
                    unlink($_SERVER['HTTP_ORIGIN'].'/Uploads'.$_user_info);
                }
            }
        }

        $data=array();
        $data['code']=0;
        $data['msg']='success';
        
        echo json_encode($data);
    }

    //删除
    public function ajax_del1111(){

        if( IS_POST && $_POST['oper']=='del' ){
            $ids=$_POST['id']; 

            $ids_arr=explode(',', $ids);

            if(is_array($ids_arr)){
                foreach ($ids_arr as $key => $value) {
                    $_uid=$value;
                    $_user_info=M('User')->where(array('id'=>$_uid))->find();
                    //删除相关数据表里的数据
                    if(M('User')->where(array('id'=>$_uid))->delete()){
                        M('AuthGroupAccess')->where(array('uid'=>$_uid))->delete();
                        // unlink($file); 
                    }
                }
            }else{
                $map['id'] = $ids;
                $map2['uid'] = $ids;
                if($result=M('User')->where($map)->delete()){
                    M('AuthGroupAccess')->where($map2)->delete();
                }
                // $dir=STATIC_PATH.filePath2($ids,'Banji');
                // delDir( $dir );
            }

            $data=array();
            $data['code']=0;
            $data['msg']='删除成功';
        }
        
        echo json_encode($data);
    }

    


    //编辑用户信息
    public function userEdit(){
        global $user;
        $this->user=$user;

        $d=D('User');
        if(IS_POST){
           
            $data=array();
            $data['id']             =   I('post.id');
            $data['truename']       =   I('post.truename');
            I('post.password')?$data['password'] = md5(I('post.password')):null;
            $data['gid']       =   I('post.gid');
            $data['email']       =   I('post.email');
            $data['phone']       =   I('post.phone');
            // $data['status']         =   I('post.status');
            if ($d->save($data)){            
                // 付权限
                //如果没有则添加
                if(!$row=M('AuthGroupAccess')->find(I('id'))){
                    $ga_data['uid']=I('id');
                    $ga_data['group_id']=I('post.gid');
                    M('AuthGroupAccess')->add($ga_data);
                }else{
                    $ga_data['uid']=I('post.gid');
                    M('AuthGroupAccess')->where(array('uid'=>I('post.id')))->save($ga_data);
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

                $this->success('编辑成功');
            }else{
                $this->error('编辑失败');
            }
        }else{
            $id=I('get.id');
            $row=M('User')->find($id);
            $this->row=$row;
            $group=M('AuthGroup')->select();
            $this->group=$group;
            $this->cur_v='User-userEdit';
            $this->display();
        }
    }

    //添加用户信息
    public function useradd(){
        global $user;

        $d=D('User');
        if(IS_POST){
           // 用户是否存在
            if($d->where(array('username'=>I('username')))->find()){
                $this->error("该用户名已存在,请更换用户名");
            }
            
            $data=array();
            $data['username']       =   I('post.username');
            $data['truename']       =   I('post.truename');
            $data['gid']       =   I('post.gid');
            $data['email']       =   I('post.email');
            $data['phone']       =   I('post.phone');
            $data['register_time']     =   time();
            $data['time']     =   time();
            I('post.password')?$data['password'] = md5(I('post.password')):null;
            if ($id=$d->add($data)){
                 // 赋予权限
                $ga_data['uid']=$id;
                $ga_data['group_id']=I('post.gid');
                M('AuthGroupAccess')->add($ga_data);

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $group=M('AuthGroup')->select();
            $this->group=$group;
            $this->cur_v='User-userAdd';
            $this->display();
        }
    }

    //批量添加用户信息
    public function usersAdd(){
        global $user;
        $this->user=$user;
     
        if(IS_POST){
            $bid=I('post.bid');
            $end_time=strtotime(I('post.end_time'));;
            header("Content-Type:text/html;charset=utf-8");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类
            $upload->savePath  =      '/excel/'; // 设置附件上传目录
            // 上传文件
            $info   =   $upload->uploadOne($_FILES['img']);
            $filename = './Uploads'.$info['savepath'].$info['savename'];
            $exts = $info['ext'];
           
           if(!$info) {
                // 上传错误提示错误信息
                $this->error($upload->getError());
            }else{
                // 上传成功
                $this->user_import($filename, $exts,$bid,$end_time);
            }
        }else{
            // 该老师的班级信息
            $banji=D('Banji')->where(array('tid'=>$user['uid'],'sid'=>$user['sid']))->select();
            $this->banji=$banji;
            $this->cur_v='User-usersAdd';
            $this->display();
        }
    }  

    //导入数据方法
    protected function user_import($filename, $exts='xls',$bid,$end_time){
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel=new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //获取总行数
        $allRow=$currentSheet->getHighestRow();
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }
        
        }

        $this->save_import($arr,$bid,$end_time);
    }

    //保存导入数据
    public function save_import($data,$bid,$end_time){
        if(!$user=session('auth')){
            $this->error('请登录','Admin/Login/index');
        }

        $db = D('User');

        foreach ($data as $key => $value) {
            if($key > 1){
                $user_arr[$key]['username']=$value['A'];
                $user_arr[$key]['password']=md5($value['B']);
                $user_arr[$key]['truename']=$value['C'];
                $user_arr[$key]['email']=$value['D'];
                $user_arr[$key]['phone']=$value['E'];
                $user_arr[$key]['end_time']=$end_time;
                $user_arr[$key]['gid']='4';
                $user_arr[$key]['role']='4';
                $user_arr[$key]['sid']=$user['sid'];
                $user_arr[$key]['bid']=$bid;
                $user_arr[$key]['creater']=$user['uid'];                
                $user_arr[$key]['register_time']=NOW_TIME;
                $user_arr[$key]['start_time']=NOW_TIME;
                
             if(!$db->where(array('username'=>$user_arr[$key]['username'],'sid'=>$user_arr[$key]['sid']))->find()){
                 if($id=$db->add($user_arr[$key])){
                     // 赋予权限
                    $ga_data['uid']=$id;
                    $ga_data['group_id']= 4;
                    M('AuthGroupAccess')->add($ga_data);
                 }
              }
            }
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
        $this->success('学生导入成功', 'Admin/User/students');
    }

    // ==================================================================
    //学生信息列表
    public function students(){
        global $user;
        $this->user=$user;
        $sid = $user['sid'];

        if(I('username')){
            $map['username']=array('like','%'.I('username').'%');
            $this->username=I('username');
        }
        if(I('bid')){
            $map['bid']=I('bid');
            $this->bid=I('bid');
        }

        $map['sid']=$sid;
        $d = D('User');
        
        $map['gid']=4;
        if($user['gid']==1){
            unset($map['sid']);
        }
        $list = $d->where($map)->order('id desc')->relation(true)->select();

        foreach ($list as $key => $value) {
            $list[$key]['_creater']=D('User')->find($value['creater']);
        }
   
        // 班级
        $banji=D('Banji')->where(array('sid'=>$sid))->select();
        $this->assign('banji',$banji);
        $this->assign('list',$list);
        $this->cur_v='User-students';
        $this->display();
    }

    //编辑学生信息
    public function editStudent(){
        global $user;
        $this->user=$user;

        if(IS_POST){
            $d=D('User');

            $data=array();
            $data['id']             =   I('post.id');
            $data['username']       =   I('post.username');
            $data['truename']       =   I('post.truename');
            $data['end_time']       =   strtotime(I('post.end_time'));
            $data['status']         =   I('post.status');
            $data['gid']            =   '4';
            $data['bid']            =   I('post.bid');
            $data['sid']            =   $user['sid'];
            $data['role']           =   '4';
            $data['email']          =   I('post.email');
            $data['phone']          =   I('post.phone');
            I('post.password')?$data['password'] = md5(I('post.password')):null;

            if ($d->save($data)){
        
                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('编辑成功','Admin/User/students');
            }else{
                $this->error('编辑失败');
            }
        }else{
            $id=I('get.id');
            $row=M('User')->find($id);
            if($row['end_time']<=0){
                $row['end_time']=time();
            }
            $this->row=$row;
            $banji=D('Banji')->where(array('sid'=>$user['sid']))->select();
            $this->banji=$banji;
            $this->cur_v='User-editStudent';
            $this->display();
        }
    }

    //添加学生信息
    public function addStudent(){
        global $user;
        $this->user=$user;

        if(IS_POST){
            // 学生人数不得超过设置人数
            $school_info=D('School')->find($user['sid']);
            $all_student_sum=D('User')->where(array('sid'=>$user['sid']))->count();
            if( $school_info['total'] <= $all_student_sum ){
                $this->error('本学校学生人数已满');
            }

            $d=D('User');

            // 本校的范围内个用户名是否存在
            if($db->where(array('username'=>I('post.username'),'sid'=>$user['sid']))->find()){
                $this->error("该用户名已存在，请更换用户名");
            }
            $data=array();
            $data['username']       =   I('post.username');
            $data['truename']       =   I('post.truename');
            $data['end_time']       =   strtotime(I('post.end_time'));
            $data['start_time']     =   time();
            $data['status']         =   I('post.status');
            $data['gid']            =   '4';
            $data['role']           =   '4';
            $data['bid']            =   I('post.bid');
            $data['sid']            =   $user['sid'];
            $data['creater']        =   $user['uid'];
            $data['email']          =   I('post.email');
            $data['phone']          =   I('post.phone');
            I('post.password')?$data['password'] = md5(I('post.password')):null;

            if ($id=$d->add($data)){
            
                // 赋予权限
                $ga_data['uid']=$id;
                $ga_data['group_id']= 4;
                M('AuthGroupAccess')->add($ga_data);

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('添加成功','Admin/User/students');
            }else{
                $this->error('添加失败');
            }
           
        }else{
            $banji=D('Banji')->where(array('sid'=>$user['sid']))->select();
            $this->banji=$banji;
            $this->cur_v='User-addStudent';
            $this->display();
        }
    }

    //批量移动学生到指定班级
    public function moveToAll(){
        if(IS_POST){
            $ids=$_POST['ids'];
            $bid=$_POST['bid'];

            $d=D('User');
            $data['bid']=$bid;

            if(is_array($ids)){
                foreach ($ids as $id) {
                    $data['id']=$id;
                    $result[]=$d->save($data);
                }
            }else{
                $data['id']=$idS;
                $result=$d->save($data);
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

            $txt= $result ?  '转移成功' : '转移失败';

            $arr=array('txt'=>$txt);
            echo json_encode($arr);
        }
    }

    // 异步获得用户信息
    public function ajaxGetUser(){ 
        if(IS_POST){
            $uid = $_POST['uid'];
            $row=D('User')->find($uid);
// var_dump($row);die;
            echo json_encode($row);
        }
    }

    // 重置密码
    public function resetPassword(){ 
        if(IS_POST){
            $data['id'] = $_POST['id'];
            if($_POST['password']){
                $data['password'] = md5($_POST['password']);
            }else{
                $this->error('密码不能为空');
            }

            if(D('User')->save($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('重置成功');
            }else{
                $this->error('重置失败');
            }

        }
    }

    // 重置密码--修改自己的
    public function resetPasswordMyself(){
        global $user;
        $this->user=$user;

        if(IS_POST){

            $old_password=D('User')->field('password')->find($user['uid']);

            if($old_password['password']==md5(I('old_password'))){
                $data['id']=$user['uid'];
                $data['password']=md5(I('new_password'));
            }else{
                $this->error('原密码不正确');
            }

            if(I('new_password')!=I('renew_password')){
                $this->error('新密码跟确认密码不一致');
            }

            if(D('User')->save($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('重置成功');
            }else{
                $this->error('重置失败');
            }

        }else{
            $this->user=$user;
            $this->cur_v='User-resetPasswordMyself';
            $this->display();
        }
    }


    //添加教师会员 
    public function teacherAdd(){
        global $user;
        $this->user=$user;
        
        if(IS_POST){
            $d=M('User');
            $data=array();
            $data['username']   =   I('post.username');
            $data['truename']   =   I('post.truename');
            $data['password']   =   md5(I('post.password'));
            $data['guanli']     =   implode('#',I('post.guanli'));
            $data['role']       =   2;
            $data['status']     =   1;
            if ($id=$d->add($data)){
       
                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('添加教师成功');
            }else{
                $this->error('添加教师失败');
            }
        }
    }


    // 下载文件
     public function filedown(){
         $file=dirname(dirname(dirname(dirname(__FILE__))))."/Uploads/excel/students-template.xls";
        $this->download_file($file);
     }

     //下载文件
     function download_file($file){
         if(is_file($file)){
             $length = filesize($file);
             $type = mime_content_type($file);
             $showname =  ltrim(strrchr($file,'/'),'/');
             header("Content-Description: File Transfer");
             header('Content-type: ' . $type);
             header('Content-Length:' . $length);
              if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                  header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
              } else {
                  header('Content-Disposition: attachment; filename="' . $showname . '"');
              }
              readfile($file);

              // 日志记录  start
              $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
              $model=MODULE_NAME;
              $controller=CONTROLLER_NAME;
              $action=ACTION_NAME;
              $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
              if(!$title){$title['title']="暂无规则";}
              D('Log')->addLog($title,$url,$model,$controller,$action);
              // 日志记录  end
              exit;
          } else {
              exit('文件已被删除！');
          }
      }



      //==============================================================================================================================================
      // 上传图片--不对图进行任何处理
      public function upload_img(){
          if($_FILES['img']['size']>0){
              $upload = new \Think\Upload();// 实例化上传类
              $upload->maxSize   =     31457280 ;// 设置附件上传大小
              $upload->exts      =     array('zip', 'rar', 'xls','xlsx', 'doc','docx','ppt','pptx','pdf','jpg','png','jpeg','gif');// 设置附件上传类型
              $upload->uploadReplace  = false;// 存在同名文件是否覆盖
              $upload->autoSub   =     false;//是否启用子目录保存
              $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
              $upload->savePath  =     'layui/'; // 设置附件上传（子）目录
              $upload->saveRule  =     ''; // 设置附件上传（子）目录
               
              // 上传文件 
              $info   =   $upload->upload();

              if(!$info) {
                  $data=array();
                  $data['code']=0;
                  $data['msg']=$upload->getError();
              }else{
                  $img=$info['img']['savename'];
                  $data=array();
                  $data['code']=0;
                  $data['msg']='success';
                  $data['data']='/layui/'.$img;
              }

              echo json_encode($data);
          }
      }

      // 上传图片--不对图进行任何处理
      public function upload_img_editer(){
          if($_FILES['img']['size']>0){
              $upload = new \Think\Upload();// 实例化上传类
              $upload->maxSize   =     31457280 ;// 设置附件上传大小
              $upload->exts      =     array('zip', 'rar', 'xls','xlsx', 'doc','docx','ppt','pptx','pdf','jpg','png','jpeg','gif');// 设置附件上传类型
              $upload->uploadReplace  = false;// 存在同名文件是否覆盖
              $upload->autoSub   =     false;//是否启用子目录保存
              $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
              $upload->savePath  =     'layui/'; // 设置附件上传（子）目录
              $upload->saveRule  =     ''; // 设置附件上传（子）目录
               
              // 上传文件 
              $info   =   $upload->upload();

              if(!$info) {
                  $data=array();
                  $data['code']=0;
                  $data['msg']=$upload->getError();
              }else{
                  $img=$info['img']['savename'];
                  $data=array();
                  $data['code']=0;
                  $data['msg']='success';
                  $data['data']['src']='/layui/'.$img;
                  $data['data']['title']='11111';
              }

              echo json_encode($data);
          }
      }

      // 上传图片--生成三种大小的图片
      public function upload_img_3(){
          global $user;
          $uid=$user['uid'];

          if($_FILES['img']['size']>0){
              $image=new \Common\Extend\Image();
              $img=$image->upload($_FILES['img'],filePath($uid,'layui_3'),'thumb');

              if(!$img) {
                  $data=array();
                  $data['code']=0;
                  $data['msg']=$image->getError();
              }else{
                  $data=array();
                  $data['code']=0;
                  $data['msg']='上传成功';
                  $data['data']=$img;
              }

              echo json_encode($data);
          }
      }

}