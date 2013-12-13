<?php

function auto_extract_keywords($bt_auto_content,$bt_auto_len=5){
	require 'pscws4.class.php';
	$bt_auto_cws = new PSCWS4();
	$bt_auto_cws->set_charset('utf8');
	$bt_auto_cws->set_dict('dict.utf8.xdb');
	$bt_auto_cws->set_rule('rules.utf8.ini');
	$bt_auto_cws->send_text(preg_replace("/&[a-z]+\;/i",'',strip_tags($bt_auto_content)));
	$bt_auto_ret = array();
	$bt_auto_ret = $bt_auto_cws->get_tops($bt_auto_len,'r,v,p');
	$bt_auto_res = array();
	$bt_auto_i = 0;
	foreach ($bt_auto_ret as $tmp)
	{
		$bt_auto_res[$bt_auto_i] = $tmp['word'];
		$bt_auto_i++;
	}
	$bt_auto_cws->close();
	return $bt_auto_res;
}

print_r( auto_extract_keywords("我是中国人，我是中华名族的子孙！",3));
?>