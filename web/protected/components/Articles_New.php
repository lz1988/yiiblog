<?php

Yii::import('zii.widgets.CPortlet');

class Articles_New extends CPortlet
{
	public $title = "最新文章";
	public $max_article = 5;

	public function get_article_list()
	{
		return Article::model()->findarticle_new($this->max_article);
	}

	protected function renderContent()
	{
		$this->render('articles_new');
	}
}