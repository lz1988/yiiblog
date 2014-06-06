<?php
$this->pageTitle=Yii::app()->name;
?>

<?php foreach($datalist as $row):?> 
<div id="mainbody">

<div id="maintitle">
	<h3><?php echo CHtml::link($row["article_title"],array('article/view','id'=>$row['id']));?></h3>
</div>

<div id="mainnav">
	<span>类别：<?php echo $row['article_type_name'];?></span>
	<span>时间：<?php echo $row["fstcreate"];?></span>
	<span>作者：<?php echo $row['article_author'];?></span>
</div>

<div id="maincontent"><?php echo Bases::truncate_utf8_string($row['article_content'],180,false);?></div>
<div id="maintag">
	<?php
	 if ($row['key_words']){
	 	$html = '';
	 	$html .= '标签：';
		$new_key_words = explode(',',$row['key_words']);
		foreach($new_key_words as $val)
		{
			$html .= CHtml::link($val,array("article/search","keywords"=>CHtml::encode($val))).'&nbsp;&nbsp;';
		}
		echo $html;

	}
	 ?>
	<span class="readall"><?php echo CHtml::link("阅读全文",array('article/view','id'=>$row['id']));?></span>
</div>
 

</div>
<?php endforeach;?>

<?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>