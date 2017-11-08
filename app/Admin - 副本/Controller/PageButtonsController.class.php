<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class PageButtonsController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='PageButtons';
    }

    //添加按钮
    public function ajax_add_page_button(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        $d=M('PageButtons');

        if($_arr){
            $page=$_arr['page'];
            $button=trim($_arr['button']);
            $remark=trim($_arr['remark']);

            $row=$d->where(array('page'=>$page, 'button'=>$button))->find();
            if(!$row){
                $data=array();
                $data['button']=$button;
                $data['page']=$page;
                $data['remark']=$remark;
                $data['time']=time();
                $id=$d->add($data);
                $row=$d->find($id);

                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']=$row;
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='已存在';
            }
            
        }

        echo json_encode($data);
    }

    //编辑按钮
    public function ajax_edit_page_button(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        $d=M('PageButtons');

        if($_arr){
            $id=$_arr['id'];
            $button=trim($_arr['button']);
            $remark=trim($_arr['remark']);

            $data=array();
            $data['button']=$button;
            $data['remark']=$remark;
            $data['time']=time();

            $where=array();
            $where['id']=$id;
            $res=$d->where($where)->save($data);



            if($res){
                $row=$d->find($id);

                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']=$row;
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
        }

        echo json_encode($data);
    }
    
    //删除按钮
    public function ajax_del_page_button(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        $d=M('PageButtons');

        if($_arr){
            $id=$_arr['id'];
            $res=$d->delete($id);

            if($res){
                $data=array();
                $data['code']=0;
                $data['msg']='success';
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
        }

        echo json_encode($data);
    }

    //初使化按钮操作权限
    public function init_button_operate(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        $page=$_arr['page'];

        //获取页面权限
        $gid=$_SESSION['ez_']['auth']['gid'];
        $role_buttons_info=M('role_buttons')->where(array('gid'=>$gid, 'page'=>$page))->find();
        $usable_buttons=explode(',',$role_buttons_info['buttons']);

        $page_buttons_list=M('page_buttons')->where(array('page'=>$page))->field('button')->select();
        $page_buttons=array();
        foreach ($page_buttons_list as $key => $value) {
            $page_buttons[]=$value['button'];
        }
        $unable_buttons=array_diff($page_buttons, $usable_buttons);

        echo json_encode($unable_buttons);
    }

    

    //添加角色对应的按钮
    public function ajax_add_role_buttons(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        $d=M('role_buttons');

        if($_arr){
            $page=$_arr['page'];
            $buttons=$_arr['buttons'];
            $gid=$_arr['gid'];

            $row=$d->where(array('page'=>$page, 'gid'=>$gid))->find();

            if(!$row){
                $data=array();
                $data['buttons']=$buttons;
                $data['gid']=$gid;
                $data['page']=$page;
                $data['time']=time();
                $id=$d->add($data);

                if($id){
                    $row=$d->find($id);

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
                $data['buttons']=$buttons;
                $data['time']=time();

                $where=array();
                $where['gid']=$gid;
                $where['page']=$page;
                $res=$d->where($where)->save($data);

                if($res){
                    $data=array();
                    $data['code']=0;
                    $data['msg']='success';
                }else{
                    $data=array();
                    $data['code']=1;
                    $data['msg']='error';
                }
            }
            
        }else{
            $data=array();
            $data['code']=2;
            $data['msg']='error';
        }

        echo json_encode($data);
    }

    //
    public function ajax_get_buttons(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        if($_arr){
            $gid=$_arr['gid'];
            $page=$_arr['page'];

            $page_buttons=M('page_buttons')->where(array('page'=>$page))->select();
            $role_buttons=M('role_buttons')->where(array('page'=>$page, 'gid'=>$gid))->find();

            $role_buttons_arr = explode(',', $role_buttons['buttons']);
            foreach ($page_buttons as $key => $value) {
                if(in_array($value['button'], $role_buttons_arr)){
                    $page_buttons[$key]['_has']=1;
                }else{
                    $page_buttons[$key]['_has']=0;
                }
            }

            $data=array();
            $data['code']=0;
            $data['msg']='success';
            $data['data']=$page_buttons;
            
        }else{
            $data=array();
            $data['code']=1;
            $data['msg']='error';
        }

        echo json_encode($data);
    }


   
}

?>