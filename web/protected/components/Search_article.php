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
        /*$key_words = $_REQUEST['keywords'];
        $arr_keyword = array();
        if (!empty($keywords)){
            $arr_keyword = array('keyword'=>$key_words);
        }*/
        //print_r($arr_keyword);
		$this->render('search_article');
	}
}