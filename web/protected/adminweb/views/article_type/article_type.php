<?php
$this->pageTitle=Yii::app()->name . ' - 类别管理';
$this->breadcrumbs=array(   
    '类别管理' 
);

?>
<div class="searchArea">
    <ul class="action left">
      <li><a href="<?php echo $this->createUrl('article_type/create')?>" class="actionBtn"><span>录入</span></a></li>
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
      
      类别名称
      <input id="article_type_name" type="text" name="article_type_name" value="" class="txt" size="15"/>
      状态
       <select name="status" id="status">
        <option value="">=请选择=</option>
        <option value="0">启用</option>
        <option value="1">注销</option>
      </select>
      <input name="searchsubmit" type="submit"  value="查询" class="button "/>
      <?php $form=$this->endWidget(); ?>
    </div>
  </div>

<script type="text/javascript">
$(document).ready(function(){
  $("#article_type_name").val('<?php echo Yii::app()->request->getParam('article_type_name')?>');
  $("#status").val('<?php echo Yii::app()->request->getParam('status')?>');
});
</script>

<form method="post" action="<?php echo $this->createUrl('article_type/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="10%">编号</th>
    <th>类别名称</th>
   
    <th width="12%">状态</th>
    <th width="15%">创建时间</th>
    <th width ="12%">排序</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row->id?>"></td>
    <td><?php echo $row->id;?></td>
    <td><?php echo $row->article_type_name;?></td>
    <td>
    <?php if($row->status == '0'):?>
    启用
    <?php else:?>
    注销
    <?php endif; ?>
    </td>
    <td><?php echo $row->fstcreate;?></td>
    <td><?php echo $row->sort;?>
    <td><a href="<?php echo  $this->createUrl('update',array('id'=>$row->id))?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/update.png" align="absmiddle" /></a> 
      <a href="<?php echo  $this->createUrl('command',array('command'=>'delete','id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/delete.png" align="absmiddle" /></a></td>
  </tr>
     <?php endforeach;?>
 <tr class="operate">
      <td colspan="7">
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
          </select>
          <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div></td>
    </tr>
</table>
</form>
