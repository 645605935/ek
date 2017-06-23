<?php
header("Content-type: text/html; charset=utf-8");
if ($_FILES) {
    require_once 'tu.php';
    $bucket = "jishanstore-upload";   //这里修改成您的bucket名称
    foreach ($_FILES as $info) {
        $tmp_file = $info['tmp_name'];
        if (in_array($info['type'], array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png')) && $info['size'] / 1024 / 1024 <= 4) {
            $fh = fopen($tmp_file, "r");
            $data = fread($fh, filesize($tmp_file));
            $length = filesize($tmp_file);
            fclose($fh);
            $info['name'] = time() . "." . get_extension($info['name']); //自定义图片名称
            $rs = saveImage($info, $data, $length, $bucket);
            if($rs['code'] == 1){
                echo "<img src='http://" . $bucket . ".oss.aliyuncs.com/" . $info['name'] . "'>";
            }else{
                echo "错误信息："."<span style='color:red'>".$rs['content']."</span>";
            }
            
        } else {
            echo '请上传文件！';
        }
    }
    echo "<a onclick='history.go(-1)' style='color:blue;cursor:pointer'>返回</a>";
}

function get_extension($file) {
    $type = strtolower(substr(strrchr($file, '.'), 1));
    return $type;
}
