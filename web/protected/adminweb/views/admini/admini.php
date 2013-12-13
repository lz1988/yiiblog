<?php
$this->pageTitle=Yii::app()->name . ' - 管理员';
$this->breadcrumbs=array(   
    '管理员' 
);

?>
<div class="searchArea">
    <ul class="action left">
      <li><a href="<?php echo $this->createUrl('admini/create')?>" class="actionBtn"><span>录入</span></a></li>
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
      <input id="adminname" type="text" name="adminname" value="" class="txt" size="15"/>
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
  $("#adminname").val('<?php echo Yii::app()->request->getParam('adminname')?>');
  $("#status").val('<?php echo Yii::app()->request->getParam('status')?>');
});
</script>

<form method="post" action="<?php echo $this->createUrl('admini/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="6%">编号</th>
    <th>用户名</th>
    <th width="10%">密码</th>
    <th width="8%">状态</th>
    <th width="10%">邮箱</th>
    <th width="15%">创建时间</th>
    <th width="15%">上次登陆时间</th>
    <th width="10%">登陆次数</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row->id?>"></td>
    <td><?php echo $row->id;?></td>
    <td><?php echo $row->adminname;?></td>
    <td><?php echo $row->adminpwd;?></td>
    <td>
    <?php if($row->status == '0'):?>
    启用
    <?php else:?>
    注销
    <?php endif; ?>
    </td>
    <td><?php echo $row->email;?></td>
    <td><?php echo $row->fstcreate;?></td>
    <td><?php echo $row->last_time;?></td>
    <td><?php echo $row->login_count;?></td>
    <td> <a href="<?php echo  $this->createUrl('update',array('id'=>$row['id']))?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/update.png" align="absmiddle" /></a> 
      <a href="<?php echo  $this->createUrl('command',array('command'=>'delete','id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/delete.png" align="absmiddle" /></a></td>
  </tr>
     <?php endforeach;?>
 <tr class="operate">
      <td colspan="7">
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
