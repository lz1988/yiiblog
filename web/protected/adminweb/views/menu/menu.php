<?php
$this->pageTitle=Yii::app()->name . ' - 菜单管理';
$this->breadcrumbs=array(   
    '菜单管理'
);
?>

<?php 
/*$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'pager'=>array(              //通过pager设置样式   默认为CLinkPager
        'prevPageLabel'=>'上一页',
        'firstPageLabel'=>'首页',  //first,last 在默认样式中为{display:none}及不显示，通过样式{display:inline}即可
        'nextPageLabel'=>'下一页',
        'lastPageLabel'=>'末页',
        'header'=>'',
    ),
    'summaryText'=>'第{start}-第{end}条记录,总记录:{count}条,当前显示页码:{page}页',
    'columns'=>array(
        array(
            'name'=>'编号',
            'value'=>'$data->id'
        ),
        array(
            'name'=>'菜单名称',
            'type'=>'raw',
            'value'=>'CHtml::link($data->menuname,Yii::app()->createUrl("menu/childmenu", array("id"=>$data->id)))',
        ),
        array(
            'name'=>'路径',
            'value'=>'$data->url',
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); */?>

<script type="text/javascript">
$(document).ready(function(){
  $("#menuname").val('<?php echo Yii::app()->request->getParam('menuname')?>');
  $("#status").val('<?php echo Yii::app()->request->getParam('status')?>');
});
</script>
<div class="searchArea">
    <ul class="action left">
      <li><a href="<?php echo $this->createUrl('menu/create')?>" class="actionBtn"><span>录入</span></a></li>
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
      
      菜单名称
      <input id="menuname" type="text" name="menuname" value="" class="txt" size="15"/>
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



<form method="post" action="<?php echo $this->createUrl('menu/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="10%">编号</th>
    <th>菜单名称</th>
    <th width="19%">路径</th>
    <th width="12%">状态</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"></td>
    <td><?php echo $row['id'];?></td>
    <td>

<?php echo $row['str_repeat'] ?><a href="">
<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/insert.png" align="absmiddle" /></a> 
<a href=""><?php echo $row['menuname'] ?></a>
    </td>
    <td><?php echo $row['url'];?></td>
    <td>
    <?php if($row['status'] == '0'):?>
    启用
    <?php else:?>
    注销
    <?php endif; ?>
    </td>
    <td><a href="<?php echo  $this->createUrl('update',array('id'=>$row['id']))?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/update.png" align="absmiddle" /></a> 
      <a href="<?php echo  $this->createUrl('command',array('command'=>'delete','id'=>$row['id']))?>" class="confirmSubmit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/delete.png" align="absmiddle" /></a></td>
  </tr>
     <?php endforeach;?>
  <tr class="operate">
      <td colspan="6">
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
