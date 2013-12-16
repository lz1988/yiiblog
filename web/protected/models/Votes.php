<?php
class Votes extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'votes';
	}

	public function rules()
	{
		return array(
			array('ip,vid,ip','required'),
			
		);
	}

}
?>