
<ul> 
 	<?php foreach($this->get_article_list() as $row):?> <li>
  		<?php echo CHtml::link(Bases::truncate_utf8_string($row['article_title'],16,false),array('site/show','id'=>$row['id']),array('title'=>$row['article_title'])) ?></li>
    <?php endforeach;?>
</ul>
