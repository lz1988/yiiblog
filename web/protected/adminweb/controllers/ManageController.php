<?php
/**
*@title 后台管理
*@author lizhi 513245459@qq.com
*@create on 2013-11-8
*/

class ManageController extends Controller
{
	public function actionIndex()
	{
		$this->renderPartial('website');
	}

	//获取后台菜单树状
	public function actionGettree()
	{
		
		$model = new Menu;
		$ret = $model -> findAll();
		foreach($ret as $key=>$v){
			$arr[$key]['id']		= $v->id;
			$arr[$key]['text']		= $v->menuname;
			$arr[$key]['pid']		= $v->pid;
			$arr[$key]['url']		= $v->url;
			$arr[$key]['isexpand']	= false;

		}
		
		$result = find_child($arr,'id','pid'); // 无限极分类  
		echo json_encode(array_values($result));
	}

	/*后台登陆退出*/
	public function actionLogout()
	{
		$cookie = Yii::app()->request->getCookies();
		unset($cookie[$name]);
		Yii::app()->session->clear();
        Yii::app()->session->destroy(); 
		$this->redirect(array('login/index'));
	}
}
?>