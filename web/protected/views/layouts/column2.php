<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
		<?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
		<?php $this->widget('Search_article');?>
		<?php $this->widget('Article_types');?>
		<?php $this->widget('Articles_New', array('max_article'=>Yii::app()->params['max_article_new'],));?>
		<?php $this->widget('Articles_Hot', array('max_article'=>Yii::app()->params['max_article_hot'],));?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>