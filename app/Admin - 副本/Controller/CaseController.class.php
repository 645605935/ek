<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class CaseController extends AuthController {
    
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Case';
    }

    //任务场景列表
    public function index(){
        global $user;

        $d =D('Case');
        $map=array();
        $map['status']=array('neq',-1);

        if(IS_POST){
            $_POST['title']?$map['title']=array('like',"%".$_POST['title']."%"):null;
            $_POST['status']?$map['status']=$_POST['status']:null;
            $this->title=$_POST['title'];
            $this->status=$_POST['status'];
        }
        
        $list = $d->order('id desc')->relation(true)->order('sort desc')->where($map)->select();
        $this->assign('list',$list);
        $this->cur_v='Case-index';
        $this->display();
    }

    // 添加任务场景(((((())))))单文件添加模式
    public function add(){
        global $user;

        if(IS_POST){
            if(!$_POST['title']){$this->error('任务场景名称不能为空');exit;};
            $d=D('Case');

            $data['title']      =I('title');
            $data['text']       =I('text');
            $data['cid']        =I('cid');
            $data['status']     =0;
            $data['create_time']=NOW_TIME;
            $data['creater']    =$user['uid'];
            $data['edit_time']  =NOW_TIME;
            $data['editer']     =$user['uid'];
            $data['time']       =NOW_TIME;

            if($id=$d->add($data)){
                if($_FILES['img']['size']>0){

                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =     31457280 ;// 设置附件上传大小
                    $upload->exts      =     array('zip', 'rar', 'xls','xlsx', 'doc','docx','ppt','pptx','pdf','jpg','png','jpeg','gif');// 设置附件上传类型
                    $upload->uploadReplace  = false;// 存在同名文件是否覆盖
                    $upload->autoSub   =     false;//是否启用子目录保存
                    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
                    $upload->savePath  =     'case/'; // 设置附件上传（子）目录
                    $upload->saveRule  =     ''; // 设置附件上传（子）目录
                     
                    // 上传文件 
                    $info   =   $upload->upload();
                    if(!$info) {// 上传错误提示错误信息
                        $this->error($upload->getError());
                    }else{
                        $update['img']=$info['img']['savename'];
                        $update['id']=$id;
                        $d->save($update);
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

                $this->success('添加成功',U('Admin/Case/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $courses=D('Course')->where(array('status'=>1))->select();
            $this->courses=$courses;
            $this->cur_v='Case-add';
            $this->display();
        }
    }

    // 添加任务场景((((())))))多文件添加模式
    public function add_files(){
        global $user;
        $this->user=$user;

        if(IS_POST){
            
            if(!$_POST['title']){$this->error('任务场景名称不能为空');exit;};
            $d=D('Case');
            
            $data['title']      =I('title');
            $data['text']       =I('text');
            $data['cid']        =I('cid');
            $data['status']     =0;
            $data['create_time']=NOW_TIME;
            $data['creater']    =$user['uid'];
            $data['edit_time']  =NOW_TIME;
            $data['editer']     =$user['uid'];
            $data['time']       =NOW_TIME;

            if($id=$d->add($data)){

                if($_FILES['img']['size'][0]>0){

                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize   =     31457280 ;// 设置附件上传大小
                    $upload->exts      =     array('zip', 'rar', 'xls','xlsx', 'doc','docx','ppt','pptx','pdf','jpg','png','jpeg','gif');// 设置附件上传类型
                    $upload->uploadReplace  = false;// 存在同名文件是否覆盖
                    $upload->autoSub   =     false;//是否启用子目录保存
                    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
                    $upload->savePath  =     'case/'; // 设置附件上传（子）目录
                    $upload->saveRule  =     ''; // 设置附件上传（子）目录
                     
                    $info   =   $upload->upload();

                    if(!$info) {// 上传错误提示错误信息
                        $this->error($upload->getError());
                    }else{
                        foreach ($info as $k => $v) {
                            $files[]=$v['savename'];
                        }
                    }

                    $update['img']=implode('#', $files);
                    $update['id']=$id;
                    if($d->save($update)){

                    }else{
                        $this->error('上传文件保存失败');  
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

                $this->success('添加成功',U('Admin/Case/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $courses=D('Course')->where(array('status'=>1))->select();
            $this->courses=$courses;
            $this->cur_v='Case-add_files';
            $this->display();
        }
    }

    // 编辑任务场景
    public function edit(){
        global $user;
        $this->user=$user;
        
        if(IS_POST){
            if(!$_POST['title']){$this->error('任务场景名称不能为空');exit;};
            $d=D('Case');
            $data['id']  =I('id');   

            $data['title']      =I('title');
            $data['text']       =I('text');
            $data['cid']       =I('cid');
            $data['edit_time']  =NOW_TIME;
            $data['editer']     =$user['id'];

            if($_FILES['img']['size']>0){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     31457280 ;// 设置附件上传大小
                $upload->exts      =     array('zip', 'rar', 'xls','xlsx', 'doc','docx','ppt','pptx','pdf','jpg','png','jpeg','gif');// 设置附件上传类型
                $upload->uploadReplace  = false;// 存在同名文件是否覆盖
                $upload->autoSub   =     false;//是否启用子目录保存
                $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
                $upload->savePath  =     'case/'; // 设置附件上传（子）目录
                $upload->saveRule  =     ''; // 设置附件上传（子）目录
                 
                // 上传文件 
                $info   =   $upload->upload();
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{
                    $data['img']=$info['img']['savename'];
                }
            }else{
                unset($data['img']);
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

            if($d->save($data)){
                $this->success('编辑成功',U('Admin/Case/index'));
            }else{
                $this->error('编辑失败');
            }
            
        }else{
            $courses=D('Course')->where(array('status'=>1))->select();
            $this->courses=$courses;

            $this->row=D('Case')->where('id='.$_GET['id'])->find();
            $this->cur_v='Case-edit';
            $this->display();
        }
    }

    // 异步获取课程数据
    public function ajaxGetCase(){ 
        if(IS_POST){
            $id = $_POST['id'];
            $row=D('Case')->find($id);
            $row['text']=htmlspecialchars_decode($row['text']);
     
            echo json_encode($row);
        }
    }

    //发布任务场景
    public function publish(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $map['status']='1';
                $result=M('Case')->save($map);
            }else{
                $map['id'] = $ids;
                $map['status']='1';
                $result=M('Case')->save($map);
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

            $txt='发布成功';
        }else{
            $txt='发布失败';
        }
        echo json_encode(array('txt'=>$txt));
    }

    // 撤销任务场景发布
    public function cancel(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $map['status']='0';
                $result=M('Case')->save($map);
            }else{
                $map['id'] = $ids;
                $map['status']='0';
                $result=M('Case')->save($map);
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

            $txt='撤销发布成功';
        }else{
            $txt='撤销发布失败';
        }
        echo json_encode(array('txt'=>$txt));
    }

    // 排序单个记录
    public function resetsort(){
        if($id=I('post.id')){
            
            $map['id'] = $id;
            $map['sort']=I('post.sort');
            $result=M('Case')->save($map);

            // 日志记录  start
            $url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
            $model=MODULE_NAME;
            $controller=CONTROLLER_NAME;
            $action=ACTION_NAME;
            $title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
            if(!$title){$title['title']="暂无规则";}
            D('Log')->addLog($title,$url,$model,$controller,$action);
            // 日志记录  end

            $txt='排序成功';
        }else{
            $txt='排序失败';
        }
        echo json_encode(array('txt'=>$txt));
    }

    // 删除任务场景
    public function del(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $map['status']='-1';
                $result=M('Case')->save($map);
            }else{
                $map['id'] = $ids;
                $map['status']='-1';
                $result=M('Case')->save($map);
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

    // 下载文件
    public function download(){
        $id=I('id');
        $row=D('Case')->find($id);
        if($row){
            $filename=$row['img'];
            $cur_file_url=dirname(dirname(dirname(dirname(__FILE__))))."/Uploads/case/";
            
            $file=$cur_file_url.$filename;

            $this->download_file($file);
        }else{
            $this->error('文件不存在');
        }
    }


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
                $data['msg']='上传成功';
                $data['data']='/layui/'.$img;
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
}

?>