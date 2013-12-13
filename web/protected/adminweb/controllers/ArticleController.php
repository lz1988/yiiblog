<?php
class ArticleController extends Controller
{
	public function actionIndex()
	{
		$criteria=new CDbCriteria();
		$where = 'where 1';
		$article_title 	= Yii::app()->request->getParam('article_title');
		$status			= Yii::app()->request->getParam('status');
		$article_title && $where.= ' and article_title like \'%'.$article_title.'%\'';
		$status != "" && $where.= ' and ar.status='.$status;

		$sql = "SELECT tp.article_type_name,ar.* FROM article_type as tp join article  ar on tp.id = ar.article_type $where order by id desc";
		$result = Yii::app()->db->createCommand($sql)->query();
		$pages = new CPagination($result->rowCount);
		$pages->pageSize=10;
		$parameter  = Bases::mapcondition( $_GET, array ( 'article_title' , 'status') );
        $pages->params = $parameter;
		$pages->applyLimit($criteria);
		$result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit"); 
		$result->bindValue(':offset', $pages->currentPage*$pages->pageSize); 
		$result->bindValue(':limit', $pages->pageSize); 
		$datalist=$result->query(); 
		$this->render('article',array('datalist'=>$datalist,'pagebar'=>$pages));
	}

	/*文章新增操作*/
	public function actionCreate()
	{
		$model = new Article();
		$imageList = Yii::app()->request->getParam('imageList');
        $imageListSerialize = Bases::imageListSerialize($imageList);

		$article_type_list = Globals::getarticle_type_list();
		if ($_POST['Article'])
		{
			$file = Xupload::upload( $_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 400 , 250 ),'allowExts' => 'jpg,gif,png,jpeg', 'maxSize' => 3292200  ) );
			if ( is_array( $file ) ) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
            }

			$model->attributes 	= $_POST['Article'];
			$model->image_list 	= $imageListSerialize['dataSerialize'];

			//分词
			$model->key_words 	= implode(',',Auto_keywords::auto_extract_keywords($model->article_content,7));
			
			if ($model->save())
			{
				Bases::adminiLogger(array ('catalog' => 'create' , 'intro' => '新增文章,编号为:'.$model->id));
			 	$this->redirect( array ( 'index' ) );
			}
		}
		$this->render('article_create', array ( 'model' => $model,'article_type_list'=>$article_type_list,'imageList'=>$imageListSerialize['data']) );
	}

	/*修改文章页面*/
	public function actionUpdate()
	{
		$model=Bases::loadModel(new Article(),$_GET['id']);
		$article_type_list = Globals::getarticle_type_list();

		$imageList = Yii::app()->request->getParam('imageList');
        $imageListSerialize = Bases::imageListSerialize($imageList);
        //print_r($imageListSerialize);die();
		if ($_POST['Article'])
		{
			
			$post = $_POST['Article'];
			$file = Xupload::upload( $_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 400 , 250 ), 'allowExts' => 'jpg,gif,png,jpeg', 'maxSize' => 3292200 ) );
			if ( is_array( $file ) ) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
            }
			$model->attributes = $post;
			$model->image_list = $imageListSerialize['dataSerialize'];
			$model->lastmodify = date('Y-m-d H:i:s');
			$model->key_words 	= implode(',',Auto_keywords::auto_extract_keywords($model->article_content,7));
			if ($model->save()){
				Bases::adminiLogger(array ('catalog' => 'update' , 'intro' => '修改文章,名称为:'.$post['article_title'] ));
			 	$this->redirect( array ( 'index' ) );
			}
		}

		if ( $imageList )
            $imageList =  $imageListSerialize['data'];
        elseif($model->image_list)
            $imageList = unserialize($model->image_list);

		$this->render('article_update',array('model'=>$model, 'article_type_list'=>$article_type_list,'imageList'=>$imageList));
	}

	/**
	*文章列表批量操作
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
           	$article = new Article;
            $ret = $article->deleteAll( 'id IN(' . $ids . ')' );
            $this->redirect(array('index'));
            break;
        case 'show':
        	$ret = Article::model()->updateByPk(explode(',',$ids),array('status'=>0));
            $this->redirect(array('index'));
            break;
        case 'hidden':
        	Article::model()->updateByPk(explode(',',$ids),array('status'=>1));
        	$this->redirect(array('index'));
        	break;
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
	}
}