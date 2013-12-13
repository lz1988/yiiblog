<?php
$this->pageTitle=Yii::app()->name . ' - 站点信息';
$this->breadcrumbs=array(   
    '站点信息'
);
?>

<div class="searchArea">
   <ul class="action left">
      <li><a href="<?php echo $this->createUrl('site/create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
  </div>

<form method="post" action="<?php echo $this->createUrl('site/command')?>" name="baseform" >
<table border="0" cellpadding="0" cellspacing="0" class="content_list">
  <tr class="tb_header">
    <th width="2%"></th>
    <th width="5%">编号</th>
    <th width="8%">标题</th>
    <th width="">内容</th>
     <th width="15%">创建时间</th>
    <th width="8%">操作</th>
  </tr>
  <?php foreach ($datalist as $row):?>
  <tr class="tb_list">
    <td><input type="checkbox" name="id[]" value="<?php echo $row['id']?>"></td>
    <td><?php echo $row['id'];?></td>
    <td><?php echo $row['site_title'];?>
      <?php if ($row['status'] == 1):?>
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/error.png" align="absmiddle" />
      <?php endif;?>
    </td>  
    <td><?php echo Bases::truncate_utf8_string($row['site_content'],120,flase);?></td>
    <td><?php echo $row['fstcreate'];?></td>
    <td><a href="<?php echo  $this->createUrl('update',array('id'=>$row['id']))?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/update.png" align="absmiddle" /></a> 
      <a href="<?php echo  $this->createUrl('command',array('command'=>'delete','id'=>$row['id']))?>" class="confirmSubmit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/adminweb/delete.png" align="absmiddle" /></a></td>
  </tr>
     <?php endforeach;?>
  <tr class="operate">
      <td colspan="8">
        <div class="cuspages right">
       
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
