<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class LogController extends AuthController {
	
    public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Log';
    }

    //日志列表
    public function index(){
        global $user;
        $this->user=$user;

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
        $this->cur_v='Log-index';
        $this->display();  
    }


    // 异步获取课程数据
    public function ajaxGetLog(){ 
        if(IS_POST){
            $cid = $_POST['cid'];
            $row=D('Log')->find($cid);
            $row['text']=htmlspecialchars_decode($row['text']);

            switch ($row['status']) {
                case '1':
                    $row['status']='已生效';
                    break;
                case '2':
                    $row['status']='已暂停';
                    break;
                case '3':
                    $row['status']='已停用';
                    break;
                
                default:
                    $row['status']='';
                    break;
            }
            echo json_encode($row);
        }
    }

    //删除
    public function del(){
        if($ids=I('post.ids')){
            if(is_array($ids)){
                $map['id']=array('in',implode(',', $ids ));
                $result=M('Log')->where($map)->delete();
                foreach ($ids as  $id) {
                    $dir=STATIC_PATH.filePath2($id,'Log');
                    delDir( $dir );
                }
            }else{
                $map['id'] = $ids;
                $result=M('Log')->where($map)->delete();
                $dir=STATIC_PATH.filePath2($ids,'Log');
                delDir( $dir );
            }
            $txt='删除成功';
        }else{
            $txt='删除失败';
        }
        echo json_encode(array('txt'=>$txt));
    }
}

?>