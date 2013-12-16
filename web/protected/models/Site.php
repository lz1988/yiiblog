<?php
class Site extends CActiveRecord
{
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'site';
	}

	public function rules()
	{
		return array(
			array('site_content','required'),
			
		);
	}

	function jsons($id)
	{
		$row = Votes::model()->find(array('condition'=>'vid = :ID','params'=>array(':ID'=>$id)));
		$like 	= $row['likes'];
		$unlike = $row['unlikes'];
		$arr['success'] = 1;
		$arr['like']    = $like;
		$arr['unlike']  = $unlike;
		$like_percent   = round($like/($like+$unlike),3)*100;
		$arr['like_percent'] = $like_percent.'%';
		$arr['unlike_percent'] = (100-$like_percent).'%';
	
		return json_encode($arr);
	}

	function likes($type,$id,$ip)
	{
		$count = Votes::model()->count(array('condition'=>'vid = :ID and ip=:IP','params'=>array(':ID'=>$id,':IP'=>$ip)));
		if($count==0)
		{
			if($type==1)
			{
				Votes::model()->updateCounters(array('likes'=>1),'vid = '.$id);  
			}else{
				Votes::model()->updateCounters(array('unlikes'=>1),'vid = '.$id);  
			}

			$votes = new Votes;
			$votes['vid'] = $id;
			$votes['ip']  = $ip;
			$votes->save();
 			echo $this->jsons($id);
		}else{
			$msg = $type==1?'您已经顶过了':'您已经踩过了';
			$arr['success'] = 0;
			$arr['msg'] = $msg;
			echo json_encode($arr);
		}
 	}

}
?>