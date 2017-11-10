<?php
namespace Admin\Controller;
use Common\Controller\AuthController;

class AuthRuleController extends AuthController {

	public function _initialize() {
        parent::_initialize();

        global $user;
        $user=session('auth');
        $this->user=$user;
    }

	/**
     * @cc 列表
     */
	public function index(){
		global $user;

		$AuthRule = D('AuthRule')->getAllAuthRule();

		$array = array();


		// 构建生成树中所需的数据
		foreach($AuthRule as $k => $r) {
			$r['id']      = $r['id'];
			$r['title']   = $r['title'];
			$r['name']    = $r['name'];
			$r['status']  = $r['status']==1 ? '<i class="icon-eye-open" style="color: green;font-size: 28px;"></i>' :'<i class="icon-eye-close" style="color: red;font-size: 28px;"></i>';
			$r['submenu'] = $r['level']==3 ? '<font color="#cccccc">添加子菜单</font>' : "<a href='".U('/Admin/AuthRule/add/pid/'.$r['id'])."'>添加子菜单</a>";
			$r['edit']    = $r['level']==1 ? '<font color="#cccccc">修改</font>' : "<a href='".U('/Admin/AuthRule/edit/id/'.$r['id'].'/pid/'.$r['pid'])."'>修改</a>";
			$r['del']     = $r['level']==1 ? '<font color="#cccccc">删除</font>' : "<a class='del' data-id='".$r['id']."' data-url='".U('/Admin/AuthRule/del/id/'.$r['id'])."' href='javascript:void(0)'>删除</a>";
			$r['is_show']   = $r['is_show'];

			switch ($r['display']) {
				case 0:
					$r['display'] = '不显示';
					break;
				case 1:
					$r['display'] = '主菜单';
					break;
				case 2:
					$r['display'] = '子菜单';
					break;
			}

			switch ($r['level']) {
				case 0:
					$r['level'] = '非节点';
					$r['level_style'] = 'layui-badge layui-bg-gray';
					$r['style'] = 'label label-warning';
					break;
				case 1:
					$r['level'] = '应用';
					$r['level_style'] = 'layui-badge layui-bg-orange';
					$r['style'] = 'label label-danger arrowed-in';
					break;
				case 2:
					$r['level'] = '模块';
					$r['level_style'] = 'layui-badge layui-bg-blue';
					$r['style'] = 'label';
					break;
				case 3:
					$r['level'] = '方法';
					$r['level_style'] = 'layui-badge layui-bg-green';
					$r['style'] = 'label label-success arrowed';
					break;
			}

			if($r['is_show']==1 && $r['level']=='方法'){
				$r['color_class']='tr_red';
			}else{
				$r['color_class']='';
			}

			$array[]      = $r;
		}

		$str  = "<tr level='\$level' id='\$id' is_show='\$is_show' class='\$color_class'>
			<td class='center'>
				<input type='text' data-id='\$id' class='sort_input' value='\$sort' size='2' name='sort[\$id]'>
			</td>
			<td>\$spacer 
				<span class='label label-xlg label-grey arrowed-in-right arrowed-in'>\$title</span>
				<span class='\$style'>\$name</span>
			</td>
			<td class='hidden-480'>
				<span class='\$level_style'>\$level</span>
			</td>
			<td>\$status</td>
			<td class='hidden-480'>
				<span class='label label-sm label-warning'>\$display</span>
			</td>

			<td>
				<div class='visible-md visible-lg hidden-sm hidden-xs btn-group'>
					<button class='btn btn-xs btn-success'>\$submenu
						<i class='icon-ok bigger-120'></i>
					</button>

					<button class='btn btn-xs btn-info'>\$edit
						<i class='icon-edit bigger-120'></i>
					</button>

					<button class='btn btn-xs btn-danger'>\$del
						<i class='icon-trash bigger-120'></i>
					</button>
				</div>
			</td>
		</tr>";

  		$Tree = new \Common\Extend\Tree();
		$Tree->icon = array('│ ','├─ ','└─ ');
		$Tree->nbsp = '&nbsp;&nbsp;';
		$Tree->init($array);

		if($_POST['pid_color']){
            $html_tree = $Tree->get_tree($_POST['pid_color'], $str);
        }else{
            $html_tree = $Tree->get_tree(0, $str);
        }


        if($_POST['pid_color']){
        	$module_row=M('AuthRule')->where(array('pid'=>$_POST['pid_color']))->find();

        	$already_list=M('AuthRule')->where(array('pid'=>$module_row['id']))->distinct(true)->field('name')->select();
        	$already_arr=array();
        	foreach ($already_list as $key => $value) {
        		$already_arr[]=$value['name'];
        	}

        	$module='Admin';
        	$controller=$module_row['name'];
        	$actions = $this->getAction($module, $controller);

        	$action_list=array();
        	foreach ($actions as $key => $value) {
        		$temp_name=$module."/".$controller."/".$value;
        		if(in_array($temp_name, $already_arr)){
        			$action_list[$key]['status']=1;
        		}else{
        			$action_list[$key]['status']=0;
        		}
        		$action_list[$key]['name']=$temp_name;
        		$action_list[$key]['action']=$value;
        		$action_list[$key]['desc_cc']=$this->get_cc_desc($module, $controller, $value);
        	}
        	$this->assign('action_list',$action_list);
        }
        

		$this->assign('html_tree',$html_tree);
		$this->select=M('AuthRule')->where(array('pid'=>1))->select();
		
		$this->display();
	}

	/**
     * @cc 添加
     */
	public function add(){
		global $user;
        $this->user=$user;

		if(IS_POST) {
			// dump($_POST);die;
			$db = M("AuthRule");
			if($db->create()){
				if($db->add()){

					// 日志记录  start
					$url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
					$model=MODULE_NAME;
					$controller=CONTROLLER_NAME;
					$action=ACTION_NAME;
					$title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
					if(!$title){$title['title']="暂无规则";}
					D('Log')->addLog($title,$url,$model,$controller,$action);
					// 日志记录  end

    				$this->success('添加成功');
				}else{
					 $this->error('添加失败');
				}
			}else{
				$this->error($db->getError());
			}

		}else{

			$AuthRule = D('AuthRule')->getAllAuthRule();

			$pid = I('pid','intval',0);	//选择子菜单

			$array = array();

			foreach($AuthRule as $k => $r) {

				$r['id']         = $r['id'];

				$r['title']      = $r['title'];

				$r['name']       = $r['name'];

				$r['disabled']   = $r['level']==3 ? 'disabled' : '';

				$array[$r['id']] = $r;

			}

			$str  = "<option value='\$id' \$selected \$disabled >\$spacer \$title</option>";

			$Tree = new \Common\Extend\Tree();

			$Tree->init($array);

			$select_categorys = $Tree->get_tree(0, $str, $pid);

			

			$this->assign('select_categorys',$select_categorys);
			$this->cur_v='AuthRule-index';


			//添加非节点，模块，方法
			$____Row=M('AuthRule')->where(array('id'=>$_GET['pid']))->find();
			if($____Row['level']==1){
				//添加非节点
				$this->assign('header_title','添加非节点');
				$this->assign('child_menu',3);
			}elseif($____Row['level']==0){
				//添加模块
				$this->assign('header_title','添加模块');
				$this->assign('title',$____Row['title']);
				$this->assign('name',$____Row['name']);
				$this->assign('child_menu',1);
			}elseif($____Row['level']==2){
				//添加方法
				$this->assign('header_title','添加方法');
				$this->assign('child_menu',2);
				//为添加权限方便
				$modules = array('Admin');  //当前模块名称
				$_cur_controller=$____Row['name'];  //当前控制器名称

		        $i = 0;
		        foreach ($modules as $module) {
		            // $all_controller = $this->getController($module);
		            $all_controller = array($_cur_controller);
		            foreach ($all_controller as $controller) {
		                $controller_name = $controller;
		                $all_action = $this->getAction($module, $controller_name);

		                foreach ($all_action as $action) {
		                	if($action){

		                		$desc_cc = $this->get_cc_desc($module, $controller_name, $action);

		                		$_temp_title=$module . '/' . $controller . '/' . $action;
		                		$data[$i] = array(
		                		    'name' => $_temp_title,
		                		    'short_name' => $action,
		                		    'desc_cc' => $desc_cc
		                		);

		                		//如果已经添加
		                		if($temp_row=M('AuthRule')->where(array('name'=>$_temp_title))->find()){
		                			if($temp_row['title']==$desc_cc){
		                				$data[$i]['is_same'] = 1;
		                			}else{
		                				$data[$i]['is_same'] = 0;
		                			}
		                			$data[$i]['status'] = 1;
		                			$data[$i]['title'] = $temp_row['title'];
		                			$data[$i]['id'] = $temp_row['id'];
		                		}else{
		                			$data[$i]['status'] = 0;
		                		}
		                		$i++;
		                	}
		                }
		            }
		        }
		        $this->assign('all_functions',$data);
			}


			$this->display();
		}
	}

	/**
     * @cc 编辑
     */
	public function edit(){
		global $user;
        $this->user=$user;


        
		$db = D('AuthRule');
		if(IS_POST) { 
			// dump($_POST);die;
			if($db->create()){
				if($db->save()){

					// 日志记录  start
					$url = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
					$model=MODULE_NAME;
					$controller=CONTROLLER_NAME;
					$action=ACTION_NAME;
					$title = D('AuthRule')->field('title')->where(array('name'=>$url))->find();
					if(!$title){$title['title']="暂无规则";}
					D('Log')->addLog($title,$url,$model,$controller,$action);
					// 日志记录  end
					
    				$this->success('编辑成功');
				}else{
					 $this->error('编辑失败');
				}
			}else{
				$this->error($db->getError());
			}
		}else{
			$id = I('id','intval',0);
			$pid = I('pid','intval',0);	//选择子菜单

			if(!$id || !$pid)$this->error('参数错误!');

			$allAuthRule = $db->getAllAuthRule();

			$array = array();

			foreach($allAuthRule as $k => $r) {

				$r['id']         = $r['id'];

				$r['title']      = $r['title'];

				$r['name']       = $r['name'];

				$r['disabled']   = $r['level']==3 ? 'disabled' : '';

				$array[$r['id']] = $r;

			}

			$str  = "<option value='\$id' \$selected \$disabled >\$spacer \$title</option>";

			$Tree = new \Common\Extend\Tree();

			$Tree->init($array);

			$select_categorys = $Tree->get_tree(0, $str, $pid);

			$this->assign('tpltitle','编辑');

			$this->assign('select_categorys',$select_categorys);

			$this->assign('info', $db->getAuthRule('id='.$id));
			$this->cur_v='AuthRule-edit';
			$this->display('edit');

		}
	}

	/**
     * @cc 删除
     */
	public function ajax_del(){
		$id = I('id','intval',0);
		if(!$id)$this->error('参数错误!');
		$db = D('AuthRule');
		$info = $db -> getAuthRule(array('id'=>$id),'id');
		if($db->childAuthRule($info['id'])){
			$data=array();
			$data['code']=1;
			$data['msg']='存在子菜单，不可删除!';
		}else{
			if($db->delAuthRule('id='.$id)){
				$data=array();
				$data['code']=0;
				$data['msg']='删除成功！';
			}else{
				$data=array();
				$data['code']=0;
				$data['msg']='删除失败！';
			}
		}

		echo json_encode($data); 
	}

	/**
     * @cc 异步设置在权限设置列表是否显示
     */
	public function ajax_set_is_show(){
		$id = I('id','intval',0);
		$is_show = I('is_show','intval',0);
		if(!$id)$this->error('参数错误!');
		$db = D('AuthRule');

		$data=array();
		if($is_show==1){
			$data['is_show']=0;
		}else{
			$data['is_show']=1;
		}

		$res = $db -> where(array('id'=>$id))->save($data);
		if($res){
			$data=array();
			$data['code']=0;
			$data['msg']='success';
		}else{
			$data=array();
			$data['code']=1;
			$data['msg']='error';
		}

		echo json_encode($data); 
	}

	
	/**
     * @cc 获取所有控制器名称
     */
    protected function getController($module){
        if(empty($module)) return null;
        $module_path = APP_PATH . '/' . $module . '/Controller/';  //控制器路径
        if(!is_dir($module_path)) return null;
        $module_path .= '/*.class.php';
        $ary_files = glob($module_path);
        foreach ($ary_files as $file) {
            if (is_dir($file)) {
                continue;
            }else {
                $files[] = basename($file, C('DEFAULT_C_LAYER').'.class.php');
            }
        }

        dump($files);die;
        return $files;
    }

    /**
     * @cc 获取所有方法名称
     */
    protected function getAction($module, $controller){
        if(empty($controller)) return null;
        $content = file_get_contents(APP_PATH . '/'.$module.'/Controller/'.$controller.'Controller.class.php');
        preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
        $functions = $matches[1];
        //排除部分方法
        $inherents_functions = array('_initialize','__construct','getActionName','isAjax','display','show','fetch','buildHtml','assign','__set','get','__get','__isset','__call','error','success','ajaxReturn','redirect','__destruct','_empty');
        foreach ($functions as $func){
            $func = trim($func);
            if(!in_array($func, $inherents_functions)){
                $customer_functions[] = $func;
            }
        }
        return $customer_functions;
    }

    /**
     * @cc 获取函数的注释
     */
    protected function get_cc_desc($module,$controller,$action){
        $desc=$module.'\Controller\\'.$controller.'Controller';
    
        $func  = new \ReflectionMethod(new $desc(),$action);
        $tmp   = $func->getDocComment();
        $flag  = preg_match_all('/@cc(.*?)\n/',$tmp,$tmp);
        $tmp   = trim($tmp[1][0]);
        $tmp   = $tmp !='' ? $tmp:'无';
        return $tmp;
    }

    /**
     * @cc 异步排序
     */
    public function ajax_sort(){
        $id=$_POST['id'];
        $sort=$_POST['sort'];

        $d=D('AuthRule');
        
        if($id&&$sort){
            $res=$d->save( array('id' =>$id , 'sort' =>intval($sort) ) );

            if($res){
                $data=array();
                $data['code']=0;
                $data['msg']='success';
            }else{
                $data=array();
                $data['code']=1;
                $data['msg']='error';
            }
            echo json_encode($data);
        }
    }

}