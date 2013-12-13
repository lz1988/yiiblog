<?php
class Article_type extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'article_type';
	}

	public function rules()
	{
		return array(
			array('article_type_name,status','required'),
			
		);
	}

	/*文章类别*/
	public function findarticle_type()
	{
		$criteria=new CDbCriteria;
		$criteria->order = 'sort asc';
		$criteria->condition  = 'status = 0 ';
		return $this->findAll($criteria);
	}
}
?>