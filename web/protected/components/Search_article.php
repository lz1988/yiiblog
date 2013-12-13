<?php

Yii::import('zii.widgets.CPortlet');

class Search_article extends CPortlet
{
	public $title = "搜索文章";
	
	/*public function get_article_list()
	{
		return Article_type::model()->findarticle_type();
	}*/

	protected function renderContent()
	{
		$this->render('search_article');
	}
}