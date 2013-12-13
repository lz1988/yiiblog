<?php
 /**
*@title 操作日志管理
*@author lizhi 513245459@qq.com
*@create on 2013-11-21
*/

class LogController extends Controller
{
	public $breadcrumbs=array();
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id desc' ;
		$condition 	= '1';
		$uname 			= Yii::app()->request->getParam('uname');
		$create_time	= Yii::app()->request->getParam('create_time'); 
		$uname && $condition .= ' AND uname LIKE \'%' . $uname . '%\'';
		$create_time && $condition 	.= ' AND create_time  like \'%'. $create_time.'%\'';
		$criteria->condition = $condition;
        $count = Log::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 100;         
        $pages->applyLimit($criteria);
        $parameter  = Bases::mapcondition( $_GET, array ( 'uname' , 'create_time') );
        $pages->params = $parameter;
        $datalist = Log::model()->findAll($criteria);
		$this->render('index',array('datalist'=>$datalist,'pagebar'=>$pages));		
	}

	/**
	*日志批量操作
	*/
	public function actionCommand()
	{
		if ( Bases::method() == 'GET' ) {
            $command = trim( $_GET['command'] );
            $ids = intval( $_GET['id'] );
        } elseif ( Bases::method() == 'POST' ) {
            $command = trim( $_POST['command'] );
            $ids = $_POST['id'];
            is_array( $ids ) && $ids = implode( ',', $ids );
        } else {
            Bases::message( 'errorBack', '只支持POST,GET数据' );
        }

        empty( $ids ) && Bases::message( 'error', '未选择记录' );

        switch ( $command ) {
        case 'delete':
            $user = new Log;
            $ret = $user->deleteAll( 'id IN(' . $ids . ')' );
            $this->redirect(array('index'));
            break;
        
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
	}

    /**
    *@title 操作日志导出
    *@author lizhi 513245459@qq.com
    *@create on 2013-11-20
    */
    public function actionOutput()
    {
        $filename      = 'excel_'.date('Y-m-d H:i:s',time());
        $head_array    = array('uname'=>'用户名','create_time'=>'创建时间','ip'=>'ip','catalog'=>'类型','intro'=>'动作');
        $criteria = new CDbCriteria();
        $criteria->order = 'id desc' ;
        $condition  = '1';
        $uname          = Yii::app()->request->getParam('uname');
        $create_time    = Yii::app()->request->getParam('create_time'); 
        $uname && $condition .= ' AND uname LIKE \'%' . $uname . '%\'';
        $create_time && $condition  .= ' AND create_time  like \'%'. $create_time.'%\'';
        $criteria->condition = $condition;
        $datalist = Log::model()->findAll($criteria);
        Excel::download_xls($filename, $head_array, $datalist);
    }

     /**
    *@title 操作日志导入
    *@author lizhi 513245459@qq.com
    *@create on 2013-11-21
    */
    public function actionExport()
    {
        $this->render('export_log');
    }

     /**
    *@title 操作日志导入操作
    *@author lizhi 513245459@qq.com
    *@create on 2013-11-21
    */
    public function actionExportmod()
    {   
        $fieldarray = array('A','B','C','D','E','F','G');//有效的excel列表值
        $all_arr    = Excel::get_upload_excel_datas(UPLOAD_DIR, $fieldarray);
        //die($_SESSION['filepath']);
        if (isset($_SESSION['filepath'])) unlink($_SESSION['filepath']);
        unset($all_arr[0]);
        $transaction = Yii::app ()->db->beginTransaction ();
        try 
        {
            foreach($all_arr as $v){
                $model = new Log;
                $model->uname   = $v['uname'];
                $model->url     = $v['url'];
                $model->intro   = $v['intro'];
                $model->catalog = $v['catalog'];
                $model->ip      = Yii::app()->request->userHostAddress;
                if (!$model->save()){
                    throw new Exception ('exception message');
                }   
            }
            $transaction->commit();
            $this->redirect(array('index'));
        }
        catch (Exception  $e){
            $transaction->rollBack();
        }
            
    }
}
?>