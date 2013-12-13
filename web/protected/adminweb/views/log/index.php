<?php
$this->pageTitle=Yii::app()->name . ' - 日志管理';
$this->breadcrumbs=array(   
    '日志管理'
);
?>

<script type="text/javascript">
$(document).ready(function(){
  $("#uname").val('<?php echo Yii::app()->request->getParam('uname')?>');
  $("#create_time").val('<?php echo Yii::app()->request->getParam('create_time')?>');
});
</script>
<div class="searchArea">
   <ul class="action left">
      <li><a href="<?php echo $this->createUrl('log/output',$_SESSION['row'])?>" class="actionBtn"><span>导出</span></a></li>
      <li><a href="<?php echo $this->createUrl('log/export')?>" class="actionBtn"><span>导入</span></a></li>
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
      
      用户
      <input id="uname" type="text" name="uname" value="" class="txt" size="15"/>
      操作时间
      <input id="create_time" type="text" name="create_time" value=""onClick="WdatePicker()"class="txt" size="15"/>
      
      
      <input name="searchsubmit" type="submit"  value="查询" class="button "/>
      <?php $form=$this->endWidget(); ?>
    </div>
  </div>



<form method="post" action="<?php echo $this->createUrl('log/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="5%">编号</th>
    <th width="8%">用户</th>
    <th width="10%">IP</th>
    <th width="7%">类型</th>
    <th>动作</th>
     <th width="15%">操作时间</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"></td>
    <td><?php echo $row['id'];?></td>
    <td><?php echo $row['uname'];?></td>  
    <td><?php echo $row['ip'];?></td>
    <td><?php echo $row['catalog'];?></td>
    <td><?php echo $row['intro'];?><br/><?php echo $row['url'];?></td>
    <td><?php echo $row['create_time'];?></td>
    <td><!-- <a href="<?php echo  $this->createUrl('update',array('id'=>$row['id']))?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/update.png" align="absmiddle" /></a>  -->
      <a href="<?php echo  $this->createUrl('command',array('command'=>'delete','id'=>$row['id']))?>" class="confirmSubmit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/delete.png" align="absmiddle" /></a></td>
  </tr>
     <?php endforeach;?>
  <tr class="operate">
      <td colspan="8">
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
