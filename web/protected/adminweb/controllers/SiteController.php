<?php
class SiteController extends Controller
{
	public function actionIndex()
	{
        $datalist = Site::model()->findAll();
		$this->render('index',array('datalist'=>$datalist));	
	}

	/*站点信息新增操作*/
	public function actionCreate()
	{
		$model = new Site;
		if ($_POST['Site']){
			$post = $_POST['Site'];
			$model->attributes = $post;
			if ($model->save()){
			 	$this->redirect( array ( 'index' ) );
			}
		}
		
		$this->render('site_create', array ( 'model' => $model) );
	}

	/*修改站点信息页面*/
	public function actionUpdate()
	{
		$model=Bases::loadModel(new Site,$_GET['id']);
		if ($_POST['Site']){
			$post = $_POST['Site'];
			$model->attributes = $post;
			if ($model->save()){
			 	$this->redirect( array ( 'index' ) );
			}
		}
		$this->render('site_update',array('model'=>$model));
	}

	/**
	*站点信息批量操作
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
            $model = new Site;
            $ret = $model->deleteAll( 'id IN(' . $ids . ')' );
            $this->redirect(array('index'));
            break;
        
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
	}
}