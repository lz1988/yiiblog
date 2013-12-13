<?php
/**
*@title 用户登陆
*@author lizhi 513245459@qq.com
*@create on 2013-11-19
*/
class LoginController extends Controller{

	public $breadcrumbs=array();

	public function actionIndex()
	{
		$this->renderPartial("index");
	}

	/*登陆验证*/
	public function actionLogin()
	{
		if ($_POST['form-submit'])
		{
			$model = new Manage('login');
			$log   = new Log;	
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$user = $model -> find('adminname=:adminname',array(':adminname'=>$username));

			if (empty($username)){Bases::message('error', '请填写用户名', $this->createUrl('login/index'),3 );}
			else if (empty($password)){Bases::message('error', '请填写密码', $this->createUrl('login/index'),3 );}
			else if ($user)
			{
				if ($username && $password == $user->adminpwd){

					if (isset($_POST['rememberflag']))
					{
						$cookie = new CHttpCookie('uname',$user->adminname);
						$cookie->expire = time()+60*60*24*30;  //有限期30天
						Yii::app()->request->cookies['uname']=$cookie;

						$cookie1 = new CHttpCookie('upwd',$user->adminpwd);
				        $cookie1 -> expire = time()+60*60*24*30;
				        Yii::app()->request->cookies['upwd'] = $cookie1;
					}

					Yii::app() -> session['uname'] 	= $user->adminname;
					Yii::app() -> session['uid']	= $user->id;	
			
					$user->ip = Yii::app()->request->userHostAddress;
                    $user->last_time = date('Y-m-d H:i:s');
                    $user->login_count = $user->login_count+1;
                    $user->save();
     
					Bases::adminiLogger(array ('catalog' => 'login' , 'intro' => '用户登录成功:'.$user->adminname ));
					$this -> redirect(array('manage/index'));
				}else{
					Bases::message('error', '密码填写错误！', $this->createUrl('login/index'),3 );
				}

			}else{
				Bases::message('error', '用户名不存在！', $this->createUrl('login/index'),3 );
			}

			$this -> render('index');
	    }
	}
}