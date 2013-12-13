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

	/*最新文章*/
	public function findarticle_new($limit = 10)
	{
		$criteria=new CDbCriteria;
		$criteria->order = 'id desc';
		$criteria->limit = $limit;
		$criteria->condition  = 'status = 0 ';
		return $this->findAll($criteria);
	}

	/*最热文章*/
	public function findarticle_hot($limit = 10)
	{
		$criteria=new CDbCriteria;
		$criteria->order = 'article_click_count desc';
		$criteria->limit = $limit;
		$criteria->condition  = 'status = 0 ';
		return $this->findAll($criteria);
	}
}
?>