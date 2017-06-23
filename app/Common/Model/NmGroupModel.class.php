<?php
namespace Common\Model;
use Think\Model\RelationModel;
class NmGroupModel extends RelationModel{
	protected $_link=array(
		'_user'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'uid'
		)
	);
}

?>