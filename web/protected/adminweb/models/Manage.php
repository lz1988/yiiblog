<?php
class Manage extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'manage';
	}

	public function rules()
	{
		return array(
			array('adminname,adminpwd,login_count,last_time','required','on'=>'login'),
			array('adminname,adminpwd,login_count,status,email','required','on'=>'create'),
			array('adminname,adminpwd,login_count,status,email','required','on'=>'update'),
			
		);
	}
}
?>