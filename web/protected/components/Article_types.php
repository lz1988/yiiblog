<?php

Yii::import('zii.widgets.CPortlet');

class Article_types extends CPortlet
{
	public $title = "文章分类";
	
	public function get_article_list()
	{
		return Article_type::model()->findarticle_type();
	}

	protected function renderContent()
	{
		$this->render('article_types');
	}
}