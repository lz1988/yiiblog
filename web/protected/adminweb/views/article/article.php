<?php
$this->pageTitle=Yii::app()->name . ' - 文章管理';
$this->breadcrumbs=array(   
    '文章管理' 
);

?>
<div class="searchArea">
    <ul class="action left">
      <li><a href="<?php echo $this->createUrl('article/create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right">
      <?php $form = $this->beginWidget('CActiveForm',
        array(
          'id'    =>'searchForm',
          'method'=>'get',
          'action'=>array(
                    'index'
          ),
          'htmlOptions'=>array(
                    'name'=>'xform', 
                    'class'=>'right '
        )
      )); ?>
      
      文章标题
      <input id="article_title" type="text" name="article_title" value="" class="txt" size="15"/>
      状态
       <select name="status" id="status">
        <option value="">=请选择=</option>
        <option value="0">显示</option>
        <option value="1">隐藏</option>
      </select>
      <input name="searchsubmit" type="submit"  value="查询" class="button "/>
      <?php $form=$this->endWidget(); ?>
    </div>
  </div>

<script type="text/javascript">
$(document).ready(function(){
  $("#article_title").val('<?php echo Yii::app()->request->getParam('article_title')?>');
  $("#status").val('<?php echo Yii::app()->request->getParam('status')?>');
});
</script>

<form method="post" action="<?php echo $this->createUrl('article/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="5%">编号</th>
    <th width="">文章名称</th>
    <th>分类</th>
   <th width="8%">作者</th>
   <th>内容</th>
    
     <th width="6%">热度</th>
    <th width="14%">创建时间</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"></td>
    <td><?php echo $row['id'];?></td>
    <td><?php echo Bases::truncate_utf8_string($row['article_title'],16,false);?> 
      <?php if ($row['status'] == 1):?>
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/error.png" align="absmiddle" />
      <?php endif;?>
    </td>
    <td><?php echo $row['article_type_name'];?></td>
    <td><?php echo $row['article_author'];?></td>
    <td><?php echo Bases::truncate_utf8_string($row['article_content'],25,false);?></td>
    <td><?php echo $row['article_click_count'];?></td>
    <td><?php echo $row['fstcreate'];?></td>
    <td><a href="<?php echo  $this->createUrl('update',array('id'=>$row['id']))?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/update.png" align="absmiddle" /></a> 
      <a href="<?php echo  $this->createUrl('command',array('command'=>'delete','id'=>$row['id']))?>" class="confirmSubmit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/delete.png" align="absmiddle" /></a></td>
  </tr>
     <?php endforeach;?>
 <tr class="operate">
      <td colspan="10">
        <div class="cuspages right">
        <?php 
              $this->widget('CLinkPager',array(
              'header'=>'翻页：',
              'firstPageLabel' => '首页',
              'lastPageLabel' => '末页',
              'prevPageLabel' => '上一页',
              'nextPageLabel' => '下一页',
              'pages' => $pagebar,
              'maxButtonCount'=>13
              )
            );
        ?>
        </div>
        <div class="fixsel">
          <input type="checkbox" name="chkall" id="chkall" onClick="checkAll(this.form, 'id')" />
          <label for="chkall">全选</label>
          <select name="command">
            <option>选择操作</option>
            <option value="delete">删除</option>
             <option value="show">显示</option>
             <option value="hidden">隐藏</option>
          </select>
          <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div></td>
    </tr>
</table>
</form>
