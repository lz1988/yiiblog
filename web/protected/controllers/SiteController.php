<?php

class SiteController extends Controller
{
	public $layout='column2';

	public function actions()
	{
		
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				//'fixedVerifyCode' => substr(md5(time()),0,4), 
				'transparent'=>true,

			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}


	public function actionIndex()
	{
		$criteria=new CDbCriteria();
		$where = 'where 1 and ar.status = 0 ';
		$sql = "SELECT tp.article_type_name,ar.* FROM article_type as tp join article  ar on tp.id = ar.article_type $where order by id desc";
		$result = Yii::app()->db->createCommand($sql)->query();
		$pages = new CPagination($result->rowCount);
		$pages->pageSize=8;
		$parameter  = Bases::mapcondition( $_GET, array ( 'article_title' , 'status') );
        $pages->params = $parameter;
		$pages->applyLimit($criteria);
		$result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit"); 
		$result->bindValue(':offset', $pages->currentPage*$pages->pageSize); 
		$result->bindValue(':limit', $pages->pageSize); 
		$datalist=$result->query(); 
		$this->render('index',array('datalist'=>$datalist,'pagebar'=>$pages));
		
	}

	public function actionShow_article()
	{
		$type_name 	= Yii::app()->request->getParam('type_name');
		$criteria = new CDbCriteria();
		$id = Yii::app()->request->getParam('id');
		$where = 'where 1 and status = 0 and article_type ='.$id;
		$sql = "SELECT *  from article  $where";
		$result = Yii::app()->db->createCommand($sql)->query();
		$pages = new CPagination($result->rowCount);
		$pages->pageSize=10;
		$pages->applyLimit($criteria);
		$result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
		$result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
		$result->bindValue(':limit', $pages->pageSize);
		$datalist=$result->query();
		$this->render('show_article',array('model'=>$datalist,'pagebar'=>$pages,'type_name'=>$type_name));
	}

	public function actionSearch_article()
	{
		$search_article = Yii::app()->request->getParam('search_article');
		$criteria = new CDbCriteria();
		$where = "where 1 and status = 0  and MATCH (article_title,article_content,key_words) AGAINST ('".$search_article."' IN BOOLEAN MODE)";
		$sql = "SELECT *  from article  $where";
		$result = Yii::app()->db->createCommand($sql)->query();
		$pages = new CPagination($result->rowCount);
		$pages->pageSize=10;
		$pages->applyLimit($criteria);
		$result = Yii::app()->db->createCommand($sql." LIMIT :offset,:limit"); 
		$result->bindValue(':offset', $pages->currentPage*$pages->pageSize); 
		$result->bindValue(':limit', $pages->pageSize); 
		$datalist=$result->query(); 
		$this->render('search_article',array('model'=>$datalist,'pagebar'=>$pages,'search_article'=>$search_article));
	}


	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}



	/*联系我*/
	public function actionContact()
	{
		$model    = new ContactForm;
		$criteria = new CDbCriteria;
		$count = $model->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = 8;  //每页显示的个数
		$pager->applyLimit($criteria);	
		$datalist = $model->findAll($criteria);

		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				if ($model->save()){
					Yii::app()->user->setFlash('contact','谢谢联系我，我会尽快给你答复');
					$this->refresh();
				}
			}
		}
		$this->render('contact',array('model'=>$model,'datalist'=>$datalist,'pagebar'=>$pager));
	}

	/*联系我*/
	public function actionContacts()
	{
		$criteria=new CDbCriteria;
		$criteria->condition='site_title=:site_title';
		$criteria->params=array(':site_title'=>'联系我们');
		$datalist = Site::model()->find($criteria);
		$this->render('contact',array('datalist'=>$datalist));
	}


	public function actionLogin()
	{
		$model=new LoginForm;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}




	
}