<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class TypeController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Type';
    }
    
    // 添加分类
    public function add(){
        global $user;
        $this->user=$user;

        if(IS_POST){
            !$_POST['title'] ? exit($this->error('标题不能为空')) : null;
            $d=D('Type');
            $pid= I('post.pid');
            $data['pid']        =$pid;
            $data['title']      =I('post.title');
            $data['sort']       =I('post.sort');
            $data['desc']       =I('post.desc');
            if($pid){
                $plevel=$d->where(array('id'=>$pid))->getField('level');
                $data['level']=$plevel+1;
            }else{
                $data['level']=0;
            }
            if($id=$d->add($data)){
                //封面图
                if($_FILES['img']['size']>0){
                    $img=uploadPicThumb($id,$_FILES['img'],'page');
                    $update['img']      =$img['origin_'];
                }
                $update['id']=$id;
                $d->save($update);

                $data['id']=$id;
                cacheType(0);

                // 日志记录  start
                $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
                $model=MODULE_NAME;
                $controller=CONTROLLER_NAME;
                $action=ACTION_NAME;
                $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
                if(!$title){$title['title']="暂无规则";}
                D('Log')->addLog($title,$url,$model,$controller,$action);
                // 日志记录  end

                $this->success('添加成功',U('Admin/Type/index'),'',$data);
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->select=A('Communal/Type')->getOptionById(0,$_GET['pid']);
            $this->display();
        }
    }

    // 编辑分类
    public function edit(){
        global $user;
        $this->user=$user;

        if(IS_POST){
            !$_POST['title'] ? exit($this->error('标题不能为空')) : null;
            $d=D('Type');
            $data=$d->create();
            
            if($data['pid']){
                $plevel=$d->where(array('id'=>$data['pid']))->getField('level');
                $data['level']=$plevel+1;
            }else{
                $data['level']=0;
            }
            if($_FILES['img']['size']>0){
                $img=uploadPicThumb($data['id'],$_FILES['img'],'page');
                $data['img']       =$img['origin_'];
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

                $this->success('编辑成功',U('/Admin/Type/index'));
                cacheType(0);
            }else{
                $this->error('编辑失败');
            }
        }else{
            $d=D('Type');
            $this->row=$d->where(array('id'=>I('get.id')))->find();
            $this->select=A('Communal/Type')->getOptionById(0,$this->row['pid']);
            $this->display();
        }
    }

    //查看班级ID是否存在
    public function checkclassid(){ 
        if(IS_POST){
            $class_id=I('class_id');
            $d=D('Type');
            if($d->where(array('class_id'=>$class_id))->select()){
                $this->success('该班级ID已存在，可以更改也可以不改，请按需求操作','','',$row);
            }else{
                $this->error('可以使用','','',$row);
            }
        }
    }

    // 删除分类
    public function del(){
        $id=I('post.id');
        $id ? null : exit($this->error('参数错误!'));
        $d = D('Type');
        $child = $d ->where(array('pid'=>$id))->count();

        if($child){
            $d ->where(array('pid'=>$id))->delete();
            // $child ? exit($this->error('存在子分类，不可删除!')) : null;
        }
        
        cacheType(0);

        if($d->delete($id)){

            // 日志记录  start
            $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
            $model=MODULE_NAME;
            $controller=CONTROLLER_NAME;
            $action=ACTION_NAME;
            $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
            if(!$title){$title['title']="暂无规则";}
            D('Log')->addLog($title,$url,$model,$controller,$action);
            // 日志记录  end

            $this->success('删除成功',U('/Admin/Type/index'));
        }else{
            $this->error('删除失败!');
        }
    }

    // 分类列表
    public function index(){
        global $user;
        $this->user=$user;
        $type=A('Communal/Type');


        if($_POST['pid_color']){
            $allChildren=$type->getChilds($_POST['pid_color']);
            $allChildrenIds=array();
            foreach ($allChildren as $key => $value) {
                $allChildrenIds[]=$value['id'];
            }
            $list = D('Type')->where(array('id'=>array('in',$allChildrenIds)))->select();
        }else{
            $list = D('Type')->select();
        }


        $array = array();
        foreach($list as $k => $r) {
            $r['id']      = $r['id'];
            $r['submenu'] = "<a href='javascript:void(0)' data-pid=\"".$r['id']."\" data-title=\"".$r['title']."\" data-level=\"".$r['level']."\" class=\"_add\">添加子分类</a>";
            $r['edit']    = "<a href='".U('/Admin/Type/edit/id/'.$r['id'].'/pid/'.$r['pid'])."'>修改</a>";
            $r['del']     = "<a class='del' data-id='".$r['id']."' href='javascript:void(0)'>删除</a>";
            $array[]      = $r;
        }

        $str  = "<tr class='tr'>
                    <td class='center'>
                        <input type='text' class='sort_input' data-id='\$id' value='\$sort' size='2' name='sort[\$id]'>
                    </td>
                    <td>\$id</td>
                    <td class='hidden-480'>\$spacer \$title</td>
                    <td>\$level</td>
                    <td>
                        <button class='btn btn-xs btn-success'>\$submenu
                            <i class='icon-ok bigger-120'></i>
                        </button>

                        <button class='btn btn-xs btn-info'>\$edit
                            <i class='icon-edit bigger-120'></i>
                        </button>

                        <button class='btn btn-xs btn-danger'>\$del
                            <i class='icon-trash bigger-120'></i>
                        </button>
                    </td>
                </tr>";
        $Tree = new \Common\Extend\Tree();
        $Tree->icon = array('│ ','├─ ','└─ ');
        $Tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;';
        $Tree->init($array);

        if($_POST['pid_color']){
            $html_tree = $Tree->get_tree($_POST['pid_color'], $str);
        }else{
            $html_tree = $Tree->get_tree(0, $str);
        }

        $this->assign('html_tree',$html_tree);
        $this->select=$type->getOptionById(0,$_POST['pid_color']);
        $this->cur_v='Type-index';
        $this->display();
    }

    // 分类排序
    public function sort(){
        $sorts = I('post.sort');
        is_array($sorts) ?  null : exit($this->error('参数错误!'));
        $d=D('Type');
        foreach ($sorts as $id => $sort) {
            $d->save( array('id' =>$id , 'sort' =>intval($sort) ) );
        }
        cacheType(0);

        $this->success('更新完成',U('/Admin/Type/index'));
    }


    
    public function ajax_sort(){
        $id=$_POST['id'];
        $sort=$_POST['sort'];

        $d=D('Type');
        
        if($id&&$sort){
            $res=$d->save( array('id' =>$id , 'sort' =>intval($sort) ) );

            if($res){
                $data=array();
                $data['code']=0;
                $data['msg']='success';
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }


            echo json_encode($data);
        }
    }
   

}

?>