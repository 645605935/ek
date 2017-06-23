<?php 
namespace Think;
use Think\Controller;
class CommonController extends Controller{

    public function _initialize(){


    }
    //提示错误并且停止
    public function error_exit($msg='操作失败',$a='',$b='',$c=''){
    	$this->error($msg,$a,$b,$c);
    	exit;
    }
    /**

	 * 分页函数 支持sql和数据集分页 sql请用 buildSelectSql()函数生成

	 * @access public

	 * @param array  $result 排好序的数据集或者查询的sql语句

	 * @param int    $totalRows  每页显示记录数 默认21

	 * @param string $listvar    赋给模板遍历的变量名 默认list

	 * @param string $parameter  分页跳转的参数

	 * @param string $target  分页后点链接显示的内容id名

	 * @param string $pagesId  分页后点链接元素外层id名

	 * @param string $template ajaxlist的模板名

	 * @param string $url ajax分页自定义的url

	 */

	function ajaxPage($param) {
		extract($param);


		//总记录数

		$flag = is_string($result);

		$listvar = $listvar ? $listvar : 'list';

		$listRows = $listRows? $listRows : 21;

		if ($flag)

			$totalRows = M()->table($result . ' a')->count();

		else

			$totalRows = ($result) ? count($result) : 1;

		//创建分页对象

		if ($target && $pagesId)

			$p = new \Common\Extend\Page($totalRows, $listRows, $parameter, $url,$target, $pagesId);

		else

			$p = new \Common\Extend\Page($totalRows, $listRows, $parameter,$url);

		//抽取数据

		if ($flag) {

			$result .= " LIMIT {$p->firstRow},{$p->listRows}";

			$voList = M()->query($result);

		} else {

			$voList = array_slice($result, $p->firstRow, $p->listRows);

		}

		$pages = C('PAGE');//要ajax分页配置PAGE中必须theme带%ajax%，其他字符串替换统一在配置文件中设置，

		//可以使用该方法前用C临时改变配置

		foreach ($pages as $key => $value) {

			$p->setConfig($key, $value); // 'theme'=>'%upPage% %linkPage% %downPage% %ajax%'; 要带 %ajax%

		}

		//分页显示

		$page = $p->show();

		//模板赋值

		$this->assign($listvar, $voList);

		$this->assign("page", $page);

        layout(false);

        $template = (!$template) ? 'ajaxlist' : $template;
        exit($this->fetch($template));
		return $voList;

	}

	 /**

	 * 处理百度编辑器里上传的图片及文字

	 * @access public

	 * @param int    $id  数据里里对应文章的id

	 * @param string $text   编辑器内容

	 * @param string $floader  文件夹

	 * @param string $thumb  是否生略显图  1为是 默认为0 否

	 * @return array 返回文字和图片地址数组

	 */

	public function filterUeditor($id,$text,$floader,$thumb=0){

		$text=htmlspecialchars(stripslashes($text));

		preg_match_all('/'.preg_quote(STATIC_PATH.'ueditor_temp','/').'(.*)(?<=\.png|\.jpg|\.jpeg|\.gif)/isU', $text, $matches);

		//最终路径

		$targetpath=filePath2($id,$floader);

		//移动文本里的图片到指定位置

		if(!empty($matches)){

			foreach ($matches[0] as $filepath) {

				copy($filepath, STATIC_PATH.$targetpath.'/'.end(explode('/', $filepath)));

			}

		}

		$result['text']=str_replace(STATIC_PATH.'ueditor_temp', STATIC_PATH.$targetpath, $text);

		$result['path']=$targetpath;

		//返回所有图片 及略显图

		if($thumb){

			//生成略显图

			if(!empty($matches)){

				foreach ($matches[0] as $filepath) {

				thumbnail2($id,$filepath,$floader);

				}

			}

			preg_match_all('/'.preg_quote($targetpath,'/').'(.*)(?<=\.png|\.jpg|\.jpeg|\.gif)/isU', $result['text'], $matchespic);

			if(!empty($matchespic)){

				foreach($matchespic[0] as $key=>$pictures){

				$end=end(explode('/', $pictures));

				$picname=current(explode('.', $end));

				$result['pics'][$key]['thumbnail_pic']=$targetpath.'/thumb_'.$picname.'.jpg';

				$result['pics'][$key]['bmiddle_pic']=$targetpath.'/bmid_'.$picname.'.jpg';

				$result['pics'][$key]['original_pic']=$targetpath.'/'.$end;

				}

			}

		}

		return $result;

	}

}