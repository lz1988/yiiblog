
<html>
	<head>
	<meta charset="urf-8"/>
	<title>分词系统</title></head>
		<body>
		<form name="form" action="" method="post">
		<input type="text" name="keyword" style="width:500px;height:100px;"/>
		<input type="submit" value="操作" name="submit"/>
		</form>
		</body>
		</html>
<?php

function auto_extract_keywords($bt_auto_content,$bt_auto_len=5){
	include_once('pscws4.class.php');
	$bt_auto_cws = new PSCWS4();
	$bt_auto_cws->set_charset('utf8');
	$bt_auto_cws->set_dict('dict.utf8.xdb');
	$bt_auto_cws->set_rule('rules.utf8.ini');
	$bt_auto_cws->send_text(preg_replace("/&[a-z]+\;/i",'',strip_tags($bt_auto_content)));
	$bt_auto_ret = array();
	//print_r($bt_auto_cws);
	$bt_auto_ret = $bt_auto_cws->get_tops($bt_auto_len,'r,v,p');
	//echo '<pre>';print_r($bt_auto_cws);
	$bt_auto_res = array();
	$bt_auto_i = 0;
	//echo '<pre>';print_r($bt_auto_ret);
	if ($bt_auto_ret){
		foreach ($bt_auto_ret as $tmp)
		{
			$bt_auto_res[$bt_auto_i] = $tmp['word'];
			$bt_auto_i++;
		}
		$bt_auto_cws->close();
		return $bt_auto_res;
	}
}

$keyword = $_POST['keyword'];
if (!empty($keyword)){

	$str = implode('|',auto_extract_keywords($keyword,20));
	/*$str1 = '早在秦汉、三国时期便闻名全国。今天的锦里依托成都武侯祠，以秦汉、三国精神为灵魂，明、清风貌作外表，川西民风、民俗作内容，扩大了三国文化的外延。在这条街上，浓缩了成都生活的精华：有茶楼、客栈、酒楼、酒吧！';
	$str2 = implode('|',auto_extract_keywords($str1,20));
	similar_text($str,$str2,$percent);
	
	if (number_format($percent,0)>80){
		echo '80% is ok';
		
	}else{
		echo 'this is no 80%';
	}*/
	echo "<br>";echo $str;
}

?>