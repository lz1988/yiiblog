<?php

class Comments extends CActiveRecord
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, body, article_id', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'验证码',
			'email'		=>'邮箱',
			'name'		=>'用户名',
			'subject'	=>'主题',
			'body'		=>'内容',
		);
	}

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'comments';
	}
}