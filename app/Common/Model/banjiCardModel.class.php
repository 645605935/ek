<?php
namespace Common\Model;
use Think\Model\RelationModel;
class banjiCardModel extends RelationModel{
	protected $_link=array(
		'_creater'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'User',
			'foreign_key'=>'creater'
		),
		'_banji'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'Banji',
			'foreign_key'=>'banji'
		),
		'_card'=>array(
			'mapping_type'=>self::BELONGS_TO,
			'class_name'=>'Card',
			'foreign_key'=>'card'
		)
	);
}

?>