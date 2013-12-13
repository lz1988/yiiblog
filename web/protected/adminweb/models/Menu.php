<?php
class Menu extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'menu';
	}

	public function rules()
	{
		return array(
			array('menuname','required','message' => '菜单不能为空'),
			array('pid','required','message' => '所属菜单不能为空'),
			array('sort','required','message' => '排序不能为空'),
			array('url','required','message'=>'路径不能为空'),
            array('status','required','message'=>'状态不能为空'),
			array('menuname, url', 'length', 'max'=>120),
		);
	}

    /*菜单无限极分类*/
	static public function get($parentid = 0, $array = array(), $level = 0, $add = 2, $repeat = '&nbsp;&nbsp;&nbsp;&nbsp;') {
        
        $str_repeat = '';
        if ($level) {
            for($j = 0; $j < $level; $j ++) {
                $str_repeat .= $repeat;
            }
        }
        $newarray = array ();
        $temparray = array ();
        foreach ( ( array ) $array as $v ) {
            if ($v ['pid'] == $parentid) {
                $newarray [] = array ('id' => $v ['id'], 'menuname' => $v ['menuname'], 
                'pid' => $v ['pid'], 'level' => $level, 'sort' => $v ['sort'],'status'=>$v ['status'],'str_repeat' => $str_repeat,'url'=> $v['url'] );
    
                $temparray = self::get ( $v ['id'], $array, ($level + $add) );
                if ($temparray) {
                    $newarray = array_merge ( $newarray, $temparray );
                }
            }
        }
        return $newarray;
    }
    
}
?>