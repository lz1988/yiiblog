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

	/*显示文章明细*/
	public function actionShow()
	{
		$arid = intval(Yii::app()->request->getParam('id'));
		
		if ($arid)
		{
			Article::model()->updateCounters(array('article_click_count'=>1),'id = '.$arid);  
			$model  = Article::model()->findbyPk($arid);

			$comments = Comments::model();

			$criteria = new CDbCriteria();
			$criteria -> select = 'id,article_title,key_words';
			$criteria -> condition = 'status = 0 and id <>'.$model->id.'';
			$datalist = Article::model()->findAll($criteria);

			//相关文章显示
			for($i = 0; $i < count($datalist); $i++ )
			{
				$arr_similar[$i] = similar_text($datalist[$i]['key_words'], $model->key_words);
				
			}
			arsort($arr_similar);
			$index = 0;
			foreach($arr_similar as $old_index=>$similar)
			{
				if ($index < 8){
					$new_title_array[$datalist[$old_index]['id']] = $datalist[$old_index]['article_title'];
					$index++;
				}
			}

			$last_data = Article::model()->find(array('select'=>'id,article_title','order'=>'id desc','condition'=>'id < :ID and status = :STATUS','params'=>array(':ID'=>$arid,'STATUS'=>0)));

			$next_data = Article::model()->find(array('select'=>'id,article_title','condition'=>'id > :ID','params'=>array(':ID'=>$arid)));

            $model1    = new Comments;
            $criteria1 = new CDbCriteria;
            $criteria1->condition = 'article_id=:article_id';
            $criteria1->params = array(':article_id'=>$arid);
            $count = $model1->count($criteria1);
            $pager = new CPagination($count);
            $pager->pageSize = 8;  //每页显示的个数
            $pager->applyLimit($criteria1);
            $datalist = $model1->findAll($criteria1);
			$this->render('show',array('model'=>$model,'new_title_array'=>$new_title_array,'comments'=>$comments,'last_data'=>$last_data,'next_data'=>$next_data,'pagebar'=>$pager,'datalist'=>$datalist));
		}else{
			throw new CHttpException(404);exit;
		}
		
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

	/*处理文章评论*/
	public function actionComments()
	{

		if(isset($_POST['Comments']))
		{
			$model    = new Comments;
			$comments = $_POST['Comments'];
			$model->attributes = $comments;
			if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			if ($model->save()){
					Bases::message("success","恭喜你、发表评论成功","?r=site/show&id={$comments['article_id']}");
				}else{
					Bases::message("error","对不起、操作失败");
			}
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

	/*关于我*/
	public function actionAbout()
	{
		$criteria=new CDbCriteria;
		$criteria->condition='site_title=:site_title';
		$criteria->params=array(':site_title'=>'关于我们');
		$datalist = Site::model()->find($criteria);
		$this->render('about',array('datalist'=>$datalist));
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


	public function actionCommand()
	{
		$action = $_GET['key'];
		$id = Yii::app()->request->getParam('id');
		$ip = Yii::app()->request->userHostAddress;
		if($action=='like'){
			Site::model()->likes('like',$id,$ip);
		}elseif($action=='unlike'){
			Site::model()->likes('unlike',$id,$ip);
		}else{
			echo Site::model()->jsons($id);
		}
	}

	
}