<?php
class Excel
{
    
    public static function download_xls($filename, $head_array, $datalist){
        $m_objPHPExcel          = new PHPExcel();
        $m_exportType           = "excel";
        $m_strOutputExcelFileName   = $filename.".xls"; //输出EXCEL文件名
        $objActSheet            = $m_objPHPExcel->getActiveSheet();//取得当前活动表

        /*写入数据至表格*/
        $head_keys          = array_keys($head_array);
        $closnum            = count($head_keys);
        $cellsign           = 'A';

        /*表头*/
        for($i = 0; $i < $closnum; $i++){
            $thisC = $cellsign.'1';
            $objActSheet->setCellValue($thisC , $head_array[$head_keys[$i]]);
            /* $objActSheet->getColumnDimension($cellsign)->setAutoSize(true) 根据内容自动适应列宽，但不适合于中文 */
            //$objActSheet->getColumnDimension($cellsign)->setWidth(strlen($head_array[$head_keys[$i]])); 
            $cellsign++;
        }
 
        /*数据部分*/
        $rowsign  = 2;//从第二行开始
        foreach($datalist as $val){
                    $cellsign = 'A';//重定义从A开始
                    for($i = 0; $i < $closnum; $i++){
                        $thisC = $cellsign.$rowsign;  
                        //匹配<font color="red">sku</font>
                        if(preg_match('/<font(.*?)color=\"(.*)\">(.*)<[^>]*>/', $val[$head_keys[$i]],$stylecolor)){
                            $objActSheet->setCellValue($thisC ,$stylecolor[3]);
                            switch ($stylecolor[2]) {
                                case 'red':
                                    $color = "FFFF0000";
                                    break;
                                case 'blue':
                                    $color = "FF0000FF";
                                    break;
                                case 'green':
                                    $color = "FF00FF00";
                                    break;
                                case 'yellow':
                                    $color = "FFFFFF00";
                                    break;
                                default:
                                    $color = "FF000000";
                                    break;
                            }
                            //解决PHPExcel导出长数字末尾几位数为0的问题（预留空格）
                            $objActSheet->getStyle($thisC)->getFont()->getColor()->setARGB($color);    
                        }else{
                            $objActSheet->setCellValue($thisC ,$val[$head_keys[$i]]);
                        }
                        $cellsign++;
                    }
                    $rowsign++;
        } 
            
        /* 从浏览器直接输出$m_strOutputExcelFileName */
        $objWriter = PHPExcel_IOFactory::createWriter($m_objPHPExcel, 'Excel5');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type: application/vnd.ms-excel;");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=".$m_strOutputExcelFileName);
        header("Content-Transfer-Encoding:binary");
        $objWriter->save("php://output");

    }
    /*导出表格,弹出窗口下载*/
    public static function download_excel($filename,$head_array,$datalist){

        $output = "<HTML>";
        $output .= "<HEAD>";
        $output .= "<META http-equiv=Content-Type content=\"text/html; charset=utf-8\">";
        $output .= "</HEAD>";
        $output .= "<BODY>";
        $output .= Excel::arr_tbl_excel($head_array,$datalist);
        $output .= "</BODY>";
        $output .= "</HTML>";
        header("Content-type:application/msexcel");
        header("Content-disposition: attachment; filename=$filename.xls");
        header("Cache-control: private");
        header("Pragma: private");
        print($output);

    }


    /*导出表格内容处理*/
    public static function  arr_tbl_excel($head_array,$datalist){

        $ret = '';
        $ret .= '<table border=1><tr>';

        /*表头输出*/
        $head_keys = array_keys($head_array);
        for($i=0;$i<count($head_keys);$i++){
            $ret.='<td>'.trim($head_array[$head_keys[$i]]).'</td>';
        }
        $ret.='</tr>';

        /*内容输出*/
        foreach($datalist as $val){
            $ret.='<tr>';
            for($j=0;$j<count($head_keys);$j++){
                //if($head_keys[$j] == 'sku'){
                    $ret.='<td>'.trim($val[$head_keys[$j]]).'</td>';
                //}else{
                //  $ret.='<td>'.$val[$head_keys[$j]].'&nbsp;</td>';
                //}
            }
            $ret.='</tr>';
        }

        $ret.= '</table>';
        return $ret;
    }

    /*导出其它格式的文档,弹出窗口下载*/
    public static function download($filename,$msg,$ext){

        Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=$filename.$ext");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
        echo $msg;
        exit();
    }

    public static function get_upload_excel_datas($upload_dir, $fieldarray, $head = 1, $num = ''){
        $upload_ok = 0;
        $upload_file=$_FILES["file$num"]["name"];        //获取文件名
        $upload_tmp_file=$_FILES["file$num"]["tmp_name"];      //获取临时文件名
        $upload_filetype=$_FILES["file$num"]["type"];    //获取文件类型
        $upload_status=$_FILES["file$num"]["error"];   //获取文件出错情况
        //指定文件存储路径
        $errorchar=array ("-"," ","~","!","@","#","$","%","^","&","(",")","+",","," （","）","？","！","《","》","：","；","——");//非法字符
        foreach($errorchar as $char)
        {
            if(strpos($upload_file,$char)){
                $upload_file=str_replace($char,"_",$upload_file);
            }
        }//循环排除替换文件名中的非法字符
        ///PRINT_R($upload_file);
        //echo '<pre>';print_r($_FILES);DIE();
        $upload_path=$upload_dir.date('Y_m_d_his',time()).$upload_file;   //定义文件最终的存储路径和名称
        //print_r($_FILES);die();
        //$this->getLibrary('basefuns')->setsession('filepath'.$num, $upload_path);
        $_SESSION["filepath$num"] = $upload_path;
        if(is_uploaded_file($upload_tmp_file) ){

            switch($upload_status){
                case 0:$message_upload="";break;
                case 1:$message_upload="上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。";break;
                case 2:$message_upload="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。";break;
                case 3:$message_upload="文件只有部分被上传。";break;
                case 4:$message_upload="没有文件被上传。";break;
                case 6:$message_upload="没有找到临时文件目录。";break;
                case 7:$message_upload="文件写入失败。";break;
            }                   //分析文件出错情况并给出提示
            if(file_exists($upload_path)){

                $message_upload="同名文件已经存在，请修改你要上传的文件名！";              //检查是否有相同文件存在
            }else if(move_uploaded_file($upload_tmp_file,$upload_path)){

                 $message_upload="文件已经成功上传，请核对下面的数据是否正常";
                 $upload_ok = 1;//读取已经成功上传的文件
                if($upload_ok){//检查数据是否正确
                    $all_arr = Excel::get_excel_datas_withkey($upload_path, $fieldarray, $head);
                }
            }
        }

        return $all_arr;
    }

    //指定列表值来取得数据，并按照对应的key来处理
    public static function get_excel_datas_withkey($filepath, $fieldarray,$head){
        if(file_exists($filepath)){
            $php_excel_obj = new PHPExcel();
            $php_reader = new PHPExcel_Reader_Excel2007();

            $file_name = $filepath;

            if(!$php_reader->canRead($file_name)){
                $php_reader= new PHPExcel_Reader_Excel5();
                if(!$php_reader->canRead($file_name)){
                    $message_upload = 'NO Excel!';
                }
            }
            $php_excel_obj = $php_reader->load($file_name);
            $current_sheet =$php_excel_obj->getSheet(0);

            $all_column =$current_sheet->getHighestColumn();
            $column_len = strlen($all_column);
            $all_row =$current_sheet->getHighestRow();

            $all_arr = array();
            $c_arr = array();

            $head = ($head and is_int($head))?$head:1;
            $key_arr = array();
            //字符对照表
            for($r_i = 1; $r_i<=$all_row; $r_i++){
                $c_arr= array();
                if($r_i==$head){
                    foreach($fieldarray as $c_i){
                        $adr= $c_i . $r_i;
                        $value= $current_sheet->getCell($adr)->getValue();
                        if(is_object($value)) $value= $value->__toString();
                        $key_arr[$c_i]= trim($value);//取第$head行作为列的key值
                    }
                    $all_arr[] =  $key_arr;
                }else{//取其它行的数值
                    foreach($fieldarray as $c_i){
                        $adr= $c_i . $r_i;
                        $value= $current_sheet->getCell($adr)->getValue();
                        if(is_object($value)) $value= $value->__toString();
                        if(strlen($key_arr[$c_i])){
                            $c_arr[$key_arr[$c_i]]= trim($value);
                        }
                    }
                    $all_arr[] =  $c_arr;
                }
            }//excel表数据转化为数组
            //unset($all_arr[$head]);
            return $all_arr;
        }
        //else{
        //  echo '文件名不存在';
        //}
    }


}
?>