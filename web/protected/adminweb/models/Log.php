<?php
class Log extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'log';
	}

	public function rules()
	{
		return array(
			array('uname,url,catalog,intro','required'),
			
		);
	}
}
?>