<?php 
namespace Admin\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel{
	//定义关联关系
	protected $_link=array(
		'_auth_group'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'AuthGroup',
			'foreign_key'=>'gid',
			'as_fields' => 'title:_auth_group_title,id:_auth_group_id',
		),
	);

}