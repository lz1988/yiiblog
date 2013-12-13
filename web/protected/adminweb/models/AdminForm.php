<?php
class AdminForm extends CFormModel{
	public $username;
	public $userpwd;
	public function rules(){
		return array(
			array('username,userpwd','require'),
		);
	}
}
?>