<?php
class ExcelController extends Controller
{
	public function actionIndex()
	{
		 $filename = 'excel_'.date('Y-m-d H:i:s',time());
		 $head_array = array('id'=>'编号','name'=>'名字');
		 $datalist = array(array('id'=>1,'name'=>'lizhi'),array('id'=>2,'name'=>'jerry'));
		 Excel::download_xls($filename, $head_array, $datalist);
	}
}
?>