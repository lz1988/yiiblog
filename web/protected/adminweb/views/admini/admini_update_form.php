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
    <td class="tb_title" >用户名：</td>
    <td><?php echo $form->textField($model,'adminname',array('size'=>60,'maxlength'=>128,'class'=>'validate[required,minSize[4]]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title"> 密码</td>
    <td><?php echo $form->textField($model,'adminpwd',array('size'=>60,'maxlength'=>128,'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title" >邮箱</td>
    <td><?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128,'class'=>'validate[required,custom[email]]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title" >状态：</td>
    <td><?php echo $form->dropDownList($model,'status',array('0'=>'启用', '1'=>'注销')); ?></td>
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