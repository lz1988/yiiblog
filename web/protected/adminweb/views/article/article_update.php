
<div id="contentHeader">
  <div id="contentHeader">
  <?php
$this->pageTitle=Yii::app()->name . ' - 文章管理';
$this->breadcrumbs=array(   
    '修改文章'
);
?>
  <div class="searchArea">
    <ul class="action left" >
      <li class="current"><a href="<?php echo $this->createUrl('index')?>" class="actionBtn"><span>返回</span></a></li>
      <li ><a href="<?php echo $this->createUrl('create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('article_update_form',array('model'=>$model,'article_type_list'=>$article_type_list,'imageList'=>$imageList))?>

