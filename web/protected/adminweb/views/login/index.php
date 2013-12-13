<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统</title>
<!--                       CSS                       -->
<!-- Reset Stylesheet -->
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ;?>/css/reset.css" type="text/css" media="screen" />
<!-- Main Stylesheet -->
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ;?>/css/style.css" type="text/css" media="screen" />
<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ;?>/css/invalid.css" type="text/css" media="screen" />
<!--                       Javascripts                       -->
<!-- jQuery -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js/jquery-1.3.2.min.js"></script>
<!-- jQuery Configuration -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js/simpla.jquery.configuration.js"></script>
<!-- Facebox jQuery Plugin -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js/facebox.js"></script>
<!-- jQuery WYSIWYG Plugin -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js/jquery.wysiwyg.js"></script>
<script type="text/javascript">
var CheckForm = function(){
    $("form").submit();
}
</script>
</head>
<body id="login">
<div id="login-wrapper" class="png_bg">
  <div id="login-top">
    <h1>后台管理系统</h1>
    <img id="logo" src="<?php echo Yii::app()->baseUrl ;?>/images/logo.png" /> </div>
  <div id="login-content">
    <form action="?r=login/login" method="post" name="baseform">
      <div class="notification information png_bg">
       
           <?php echo $errorMsg;?>
           

      </div>
      <p>
        <label>用户名</label>
        <input class="text-input" type="text" name="username" />
      </p>
      <div class="clear"></div>
      <p>
        <label>密码</label>
        <input class="text-input" type="password" name="password" />
      </p>
      <div class="clear"></div>
      <p id="remember-password">
        <input type="checkbox" checked name="rememberflag"/>
        记住我 </p>
      <div class="clear"></div>
      <p>
        <input class="button" name="form-submit" type="submit" value="登陆" />
      </p>
    </form>
  
</body>
</html>