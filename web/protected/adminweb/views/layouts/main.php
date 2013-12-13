<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/comment.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/adminweb/zebra_dialog/css/zebra_dialog.css" />
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form.js" ></script>
	<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.tools.min.js" ></script>
	<script type="text/javascript"src="<?php echo Yii::app()->request->baseUrl;?>/js/adminweb/validationEngine/jquery.validationEngine.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/adminweb/base.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/adminweb/zebra_dialog/zebra_dialog.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

<div class="container" id="page">

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>'当前页面',   
		'links'=>$this->breadcrumbs,
	)); ?>

	<?php echo $content; ?>

</div>

</body>
</html>