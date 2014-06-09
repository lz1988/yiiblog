<?php
$this->pageTitle=Yii::app()->name;
?>


<h1>搜索结果</h1>
<p class="search_key">搜索关键词：<span><?php echo $search_article;?></span> 
	共有<span><?php echo count($model);?></span>条结果</p>


<?php foreach($model as $row):?> 
<div id="mainbody">

	<div id="maintitle">
		<h3><?php echo CHtml::link($row["article_title"],array('site/show','id'=>CHtml::encode($row['id'])));?></h3>
	</div>
    
    <div id="mainnav">
		<span> 作者：<?php echo $row['article_author']?> </span>
		<span>	时间：<?php echo $row['fstcreate']?> </span>
		<span>	浏览：<?php echo $row['article_click_count'];?></span>
	</div>

   <div id="maincontent"><?php echo Bases::truncate_utf8_string($row['article_content'],100,false);?></div>

	<div id="maintag">
		<?php
		 if ($row['key_words']){
		 	$html = '';
		 	$html .= '标签：';
			$new_key_words = explode(',',$row['key_words']);
			foreach($new_key_words as $val)
			{
				$html .= '<a href ="/article/search/keywords/'.CHtml::encode($val).'">'.$val.'</a>&nbsp;&nbsp;';
			}
			echo $html;

		}
		 ?>
	</div>
</div>

<?php endforeach;?>

<?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>


