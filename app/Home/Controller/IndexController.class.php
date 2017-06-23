<?php

namespace Home\Controller;

use Think\CommonController;



class IndexController extends CommonController{

    public function _initialize(){

        parent::_initialize();

    }



    // 登录--远程服务器

    public function index(){

        $url = $_SERVER['HTTP_HOST'];

        $temp_school=explode('.baidulab.', $url);

        $school=$temp_school[0];



        $url = $school;

        $this->school=D('School')->where(array('url'=>$url))->find();



        $this->url=$url;



        // 记住我  start

        $password = cookie('remember_password');

        $username = cookie('remember_username');

        $remember = cookie('remember_remember');

        

        if($password && $username){

            $this->assign('password',$password);

            $this->assign('username',$username);

            $this->assign('remember',$remember);

        }

        // 记住我  end

        

        $this->display();

    }



    //是否到期，可否继续登录

    public function ajaxIsCanLogin(){

        if(IS_POST){

            $url = $_SERVER['HTTP_HOST'];

            $temp_school=explode('.baidulab.', $url);

            $url=$temp_school[0];

            $school=D('School')->where(array('url'=>$url))->find();



            if( $school['start_time'] < time() && time() < $school['end_time']){

                $data['status']="1";

            }else{

                $data['status']="1";

            }

            echo json_encode($data);

        }

    }


    //临时接口
    public function isokphone(){
        $phone=$_GET['Phone'];

        if($phone){
            echo 'true';
        }else{
            echo 'false';
        }

        
    }


    //临时接口
    public function oss_img(){
        $this->display();        
    }


    public function upPic(){  
        //oss上传 
        $bucketName = C('OSS_TEST_BUCKET'); 
        $ossClient = new \Org\OSS\OssClient(C('OSS_ACCESS_ID'), C('OSS_ACCESS_KEY'), C('OSS_ENDPOINT'), false); 
        $web=C('OSS_WEB_SITE'); 

        //图片  
        $fFiles=$_FILES['pic_1']; 
        $rs=ossUpPic($fFiles,'s',$ossClient,$bucketName,$web,0); 

        if($rs['code']==1){ 
            //图片  
            $img = $rs['msg']; 
            //如返回里面有缩略图： 
            $thumb=$rs['thumb'];             
        }else{ 
            $this->error('图片有误：'.$rs['msg']); 
            return; 
        }  
    }

    
    //视频上传
    public function plupload_video(){
        $this->display();        
    }

    //ajax视频上传
    public function ajax_plupload_video(){
        $typeArr = array("jpg", "png", "gif", "jpeg", "mov", "gears", "html5", "html4", "silverlight", "flash","mp4"); //允许上传文件格式

        if($username){
            $path = "./Public/plupload_video/uploads/".$username."/"; //上传路径
        }else{
            $path = "./Public/plupload_video/uploads/guest/"; //上传路径
        }

        //PHP判断文件夹是否存在和创建文件夹的方法
        if (!file_exists($path)){
            mkdir($path); 
        }


        if (isset($_POST)) {
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            if (empty($name)) {
                echo json_encode(array("error" => "您还未选择文件"));
                exit;
            }
            //    print_r($_FILES['file']);
            $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
            if (!in_array($type, $typeArr)) {
                echo json_encode(array("error" => "清上传指定类型的文件！","type"=>"types"));
                exit;
            }
            if ($size > (50000 * 1024)) { //上传大小
                echo json_encode(array("error" => "文件大小已超过50000KB！","type"=>"size"));
                exit;
            }

            $pic_name = time() . rand(10000, 99999) . "." . $type; //文件名称
            $pic_url = $path . $pic_name; //上传后图片路径+名称
            if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
                echo json_encode(array("error" => "0", "pic" => $pic_url, "name" => $pic_name));
            } else {
                echo json_encode(array("error" => "上传有误，清检查服务器配置！","type"=>"config"));
            }
        }
    }




}