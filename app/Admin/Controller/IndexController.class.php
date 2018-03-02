<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class IndexController extends AuthController {

    public function _initialize() {
        parent::_initialize();

        global $user;
        $user=session('auth');
        $this->user=$user;
    }
    
    /**
     * @cc 平台首页
     */
    public function index(){
        global $user;
       
        $this->display();  
    }

    /**
     * @cc 上传图片--不对图进行任何处理
     */
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

    /**
     * @cc 上传图片--生成三种大小的图片
     */
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

    /**
     * @cc 上传图片--前端所有上传文件都用这个
     */
    public function lay_upload_img(){
        global $user;

        $get_file=$_FILES;
        if($get_file['file_B_Picture']['size']>0||$get_file['file_P_Picture']['size']>0||$get_file['img_0']['size']>0||$get_file['img_2']['size']>0||$get_file['sfz_1']['size']>0||$get_file['sfz_2']['size']>0||$get_file['images']['size']>0){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728000 ;// 设置附件上传大小
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
                if($get_file['file_B_Picture']['size']>0){
                    $img=$info['file_B_Picture']['savename'];
                }
                if($get_file['file_P_Picture']['size']>0){
                    $img=$info['file_P_Picture']['savename'];
                }
                if($get_file['img_0']['size']>0){
                    $img=$info['img_0']['savename'];
                }
                if($get_file['img_2']['size']>0){
                    $img=$info['img_2']['savename'];
                }
                if($get_file['sfz_1']['size']>0){
                    $img=$info['sfz_1']['savename'];
                }
                if($get_file['sfz_2']['size']>0){
                    $img=$info['sfz_2']['savename'];
                }
                if($get_file['images']['size']>0){
                    $img=$info['images']['savename'];
                }

                $img_url='/Uploads/layui/'.$img;

                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']["src"]=$img_url;

                //上传到阿里云OSS
                // oss_upload( '/Uploads/layui/'.$img );
            }

            echo json_encode($data);
        }

        
    }

    /**
     * @cc 上传文件
     */
    public function lay_upload_file(){
        global $user;

        if($_FILES['file']['size']>0){
            $upload = new \Think\Upload();// 实例化上传类               
            $upload->maxSize   =     314572800000 ;// 设置附件上传大小
            $upload->exts      =     array('zip', 'rar', 'xls','xlsx', 'doc','docx','ppt','pptx','pdf','jpg','png','jpeg','gif','mp4','mp3','wav','wma');// 设置附件上传类型
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
                $file=$info['file']['savename'];
                $file_url='/Uploads/layui/'.$file;

                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']["src"]=$file_url;

                //上传到阿里云OSS
                // oss_upload( './Uploads/layui/'.$file );
            }

            echo json_encode($data);
        }
        
        
    }

    public function hdjs(){
        $this->display();
    }
}