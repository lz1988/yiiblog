 
<ul> 
 	<?php foreach($this->get_article_list() as $row):?> <li>
  		<?php echo CHtml::link($row['article_type_name'],array('article/index','category'=>$row['article_type_name']),array('title'=>$row['article_type_name'])) ?></li>
    <?php endforeach;?>
</ul>
