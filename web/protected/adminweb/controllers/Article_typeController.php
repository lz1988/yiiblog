<?php
class Article_typeController extends Controller
{
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$condition 	= '1';
		$article_type_name 	= Yii::app()->request->getParam('article_type_name');
		$status		= Yii::app()->request->getParam('status'); 
		$article_type_name && $condition .= ' AND article_type_name LIKE \'%' . $article_type_name . '%\'';	
		$status && $condition 	.= ' AND status ='. $status;
		$criteria->condition = $condition;
		$criteria->order = 'sort asc' ;
        $count = Article_type::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 20;         
        $pages->applyLimit($criteria);
        $parameter  = Bases::mapcondition( $_GET, array ( 'article_type_name' , 'status') );
        $pages->params = $parameter;
        $datalist = Article_type::model()->findAll($criteria);
		$this->render('article_type',array('datalist'=>$datalist));
	}

	public function actionCreate()
	{
		$model = new Article_type();
		if ($_POST['Article_type']){
			$post = $_POST['Article_type'];
			$model->attributes = $post;
			if ($model->save()){
				Bases::adminiLogger(array ('catalog' => 'create' , 'intro' => '新增文章类别,名称为:'.$post['article_type_name'] ));
			 	$this->redirect( array ( 'index' ) );
			}
		}
		
		$this->render('article_type_create', array ( 'model' => $model) );
	}

	/**
	*类别批量操作
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
            $user = new Article_type;
            $ret = $user->deleteAll( 'id IN(' . $ids . ')' );
            Bases::adminiLogger(array ('catalog' => 'delete' , 'intro' => '删除类别,编号为:'.$ids ));
            $this->redirect(array('index'));
            break;
        
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
	}

	/*修改类别页面*/
	public function actionUpdate()
	{
		$model=Bases::loadModel(new Article_type(),$_GET['id']);
		if ($_POST['Article_type']){
			$post = $_POST['Article_type'];
			$model->attributes = $post;
			if ($model->save()){
				Bases::adminiLogger(array ('catalog' => 'update' , 'intro' => '修改类别,类别名称为:'.$post['article_type_name'] ));
			 	$this->redirect( array ( 'index' ) );
			}
		}
		$this->render('article_type_update',array('model'=>$model));
	}
}