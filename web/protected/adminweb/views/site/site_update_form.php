<?php if (CHtml::errorSummary($model)):?>
<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/jscolor/jscolor.js"></script>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform','enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title" >站点标题：</td>    <td><?php echo $form->textField($model,'site_title',array('size'=>60,'maxlength'=>128,'class'=>'validate[required,minSize[4]]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title" >状态：</td><td><?php echo $form->dropDownList($model,'status',array('0'=>'启用', '1'=>'注销')); ?></td>
  </tr>

   <tr>
     <td class="tb_title" >站点内容：</td>
<td>
  <?php echo $form->textArea($model,'site_content', array('class'=>'validate[required]')); ?>
 <?php $this->widget('application.widget.kindeditor.KindEditor',array(
    'target'=>array(
      '#Site_site_content'=>array('uploadJson'=>$this->createUrl('upload'),'extraFileUploadParams'=>array(array('sessionId'=>session_id()))))));?>
</td>
</tr>
    
 <tr class="submit">
    <td colspan="2" >
      <input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
  </tr>
</table>
<script type="text/javascript">
$(function(){
  $("#xform").validationEngine();
});
</script>
<?php $form=$this->endWidget(); ?>