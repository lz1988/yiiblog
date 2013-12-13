<?php

Yii::import('zii.widgets.CPortlet');

class Articles_type extends CPortlet
{
	public $title = "文章分类";
	public $max_article_type = 5;

	public function get_article_list()
	{
		return Article_type::model()->findarticle_type();
	}

	protected function renderContent()
	{
		$this->render('articles_type');
	}
}