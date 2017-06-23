<?php
namespace Common\Model;
use Think\Model\RelationModel;
class SiteModel extends RelationModel{
	protected $_link=array(
		'_school'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'School',
			'foreign_key'=>'school_id'
		),
		'_user'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'uid'
		),
		'_student'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'student_id'
		)
	);
}

?>