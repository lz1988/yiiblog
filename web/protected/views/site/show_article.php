<?php
$this->pageTitle=Yii::app()->name."-".$type_name;
?>
<h1>分类</h1>
<p class="search_key">分类：<span><?php echo  $type_name;?></span> 
	共有<span><?php echo count($model);?></span>条结果</p>
<?php echo $this->renderPartial('show_article_form', array('model'=>$model,'pagebar'=>$pagebar)); ?>