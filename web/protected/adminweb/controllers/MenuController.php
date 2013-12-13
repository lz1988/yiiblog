<?php
/**
*@title 菜单管理
*@author lizhi 513245459@qq.com
*@create on 2013-11-8
*/
class MenuController extends Controller
{
	
	public $breadcrumbs=array();

	/*菜单管理页面*/
	public function actionIndex()
	{

		$criteria = new CDbCriteria();
		$condition 	= '1';
		$menuname 	= Yii::app()->request->getParam('menuname');
		$status		= Yii::app()->request->getParam('status'); 
		$menuname && $condition .= ' AND menuname LIKE \'%' . $menuname . '%\'';	
		$status && $condition 	.= ' AND status ='. $status;
		$criteria->condition = $condition;
		$criteria->order = 'id asc' ;
        $count = Menu::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;         
        $pages->applyLimit($criteria);
        $parameter  = Bases::mapcondition( $_GET, array ( 'menuname' , 'status') );
        $pages->params = $parameter;
        $list = Menu::model()->findAll($criteria);
        $datalist = Menu::get(0, $list);
		$this->render('menu',array(
			'datalist'	=>$datalist,
			'pagebar'	=>$pages,
		));		
	}

	


	/*修改菜单页面*/
	public function actionUpdate()
	{
		$menu_list = globals::getmenulist();
		$model=Bases::loadModel(new Menu,$_GET['id']);
		if ($_POST['Menu']){
			$post = $_POST['Menu'];
			if ($post['pid'] == ""){
				$post['pid'] = 0;
			}

			$model->attributes = $post;
			if ($model->save()){
			 	$this->redirect( array ( 'index' ) );
			}
		}
		$this->render('update',array(
			'model'=>$model,'menu_list'=>$menu_list,
		));
	}


	/**
	*菜单列表批量操作
	*/
	public function actionCommand()
	{
		
		if ( Bases::method() == 'GET' ) {
            $command = trim( $_GET['command'] );
            $ids = intval( $_GET['id'] );
           
        } elseif ( Bases::method() == 'POST' ) {
            $command = trim( $_POST['command'] );
            $ids = $_POST['id'];
            is_array( $ids ) && $ids = implode( ',', $ids );
        } else {
            Bases::message( 'errorBack', '只支持POST,GET数据' );
        }
        empty( $ids ) && Bases::message( 'error', '未选择记录' );

        switch ( $command ) {
        case 'delete':
            $menu = new Menu;
            $ret = $menu->deleteAll( 'id IN(' . $ids . ')' );
            $this->redirect(array('index'));
            break;
        
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
	}
	/*菜单新增操作*/
	public function actionCreate()
	{
		$model = new Menu;
		$menu_list = globals::getmenulist();
		if ($_POST['Menu']){
			$post = $_POST['Menu'];
			if ($post['pid'] == ""){
				$post['pid'] = 0;
			}

			$model->attributes = $post;
			if ($model->save()){
			 	$this->redirect( array ( 'index' ) );
			}
		}
		
		$this->render('create', array ( 'model' => $model, 'menu_list'=>$menu_list) );

	}

}
?>