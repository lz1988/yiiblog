<?php $this->pageTitle=Yii::app()->name . ' - Contact Me';?>

<h1>Contact Me</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
如果你有任何问题，请联系我，谢谢。
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">字段 <span class="required">*</span> 必填</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha',array(
        'showRefreshButton'=>true,
        'clickableImage'=>true,
        'buttonLabel'=>'',
        'imageOptions'=>array(
            'alt'=>'点击换图',
            'title'=>'点击换图',
            'style'=>'cursor:pointer'))
            ); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">请输入上面图片上的字母，不区分大小写。</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('提交'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<?php endif; ?>

<div id="comments">
<div class="titles">留言给我</div>
<?php foreach($datalist as $comment): ?>
<div class="comment" id="c<?php echo $comment['id']; ?>">

	<?php echo CHtml::link("#{$comment['id']}","#c{$comment['id']}", array(
		'class'=>'cid',
		'title'=>"#{$comment['id']}",
	)); ?>

	<div class="author">
		<?php echo $comment['name']; ?> says:
	</div>

	<div class="time">
		<?php echo date('Y-m-d H:i:s',strtotime($comment['fstcreate'])); ?>
	</div>

	<div class="content">
		<?php echo nl2br(CHtml::encode($comment['body'])); ?>
	</div>

</div>
<?php endforeach; ?>
<?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>

</div>
