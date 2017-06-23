<?php
namespace Communal\Controller;
use Think\CommonController;
class UploadifyController extends CommonController{
    public function upload()
    {
        $targetFolder = STATIC_PATH.$_GET['folder'].'/'; // Relative to the root
        createFolders($targetFolder);
        //$verifyToken = md5('unique_salt' . $_POST['timestamp']);
        if (!empty($_FILES) ) {//&& $_POST['token'] == $verifyToken
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png','html','js','css','swf'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            //时间戳加随机数
            $filename=time().rand(10000,99999).'.'.$fileParts['extension'];
            $targetFile = $targetFolder. $filename;
                        
            if (in_array($fileParts['extension'],$fileTypes)) {
                if(move_uploaded_file($tempFile,$targetFile))
                {
                      echo json_encode(array(
                        'status'=>1,
                        'path'=>$targetFile
                        ));
                }else{
                    echo 'move faild'.$tempFile;
                }
            } else {
                echo 'Invalid file type.';
            }

        }else{
            echo 'what!';
        }
    }


}