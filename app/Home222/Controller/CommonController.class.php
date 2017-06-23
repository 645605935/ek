<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {

    function _initialize() {
        header("Content-type: text/html; charset=utf-8");
        $assignArr = array(
            "control" => strtolower(CONTROLLER_NAME),
            "mod" => strtolower(ACTION_NAME)
        );
        $this->assign($assignArr);
    }

}
