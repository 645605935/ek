<?php
namespace Common\Model;
use Think\Model\RelationModel;
class BanjiModel extends RelationModel{
	protected $_link=array(
		'teacher'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'tid'
		),
		'school'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'School',
			'foreign_key'=>'sid'
		)
	);
}

?>