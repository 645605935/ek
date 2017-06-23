<?php
namespace Common\Model;
use Think\Model\RelationModel;
class LogModel extends RelationModel{
	protected $_link=array(
		'_user'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'uid'
		)
	);

	// 保存日志
	public function addLog($title,$url,$model,$controller,$action){
		if($user=session('auth')){

			$data['title']=$title['title'];
			$data['url']=$url;
			$data['model']=$model;
			$data['controller']=$controller;
			$data['action']=$action;
			$data['uid']=$user['uid'];
			$data['username']=$user['username'];
			$data['time']=time();

			$this->add($data);
		}
	}
}

?>