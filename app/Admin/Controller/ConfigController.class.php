<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class ConfigController extends AuthController {
	
	public function _initialize() {
        parent::_initialize();
        global $user;
        $user=session('auth');
        $this->user=$user;
        $this->cur_c='Config';
    }
    
    public function setting(){
    	global $user;
        $this->user=$user;
        
		$config=cacheConfig();
		if(IS_POST){
			$d=D('Config');
			$data=$d->create();
			if($_FILES['logo']['size']>0){
				$img=eUpload(1,$_FILES['logo'],'config');
                $data['logo']	=$img['url'];
			}else{
				unset($data['logo']);
			}
            if($d->save($data)){
            	cacheConfig(0);
            	$this->success('修改成功');
            }else{
            	$this->error('修改失败');
            }
		}else{
			$this->assign('config',$config);

			$this->assign('cur_c','Config');
			$this->assign('cur_v','setting');
			$this->cur_v='Config-setting';
			$this->display();
		}
    }
}