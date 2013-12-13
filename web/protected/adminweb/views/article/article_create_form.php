<?php if (CHtml::errorSummary($model)):?>
<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform','enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title" >文章名称：</td>    <td><?php echo $form->textField($model,'article_title',array('size'=>60,'maxlength'=>128,'class'=>'validate[required]')); ?></td>
  </tr>

   <tr>
    <td class="tb_title" >类别名称：</td><td><?php echo $form->dropDownList($model,'article_type',$article_type_list); ?></td>
  </tr>

  <tr>
     <td class="tb_title" >文章内容：</td>
<td>
  <?php echo $form->textArea($model,'article_content', array('class'=>'validate[required]')); ?>
 <?php $this->widget('application.widget.kindeditor.KindEditor',array(
    'target'=>array(
      '#Article_article_content'=>array('uploadJson'=>$this->createUrl('upload'),'extraFileUploadParams'=>array(array('sessionId'=>session_id()))))));?>
</td>
</tr>

<tr>
    <td class="tb_title">封面图片：</td>
  </tr>
  <tr >
    <td colspan="2" ><input name="attach" type="file" id="attach" />
      <?php if ($model->attach_file):?>
      <a href="<?php echo Yii::app()->request->baseUrl.'/'. $model->attach_file?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/'. $model->attach_file?>" width="50" align="absmiddle" /></a>
      <?php endif?></td>
  </tr>

 <tr>
    <td class="tb_title">组图：</td>
  </tr>
  <tr >
    <td><div>
        <p><a href="javascript:uploadifyAction('fileListWarp')" ><img src="<?php echo Yii::app()->request->baseUrl;?>/images/adminweb/create.gif" align="absmiddle">添加图片</a></p>
      </div></td> 
      <td><ul id="fileListWarp">
          <?php foreach((array)$imageList as $key=>$row):?>
          <?php if($row):?>
          <li id="image_<?php echo $row['fileId']?>"><a href="<?php echo Yii::app()->request->baseUrl;?>/<?php echo $row['file']?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl;?>/<?php echo $row['file']?>" width="40" height="40" align="absmiddle"></a>&nbsp;<br>
            <a href='javascript:uploadifyRemove("<?php echo $row['fileId']?>", "image_")'>删除</a>
            <input name="imageList[fileId][]" type="hidden" value="<?php echo $row['fileId']?>">
            <input name="imageList[file][]" type="hidden" value="<?php echo $row['file']?>">
          </li>
          <?php endif?>
          <?php endforeach?>
        </ul>
      </td>
  </tr>

  <tr>
    <td class="tb_title" >文章作者：</td>    <td><?php echo $form->textField($model,'article_author',array('size'=>60,'maxlength'=>128,'class'=>'validate[required]')); ?></td>
  </tr>

  <tr>
    <td class="tb_title" >点击次数：</td>    <td><?php echo $form->textField($model,'article_click_count',array('size'=>60,'maxlength'=>128)); ?></td>
  </tr>

  

  <tr>
    <td class="tb_title" >当前状态：</td><td><?php echo $form->dropDownList($model,'status',array('0'=>'启用', '1'=>'注销')); ?></td>
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

function uploadifyAction(fileField,frameId) {
    $.Zebra_Dialog('', {
        source: {
            'iframe': {
                'src': '?r=uploadify/basic',
                'height': 300,
                'name': 'bagecms_com',
                'id': 'bagecms_com'
            }
        },
        width: 600,
        'buttons': [
      {
        caption: '确认',
        callback: function() {
          var htmls = $(window.frames['bagecms_com'].document).find("#fileListWarp").html();
          if(htmls){
            $("#" + fileField).append(htmls);
          }else{
             alert('没有文件被选择');
          }
        }
      },
      {
        caption: '取消',
        callback: function() {
          return;
        }
      }
    ],
        'type': false,
        'title': '图片上传',
        'modal': false
    });
}


function uploadifyRemove(fileId,attrName){
  if(confirm('本操作不可恢复，确定继续？')){
    $.post("?r=uploadify/remove",{imageId:fileId},function(res){
      $("#"+attrName+fileId).remove();
    },'json');
  }
}

</script>
<?php $form=$this->endWidget(); ?>