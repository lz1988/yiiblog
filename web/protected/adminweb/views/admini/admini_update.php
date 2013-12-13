
<div id="contentHeader">
  <div id="contentHeader">
  <?php
$this->pageTitle=Yii::app()->name . ' - 管理员管理';
$this->breadcrumbs=array(   
    '修改管理员'
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
<?php $this->renderPartial('admini_update_form',array('model'=>$model))?>

