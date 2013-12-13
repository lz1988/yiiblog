<?php
class Site extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'site';
	}

	public function rules()
	{
		return array(
			array('site_title,site_content,status','required'),
			
		);
	}
}
?>