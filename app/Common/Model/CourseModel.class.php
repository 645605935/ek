<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CourseModel extends RelationModel{
	protected $_link=array(
		// 'type'=>array(
		// 	'mapping_type'=>self::BELONGS_TO,
		// 	'class_name'=>'Type',
		// 	'foreign_key'=>'tid'
		// ),
		// 'focus'=>array(
		// 	'mapping_type'=>self::HAS_MANY,
		// 	'class_name'=>'Focus',
		// 	'foreign_key'=>'iid'
		// )
	);
}

?>