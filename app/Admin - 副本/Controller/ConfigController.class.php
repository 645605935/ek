<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class ConfigController extends AuthController {
	
	public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Config';
    }
    
    public function setting(){
    	global $user;
        $this->user=$user;

		$config=cacheConfig();
		if(IS_POST){
			$d=D('Config');
			$data=$d->create();
			if($_FILES['logo']['size']>0){
				$img=eUpload(1,$_FILES['logo'],'config');
                $data['logo']	=$img['url'];
			}else{
				unset($data['logo']);
			}
            if($d->save($data)){
            	cacheConfig(0);
            	$this->success('修改成功');
            }else{
            	$this->error('修改失败');
            }
		}else{
			$this->assign('config',$config);

			$this->assign('cur_c','Config');
			$this->assign('cur_v','setting');
			$this->cur_v='Config-setting';
			$this->display();
		}
    }


    // 上传图片--不对图进行任何处理
    public function lay_upload_img(){
        if($_FILES['file']['size']>0){
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
                $img=$info['file']['savename'];
                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']["src"]='http://'.$_SERVER['HTTP_HOST'].'/Uploads/layui/'.$img;
            }

            echo json_encode($data);
        }
    }








}