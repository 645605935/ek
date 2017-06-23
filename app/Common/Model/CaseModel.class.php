<?php
namespace Common\Model;
use Think\Model\RelationModel;
class CaseModel extends RelationModel{
	protected $_link=array(
		'_creater'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'creater'
		),
		'_editer'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'editer'
		),
		'_course'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'Course',
			'foreign_key'=>'cid'
		)
	);
}

?>