<?php
class Article extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'article';
	}

	public function rules()
	{
		return array(
			array('article_title,article_type,article_content,status,article_author','required'),
			
		);
	}
}
?>