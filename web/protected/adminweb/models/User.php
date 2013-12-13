<?php
class User extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user';
	}

	public function rules()
	{
		return array(
			array('username','required','message' => '用户名不能为空'),
			array('password','required','message' => '密码不能为空'),
			array('status','required','message'=>'状态不能为空'),
			array('username, password', 'length', 'max'=>120),
		);
	}
}
?>