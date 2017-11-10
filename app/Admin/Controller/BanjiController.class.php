<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class BanjiController extends AuthController {

	public function _initialize() {
        parent::_initialize();
        
        global $user;
        $user=session('auth');
        $this->user=$user;
    }

    /**
     * @cc 料架管理
     */
    public function index_1(){
        global $user;

        $this->display();
    }

    /**
     * @cc 离线检查记录
     */
    public function index_2(){
        global $user;

        $this->display();
    }

    /**
     * @cc 标签打印
     */
    public function index_3(){
        global $user;

        $this->display();
    }

    /**
     * @cc 冲压件库管理
     */
    public function index_4(){
        global $user;

        $this->display();
    }

    /**
     * @cc 检查区域图
     */
    public function index_5(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 零件和料架信息
     */
    public function index_6(){
        global $user;
        
        $this->display();
    }

    /**
     * @cc 上传图片
     */
    public function lay_upload_file(){
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
                $data['data']["src"]='/Uploads/layui/'.$img;
            }

            //上传到阿里云OSS
            // oss_upload( '/Uploads/layui/'.$img );

            echo json_encode($data);
        }
    }


}

?>