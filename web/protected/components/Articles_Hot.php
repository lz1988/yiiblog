<?php

Yii::import('zii.widgets.CPortlet');

class Articles_Hot extends CPortlet
{
	public $title = "热门文章";
	public $max_article = 5;

	public function get_article_list()
	{
		return Article::model()->findarticle_hot($this->max_article);
	}

	protected function renderContent()
	{
		$this->render('articles_hot');
	}
}