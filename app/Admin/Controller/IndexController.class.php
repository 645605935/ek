<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class IndexController extends AuthController {

    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Index';
    }
    
    public function index(){
        global $user;

        $d =D('Log');
        $map=array();

        // 查询条件
        if(IS_POST){
            $date_range=explode(' - ', $_POST['date-range-picker']);

            $start_time=strtotime($date_range[0]);
            $end_time=strtotime($date_range[1]);

            if($_POST['date-range-picker']){
                $where['time']=array('between',array($start_time,$end_time));
            }

            if($_POST['username']){
                $where['username']=array('like',"%".$_POST['username']."%");
            }

            $_POST['controller']?$map['controller']=$_POST['controller']:null;
            $_POST['action']?$map['action']=$_POST['action']:null;

            $this->username=$_POST['username'];
            $this->date_range_str=$_POST['date-range-picker'];
            $this->controller=$_POST['controller'];
            $this->action=$_POST['action'];
        }

        $list = $d->order('id desc')->where($map)->select();

        $this->assign('list',$list);
        $this->cur_v='Index-index';
        $this->display();  
    }

    public function tables(){
        global $user;

        $d =D('Log');
        $map=array();

        // 查询条件
        if(IS_POST){
            $date_range=explode(' - ', $_POST['date-range-picker']);

            $start_time=strtotime($date_range[0]);
            $end_time=strtotime($date_range[1]);

            if($_POST['date-range-picker']){
                $where['time']=array('between',array($start_time,$end_time));
            }

            if($_POST['username']){
                $where['username']=array('like',"%".$_POST['username']."%");
            }

            $_POST['controller']?$map['controller']=$_POST['controller']:null;
            $_POST['action']?$map['action']=$_POST['action']:null;

            $this->username=$_POST['username'];
            $this->date_range_str=$_POST['date-range-picker'];
            $this->controller=$_POST['controller'];
            $this->action=$_POST['action'];
        }

        $list = $d->order('id desc')->where($map)->select();

        $this->assign('list',$list);
        $this->cur_v='Index-tables';
        $this->display();  
    }

    //layui编辑器
    public function layui_editer(){
        $d=M('Config');
        $this->editer = $d->where(array('id'=>1))->getField('editer');
        $this->display();
    }

    //ace编辑器
    public function ace_editer(){
        $d=M('Config');
        $this->editer = $d->where(array('id'=>1))->getField('editer');
        $this->display();
    }

    //百度编辑器
    public function baidu_editer(){
        $d=M('Config');
        $this->editer = $d->where(array('id'=>1))->getField('editer');
        $this->display();
    }

    // 编辑器处理
    public function save_editer(){
        if($_POST){
            $d=M('Config');
            $data=array();
            $data['time']   =NOW_TIME;
            $data['editer'] =$_POST['editer'];

            $res    = $d->where(array('id'=>1))->save($data);
            $editer = $d->where(array('id'=>1))->getField('editer');

            if($res){
                $this->success('success');
            }else{
                $this->error('error');
            }
        }
    }


    // 编辑器处理
    public function ajax_save_editer(){
        $_json=file_get_contents('php://input');
        $_arr=json_decode($_json,true);

        if($_arr){
            $d=M('Config');
            $data=array();
            $data['time']   =NOW_TIME;
            $data['editer'] =$_arr['_editer'];

            $res    = $d->where(array('id'=>1))->save($data);
            $editer = $d->where(array('id'=>1))->getField('editer');

            if($res){
                $data=array();
                $data['code']=0;
                $data['msg']='success';
                $data['data']=$editer;
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
        }else{
            $data=array();
            $data['code']=2;
            $data['msg']='error';
        }

        echo json_encode($data);
    }

    public function add_1(){
        global $user;
        $this->cur_v='Index-add_1';
        $this->display();
    }

    public function add_2(){
        global $user;
        $this->cur_v='Index-add_2';
        $this->display();
    }

    public function add_3(){
        global $user;
        $this->cur_v='Index-add_3';
        $this->display();
    }

    public function add_4(){
        global $user;
        $this->cur_v='Index-add_4';
        $this->display();
    }

    public function alarm_list(){
        global $user;
        $this->cur_v='Index-alarm_list';
        $this->display();
    }

    public function add_repair(){
        global $user;
        $this->cur_v='Index-add_repair';
        $this->display();
    }

    public function repair_list(){
        global $user;
        $this->cur_v='Index-repair_list';
        $this->display();
    }

    public function edit(){
        global $user;
        $this->cur_v='Index-edit';
        $this->display();
    }

    public function jqgrid(){
        global $user;
        $this->cur_v='Index-jqgrid';
        $this->display();
    }

    public function dummy(){
    	dump($_POST);die;
    	
        global $user;
        $this->cur_v='Index-jqgrid';
        $this->display();
    }

    


    public function left(){

        $pid = I('id',intval,0);    //选择子菜单

        $NodeDB = D('Node');

        $datas = $this->left_child_menu($pid);

        $parent_info = $NodeDB->getNode(array('id'=>$pid),'title');

        $sub_menu_html = '<dl>'; 

        foreach($datas as $key => $_value) {
            $sub_array = $this->left_child_menu($_value['id']);
            $sub_menu_html .= "<dt><a target='_self' href='#' onclick=\"showHide('{$key}');\">{$_value[title]}</a></dt><dd><ul id='items{$key}'>";
            if(is_array($sub_array)){
                foreach ($sub_array as $value) {
                    $href = empty($value['data']) ? 'javascript:void(0)' : $value['data'];
                    $sub_menu_html .= "<li><a id='a_{$value[id]}' onClick='sub_title({$value[id]})' href='{$href}'>{$value[title]}</a></li>";
                }
            }

          $sub_menu_html .=  '</ul></dd>';

        }

        $sub_menu_html .= '</dl>';

        $this->assign('sub_menu_title',$parent_info['title']);

        $this->assign('sub_menu_html',$sub_menu_html);
        $this->cur_v='Index-left';
        $this->display();
    }



    /**
     * 按父ID查找菜单子项
     * @param integer $parentid   父菜单ID  
     * @param integer $with_self  是否包括他自己
     */

    private function left_child_menu($pid, $with_self = 0) {

        $pid = intval($pid);



        $username = session('username');    // 用户名

        $roleid   = session('roleid');      // 角色ID

        if($username == C('SPECIAL_USER')){     //如果是无视权限限制的用户，则获取所有主菜单

            $sql = "SELECT `id`,`data`,`title` FROM `".C('DB_PREFIX')."node` WHERE ( `status` =1 AND `display`=2 AND `level` <>1 AND `pid`=$pid ) ORDER BY sort DESC";

        }else{

            $sql = "SELECT `".C('DB_PREFIX')."node`.`id` as `id` , `".C('DB_PREFIX')."node`.`data` as `data`, `".C('DB_PREFIX')."node`.`title` as `title` FROM `".C('DB_PREFIX')."node`,`".C('DB_PREFIX')."access` WHERE `".C('DB_PREFIX')."node`.id = `".C('DB_PREFIX')."access`.node_id AND `".C('DB_PREFIX')."access`.role_id = $roleid AND `".C('DB_PREFIX')."node`.`pid` =$pid AND `".C('DB_PREFIX')."node`.`status` =1 AND `".C('DB_PREFIX')."node`.`display` =2 AND `".C('DB_PREFIX')."node`.`level` <>1 ORDER BY `".C('DB_PREFIX')."node`.sort DESC";
            //这个是去掉权限限制菜单 ，查询所有菜单$sql = "SELECT `id`,`data`,`title` FROM `".C('DB_PREFIX')."node` WHERE ( `status` =1 AND `display`=2 AND `level` <>1 AND `pid`=$pid ) ORDER BY sort DESC";
        }

        $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表

        $result = $Model->query($sql);



        if($with_self) {

            $NodeDB = D('Node');

            $result2[] = $NodeDB->getNode(array('id'=>$pid),`id`,`data`,`title`);

            $result = array_merge($result2,$result);

        }

        return $result;

    }

    

    public function top(){
        $this->cur_v='Index-top';
        $this->display();

    }   

    

    public function main(){
        $this->cur_v='Index-main';
        $this->display();
    }



    public function footer(){
        $this->cur_v='Index-footer';
        $this->display();
    }


    //==============================================================================================================================================
    // 上传图片--不对图进行任何处理
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

    // 上传图片--生成三种大小的图片
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
}