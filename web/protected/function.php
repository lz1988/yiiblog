<?php
	

	/*无限极分类*/
	function gettree($arr){
		$t = array();
			foreach($arr as $v){
			if (isset($arr[$v['pid']])){
					$arr[$v['pid']]['children'][] = &$arr[$v['id']];
				}else{
					$t[] = &$arr[$v['id']];
				}
			}
		return $t;
	}

	function find_child($ar, $id='id', $pid='pid') {
		foreach($ar as $v) $t[$v[$id]] = $v;
			foreach ($t as $k => $item){
				if( $item[$pid] ) {
					$t[$item[$pid]]['children'][] =&$t[$k];
					unset($t[$k]);
			}
		}
		return $t;
	}
	/**
	* 无限极分类
	* @param $list array 要分类的数组
	* @param $parent_id int 当前分类的父id
	* @param $deep int当前调用递归的深度
	* @return array 返回按层级排序好的数组
	*/
	function tree(&$list,$parent_id,$deep){
		static $tree = array();
		foreach($list as $v){
			if($v['pid'] == $parent_id){
				$v['sort'] = $deep;
				$tree[] = $v;
				//$items[$item['parentid']]['son'][] = &$items[$item['id']];
				tree($list,$v['id'],$deep+1);
			}
		}
		return $tree;
	}


	function tree1($arr=array(),$start=0,$pidname='pid',$id='id',$newarr=array(),$levle=0,$pname='',$name='name'){
	    if(!is_array($arr)) return $arr;     //不是数组原样返回
	    foreach ($arr as $k=>$v){
	            if($v[$pidname]==$start){  //从传递的起始字段值符合条件的开始处理
	                $arr[$k]['level']=$levle;  //动态生成级别字段数据
	                $arr[$k]['pname']=$pname.$v[$name];  //动态生成父级字段数据
	                $newpname =$pname.$v[$name].'&nbsp>&nbsp';  //在动态生成父级字段数据后面加上'>'显示层级关系
	                $newlevel=$levle+1;  //处理完级别字段++方便传递给当前的子级使用
	                $newarr[count($newarr)]=$arr[$k];  //保存当前数据到新数组中
	                $newarr=tree($arr,$v[$id],$pidname,$id,$newarr,$newlevel,$newpname,$name);  //开始归递
	            }
	        }
	        return $newarr; //返回数据
	}

	function genTree5($items) { 
	    foreach ($items as $item) 
	       $items[$item['parentid']]['children'][$item['id']] = &$items[$item['id']]; 
	    return isset($items[0]['children']) ? $items[0]['children'] : array(); 
	} 


	function genTree9($items) {
	    $tree = array(); //格式化好的树
	    foreach ($items as $item)
	        if (isset($items[$item['pid']]))
	            $items[$item['pid']]['son'][] = &$items[$item['id']];
	        else
	            $tree[] = &$items[$item['id']];
	    return $tree;
	}


?>