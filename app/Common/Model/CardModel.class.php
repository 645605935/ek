<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CardModel extends RelationModel{
	protected $_link=array(
		'_creater'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'uid'
		),
		'_course'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'Course',
			'foreign_key'=>'cid'
		)
	);
}

?>