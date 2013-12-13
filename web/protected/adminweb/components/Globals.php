<?php
/**
*@title 业务逻辑公共方法
*@author lizhi 513245459@qq.com
*@create on 2013-11-14
*/
class globals{

	/**
	*获取菜单列表
	*/
	public static function getmenulist(){
		
		$ret = Menu::model()->findAll ("pid=:_pid",array(":_pid"=>0));
		foreach($ret as $item){
        	$menu_list[$item->id] = $item->menuname; 
    	}
		return $menu_list;
	}

	public function getarticle_type_list()
	{
		$ret = Article_type::model()->findAll();
		foreach($ret as $item){
        	$article_type_list[$item->id] = $item->article_type_name; 
    	}
		return $article_type_list;
	}
}
?>