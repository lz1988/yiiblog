
<div id="contentHeader">
  <?php
$this->pageTitle=Yii::app()->name . ' - 新增站点信息';
$this->breadcrumbs=array(   
    '新增站点信息'
);
?>
  <div class="searchArea">
    <ul class="action left" >
      <li class="current"><a href="<?php echo $this->createUrl('index')?>" class="actionBtn"><span>返回</span></a></li>
      <li class="current"><a href="<?php echo $this->createUrl('create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    
  </div>
</div>

<?php $this->renderPartial('site_create_form',array('model'=>$model))?>
