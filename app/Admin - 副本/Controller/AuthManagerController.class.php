<?php
namespace Admin\Controller;
use Common\Controller\AuthController;


class AuthManagerController extends AuthController{

    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='AuthManager';
    }
    
    /**
     * 用户组列表
     */
    public function index(){
        global $user;

        $list=M('AuthGroup')->where(array('pid'=>0))->select();

        $_arr=array();
        foreach ($list as $key => $value) {
            $_arr[]=$value;
            $_temp=M('AuthGroup')->where(array('pid'=>$value['id']))->select();
            foreach ($_temp as $k => $v) {
                $_arr[]=$v;
            }
        }
        $this->list=$_arr;

        $this->cur_v='AuthManager-index';
        $this->display();
    }

    /**
     * 添加用户组
     */
    public function addGroup(){
        global $user;
        $this->user=$user;

        if (IS_POST) {
            $data['title']=I('title');
            $data['pid']=I('pid');
            $data['description']=I('description');
            $data['status']=I('status');

            if($id = M('AuthGroup')->add($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('用户组添加成功',U('Admin/AuthManager/index'));
            }else{
                $this->error('用户组添加失败'); 
            }
        }else{
            $parent_group=M('AuthGroup')->where(array('pid'=>0))->select();
            $this->parent_group=$parent_group;

            $this->cur_v='AuthManager-addGroup';
            $this->display('addgroup');
        }
    }

    /**
     * 编辑用户组
     */
    public function editGroup(){
        global $user;
        $this->user=$user;

        if (IS_POST) {
            $where['id']=I('id');
            $data['title']=I('title');
            $data['pid']=I('pid');
            $data['description']=I('description');
            $data['status']=I('status');

            if(M('AuthGroup')->where($where)->save($data)){

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('用户组编辑成功',U('Admin/AuthManager/index'));
            }else{
                $this->error('用户组编辑失败'); 
            }
        }else{
            if($id=I('id')){
                $row=M('AuthGroup')->find($id);
                $this->row=$row;
            }
            $this->cur_v='AuthManager-editGroup';

            $parent_group=M('AuthGroup')->where(array('pid'=>0))->select();
            $this->parent_group=$parent_group;

            $this->display('editgroup');
        }
    }

    /**
     * 用户组设置权限
     */
    public function authSet(){
        global $user;
        $this->user=$user;
        
        if (IS_POST) {
            $data['id']=I('id');
            $data['rules']=implode(',', I('rules'));

            if(M('AuthGroup')->save($data)){
                
                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('权限编辑成功',U('Admin/AuthManager/index'));
            }else{
                $this->error('权限编辑失败'); 
            }
        }else{
            $group_id=I('id');
            $group=M('AuthGroup')->find($group_id);
            if($group['pid']==0){
                $list=M('AuthRule')->where(array('level'=>2))->select();
                foreach ($list as $key => $value) {
                    $list[$key]['children']=M('AuthRule')->where(array('level'=>3,'pid'=>$value['id']))->select();
                }
                $this->node_list=$list;
            }else{
                $parent_group=M('AuthGroup')->where(array('id'=>$group['pid']))->find();
                $_rules=explode(',',$parent_group['rules']);

                $list=M('AuthRule')->where(array('level'=>2))->select();
                foreach ($list as $key => $value) {
                    $list[$key]['children']=M('AuthRule')->where(array('level'=>3,'pid'=>$value['id'],'id'=>array('in',$_rules)))->select();
                }

                $this->node_list=$list;
            }
            $this->group=$group;

            


            $this->cur_v='AuthManager-authSet';
            $this->display('authSet');
        }
    }

    //删除
    public function del(){
        if($ids=I('post.ids')){
            // var_dump($ids);die;
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $result=M('AuthGroup')->where($map)->delete();
            }else{
                $map['id'] = $ids;
                $result=M('AuthGroup')->where($map)->delete();
            }
            $txt='删除成功';
        }else{
            $txt='删除失败';
        }
        echo json_encode(array('txt'=>$txt));
    }
}
