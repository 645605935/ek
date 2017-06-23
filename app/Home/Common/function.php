<?php


function getUserid() {
    $s_userid = session('userid');
    if ($s_userid == '') {
        $s_userid = cookie('userid');
        if ($s_userid > 0) {
            $info = M("user")->field("name")->where("id= '" . $s_userid . "'")->find();
            if (!empty($info['name'])) {
                session('username', $info['name']);
                session('userid', $s_userid);
            }
        }
    }
    return $s_userid;
}

function checkEmail($email) {
    if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$", $email)) {
        return false;
    }
    return true;
}
function getNickname($name, $nickname) {
    if (empty($nickname)) {
        $nickname = $name;
    }
    return $nickname;
}


function setSessionCookie($k, $v) {
    session($k, $v);
    cookie($k, $v);
}

function getSessionCookie($k) {
    $s_k = session($k);
    $rs = $s_k ? $s_k : cookie($k);
    return $rs;
}

function emptySessionCookie($k) {
    session($k, null);
    cookie($k, null);
}

function getFieldThreeNamea($field) {
    if ($field == 'sina') {
        $rs = "新浪微博";
    } else if ($field == 'renren') {
        $rs = "人人网";
    } else if ($field == 'qq') {
        $rs = "腾讯微博";
    }
    return $rs;
}


function getParamThree($paramArr) {
    $param = "";
    $i = 0;
    foreach ($paramArr as $k => $v) {
        if ($i > 0) {
            $param .= "&" . $k . "=" . $v;
        } else {
            $param .= $k . "=" . $v;
        }
        $i++;
    }
    return $param;
}


?>
