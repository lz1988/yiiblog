<?php
$this->pageTitle=Yii::app()->name . ' - 菜单管理';
$this->breadcrumbs=array(   
    '会员管理' 
);

?>
<div class="searchArea">
    <ul class="action left">
      <li><a href="<?php echo $this->createUrl('user/create')?>" class="actionBtn"><span>录入</span></a></li>
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
      
      用户名
      <input id="username" type="text" name="username" value="" class="txt" size="15"/>
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
  $("#username").val('<?php echo Yii::app()->request->getParam('username')?>');
  $("#status").val('<?php echo Yii::app()->request->getParam('status')?>');
});
</script>

<form method="post" action="<?php echo $this->createUrl('user/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="10%">编号</th>
    <th>用户名</th>
    <th width="19%">密码</th>
    <th width="12%">状态</th>
    <th width="15%">创建时间</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row->id?>"></td>
    <td><?php echo $row->id;?></td>
    <td><?php echo $row->username;?></td>
    <td><?php echo $row->password;?></td>
    <td>
    <?php if($row->status == '0'):?>
    启用
    <?php else:?>
    注销
    <?php endif; ?>
    </td>
    <td><?php echo $row->fstcreate;?></td>
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
