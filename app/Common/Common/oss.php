<?php
    // 返回json 
    function backJson($code,$info){ 
        $arr['status']=$code; 
        $arr['info']=$info; 
        print_r(json_encode($arr)); 
        exit; 
    } 
     
    //oss上传 
    /* 
     *$fFiles:文件域 
     *$n：上传的路径目录 
     *$ossClient   
     *$bucketName 
     *$web:oss访问地址 
     *$isThumb:是否缩略图 
     */ 
    function ossUpPic($fFiles,$n,$ossClient,$bucketName,$web,$isThumb=0){ 
        $fType=$fFiles['type']; 
        $back=array( 
            'code'=>0, 
            'msg'=>'', 
        ); 
        if(!in_array($fType, C('oss_exts'))){ 
            $back['msg']='文件格式不正确'; 
            return $back; 
            exit; 
        } 
        $fSize=$fFiles['size']; 
        if($fSize>C('oss_maxSize')){ 
            $back['msg']='文件超过了1M'; 
            return $back; 
            exit; 
        } 
         
        $fname=$fFiles['name']; 
        $ext=substr($fname,stripos($fname,'.')); 
         
        $fup_n=$fFiles['tmp_name']; 
        $file_n=time().'_'.rand(100,999); 
        $object = $n."/".$file_n.$ext;//目标文件名 
         
     
        if (is_null($ossClient)) exit(1);     
        $ossClient->uploadFile($bucketName, $object, $fup_n); 
        if($isThumb==1){ 
            // 图片缩放，参考https://help.aliyun.com/document_detail/44688.html?spm=5176.doc32174.6.481.RScf0S  
            $back['thumb']= $web.$object."?x-oss-process=image/resize,h_300,w_300"; 
        }     
        $back['code']=1; 
        $back['msg']=$web.$object; 
        return $back; 
        exit;     
    }
?>