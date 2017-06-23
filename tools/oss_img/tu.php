<?php

require_once 'oss_php_sdk/sdk.class.php';

function saveImage($info, $data, $length, $bucket) {
    //$key = md5(time().$info['name']);
    $key = substr($info['name'], 0, strlen(strrchr($info['name'], '.')) * -1);
    if ($info['type'] == 'image/gif') {
        $key = $key . '.gif';
    } else if (in_array($info['type'], array('image/jpeg', 'image/pjpeg'))) {
        $key = $key . '.jpg';
    } else {
        $key = $key . '.png';
    }
    $object = $key;
    $upload_file_options = array('content' => $data, 'length' => $length);
//  print_r($upload_file_options);
    $oss_sdk_service = new ALIOSS();

    $upload_file_by_content = $oss_sdk_service->upload_file_by_content($bucket, $object, $upload_file_options);
    if ($upload_file_by_content->body) {
        return array("code" => -1, "content" => $upload_file_by_content->body);
    } else {
        return array("code" => 1, "key" => $key);
    }
}
