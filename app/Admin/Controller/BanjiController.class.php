<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class BanjiController extends AuthController {

	public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Banji';

        $group=M('auth_group')->where(array('pid'=>0))->select();
        foreach ($group as $key => $value) {
            $group[$key]['_child']=M('auth_group')->where(array('pid'=>$value['id']))->select();
        }
        $this->group=$group;
    }

    //线尾检测
    public function index_1(){
        global $user;
        $this->cur_v='Banji-index_1';

        $page="Card/index_1";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //
    public function index_2(){

        if(!$_POST){
            $_POST['start']=date("Y-m-d 08:30:00");
            $_POST['end']=date('Y-m-d 08:30:00',strtotime("+1 day"));
            $this->_POST=$_POST;
        }
        





        global $user;
        $this->cur_v='Banji-index_2';

        $page="Card/index_2";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;

        $this->display();
    }

    //线尾检测
    public function index_3(){
        global $user;
        $this->cur_v='Banji-index_3';

        $page="Card/index_3";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;


        $this->display();
    }

    //线尾检测
    public function index_3_2(){
        global $user;
        $this->cur_v='Banji-index_3_2';
        $this->display();
    }

    //线尾检测
    public function index_3_3(){
        global $user;
        $this->cur_v='Banji-index_3_3';
        $this->display();
    }

    //成品库存
    public function index_4(){
        global $user;
        $this->cur_v='Banji-index_4';

        $page="Card/index_4";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }

    //线尾图片
    public function index_5(){
        global $user;
        $this->cur_v='Banji-index_5';

        $page="Card/index_5";
        $page_buttons=M('PageButtons')->where(array('page'=>$page))->select();
        $this->page_buttons=$page_buttons;
        $this->page=$page;
        
        $this->display();
    }


    // 上传图片
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