
<div id="contentHeader">
  <?php
$this->pageTitle=Yii::app()->name . ' - 导入日志';
$this->breadcrumbs=array(   
    '导入日志'
);
?>
  <div class="searchArea">
    <ul class="action left" >
      <li class="current"><a href="<?php echo $this->createUrl('index')?>" class="actionBtn"><span>返回</span></a></li>
    </ul>
    
  </div>
</div>

<?php $form = $this->beginWidget('CActiveForm',array('id'=>'xform', 'action'=>Yii::app()->createUrl('log/exportmod'),'htmlOptions'=>array('name'=>'xform','enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title">上传文件：</td>
  </tr>
  <tr >
    <td ><input name="file" type="file" />
    	<input type="submit" name="editsubmit" value="提交" class="button" />
     </td>
  </tr>
</table>
<?php $this->endWidget(); ?>

