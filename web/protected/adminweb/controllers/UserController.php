<?php
/**
*@title 会员管理
*@author lizhi 513245459@qq.com
*@create on 2013-11-13
*/

class UserController extends Controller
{
	public $breadcrumbs=array();
	public function actionIndex()
	{
		/*$criteria=new CDbCriteria();
		$sql = "SELECT * FROM `user`";
		$result = Yii::app()->db->createCommand($sql)->query();
		$pages=new CPagination($result->rowCount);
		$pages->pageSize=10;
		$pages->applyLimit($criteria);
		$result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit"); 
		$result->bindValue(':offset', $pages->currentPage*$pages->pageSize); 
		$result->bindValue(':limit', $pages->pageSize); 
		$result=Yii::app()->db->createCommand($sql); 
		$datalist=$result->query();*/

		$criteria = new CDbCriteria();
		$criteria->order = 'id asc' ;
		$condition 	= '1';
		$username 	= Yii::app()->request->getParam('username');
		$status		= Yii::app()->request->getParam('status'); 
		$username && $condition .= ' AND username LIKE \'%' . $username . '%\'';
		$status && $condition 	.= ' AND status ='. $status;
		$criteria->condition = $condition;
        $count = User::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 4;         
        $pages->applyLimit($criteria);
        $parameter  = Bases::mapcondition( $_GET, array ( 'username' , 'status') );
        $pages->params = $parameter;
        $datalist = User::model()->findAll($criteria);
		$this->render('index',array('datalist'=>$datalist,'pagebar'=>$pages));		
	}

	/**
	*用户列表批量操作
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
            $user = new User;
            $ret = $user->deleteAll( 'id IN(' . $ids . ')' );
            Bases::adminiLogger(array ('catalog' => 'delete' , 'intro' => '删除会员,编号为:'.$ids ));
            $this->redirect(array('index'));
            break;
        
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
	}

	/*会员新增操作*/
	public function actionCreate()
	{
		$model = new User;
		if ($_POST['User']){
			$model->attributes = $_POST['User'];
			if ($model->save()){
				Bases::adminiLogger(array ('catalog' => 'create' , 'intro' => '新增会员,用户名为:'.$_POST['User']['username'] ));
			 	$this->redirect( array ( 'index' ) );
			}
		}
		
		$this->render('create', array ( 'model' => $model) );

	}
	/*修改会员页面*/
	public function actionUpdate()
	{
		$model=Bases::loadModel(new User,$_GET['id']);
		if ($_POST['User']){
			$post = $_POST['User'];
			$model->attributes = $post;
			if ($model->save()){
				Bases::adminiLogger(array ('catalog' => 'update' , 'intro' => '修改会员,用户名为:'.$post['username'] ));
			 	$this->redirect( array ( 'index' ) );
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}
}
?>