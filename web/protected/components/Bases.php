<?php
class Bases{

     /**
     * 查询字符生成
     */
    static public function mapcondition( array $getArray, array $keys = array() ) {
        if ( $getArray ) {
            foreach ( $getArray as $key => $value ) {
                if ( in_array( $key, $keys ) && $value != "" ) {
                    $arr[$key] = CHtml::encode(strip_tags($value));
                   
                }
            }
            $arr = is_array($arr)?$arr:array();
            $_SESSION['row'] = $arr;
            return $arr;
        }
    }

    /**
     * 获得来源类型 post get
     *
     * @return unknown
     */
    static public function method() {
        return strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : 'GET' );
    }

    /**
     * 提示信息
     */
    static public function message( $action = 'success', $content = '', $redirect = 'javascript:history.back(-1);', $timeout = 4 ) {

        switch ( $action ) {
        case 'success':
            $titler = '操作完成';
            $class = 'message_success';
            $images = 'message_success.png';
            break;
        case 'error':
            $titler = '操作未完成';
            $class = 'message_error';
            $images = 'message_error.png';
            break;
        case 'errorBack':
            $titler = '操作未完成';
            $class = 'message_error';
            $images = 'message_error.png';
            break;
        case 'redirect':
            header( "Location:$redirect" );
            break;
        case 'script':
            if ( empty( $redirect ) ) {
                exit( '<script language="javascript">alert("' . $content . '");window.history.back(-1)</script>' );
            } else {
                exit( '<script language="javascript">alert("' . $content . '");window.location=" ' . $redirect . '   "</script>' );
            }
            break;
        }

        // 信息头部
        $header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>操作提示</title>
<style type="text/css">
body{font:12px/1.7 "\5b8b\4f53",Tahoma;}
html,body,div,p,a,h3{margin:0;padding:0;}
.tips_wrap{ background:#F7FBFE;border:1px solid #DEEDF6;width:780px;padding:50px;margin:50px auto 0;}
.tips_inner{zoom:1;}
.tips_inner:after{visibility:hidden;display:block;font-size:0;content:" ";clear:both;height:0;}
.tips_inner .tips_img{width:80px;float:left;}
.tips_info{float:left;line-height:35px;width:650px}
.tips_info h3{font-weight:bold;color:#1A90C1;font-size:16px;}
.tips_info p{font-size:14px;color:#999;}
.tips_info p.message_error{font-weight:bold;color:#F00;font-size:16px; line-height:22px}
.tips_info p.message_success{font-weight:bold;color:#1a90c1;font-size:16px; line-height:22px}
.tips_info p.return{font-size:12px}
.tips_info .time{color:#f00; font-size:14px; font-weight:bold}
.tips_info p a{color:#1A90C1;text-decoration:none;}
</style>
</head>

<body>';
        // 信息底部
        $footer = '</body></html>';

        $body = '<script type="text/javascript">
        function delayURL(url) {
        var delay = document.getElementById("time").innerHTML;
        //alert(delay);
        if(delay > 0){
        delay--;
        document.getElementById("time").innerHTML = delay;
    } else {
    window.location.href = url;
    }
    setTimeout("delayURL(\'" + url + "\')", 1000);
    }
    </script><div class="tips_wrap">
    <div class="tips_inner">
        <div class="tips_img">
            <img src="' . Yii::app()->request->baseUrl. '/images/adminweb/' . $images . '"/>
        </div>
        <div class="tips_info">

            <p class="' . $class . '">' . $content . '</p>
            <p class="return">系统自动跳转在  <span class="time" id="time">' . $timeout . ' </span>  秒后，如果不想等待，<a href="' . $redirect . '">点击这里跳转</a></p>
        </div>
    </div>
</div><script type="text/javascript">
    delayURL("' . $redirect . '");
    </script>';

        exit( $header . $body . $footer );
    }


    /*修改操作获取主键id*/
    public function loadModel($model, $id)
    {
        if(isset($id))
            $data=$model->findbyPk($id);
        if($data===null)
            throw new CHttpException(404,'The requested object does not exist.');
        else
            return $data;
    }

    /*后台日志记录*/
    public static function adminiLogger($arr = array())
    { 
        $model = new log();
        $model->attributes = $arr;
        !isset($arr['uname']) && $model->uname = Yii::app() -> session['uname'];
        $model->url = Yii::app()->request->getRequestUri();
        $model->ip  = Yii::app()->request->userHostAddress;
        if (!$model->save()){
            print_r($model->getErrors());exit();
        }
            
    }

    /*截取字符串*/
    public static function truncate_utf8_string($string, $length, $etc = '...')
       {
           $result = '';
           $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
           $strlen = strlen($string);
           for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
               {
               if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
                       {
                   if ($length < 1.0)
                               {
                       break;
                   }
                   $result .= substr($string, $i, $number);
                   $length -= 1.0;
                   $i += $number - 1;
               }
                       else
                       {
                   $result .= substr($string, $i, 1);
                   $length -= 0.5;
               }
           }
           $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
           if ($i < $strlen)
               {
                       $result .= $etc;
           }
           return $result;
       }

        /**
     * [格式化图片列表数据]
     *
     * @return [type] [description]
     */
    public static function imageListSerialize( $data ) {

        foreach ( (array)$data['file'] as $key => $row ) {
            if ( $row ) {
                $var[$key]['fileId'] = $data['fileId'][$key];
                $var[$key]['file'] = $row;
            }

        }
        return array( 'data'=>$var, 'dataSerialize'=>empty( $var )? '': serialize( $var ) );

    }

    /*比对文章相似性，$title当前标题，$arrayTitle为需要查找的数组*/
    public static function getSimilar($title,$arr_title)
    {
        $arr_len = count($arr_title);
        for($i=0; $i<=($arr_len-1); $i++)
        {
            //取得两个字符串相似的字节数
            $arr_similar[$i] = similar_text($arr_title[$i],$title);
        }
        arsort($arr_similar);   //按照相似的字节数由高到低排序
        reset($arr_similar);    //将指针移到数组的第一单元
        $index = 0;
        foreach($arr_similar as $old_index=>$similar)
        {
            $new_title_array[$index] = $arr_title[$old_index];
            $index++;
        }
        return $new_title_array;
    }

    static function arr_menu(){
        return array('dddddddddd');
    }
}
?>