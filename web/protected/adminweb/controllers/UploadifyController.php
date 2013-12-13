<?php
class UploadifyController extends Controller{

    /**
     * 基本上传
     *
     * @return [type] [description]
     */
    public function actionBasic() {
        $this->render( 'basic', $data );
    }

    /**
     * 上传
     */
    public function actionBasicExecute() {
        if (Bases::method() == 'POST' ) {
            $file = Xupload::upload( $_FILES['imgFile'] );
            if ( is_array( $file ) ) {
                $model = new Upload();
                $model->user_id = Yii::app() -> session['uid'];
                $model->file_name = $file['pathname'];
                $model->thumb_name = $file['paththumbname'];
                $model->real_name = $file['name'];
                $model->file_ext = $file['extension'];
                $model->file_mime = $file['type'];
                $model->file_size = $file['size'];
                $model->save_path = $file['savepath'];
                $model->hash = $file['hash'];
                $model->save_name = $file['savename'];
                $model->create_time = time();
                if ( $model->save() ) {
                    exit( CJSON::encode( array ( 'state' => 'success' , 'fileId'=>$model->id, 'realFile'=>$model->real_name, 'message' => '上传成功' , 'file' =>  $file['pathname'] ) ) );
                } else {
                    @unlink( $file['pathname'] );
                    exit( CJSON::encode( array ( 'state' => 'error' , 'message' => '数据写入失败，上传错误' ) ) );
                }

            } else {
                exit( CJSON::encode( array ( 'error' => 1 , 'message' => '上传错误' ) ) );
            }
        }
    }

     /**
     * 删除附件
     * @return [type] [description]
     */
    public function actionRemove() {
        $imageId = intval( Yii::app()->request->getParam( 'imageId' ) );
        try {
            $imageModel = Upload::model()->findByPk( $imageId );
            if ( $imageModel ==false )
                throw new Exception( "附件已经被删除" );
            @unlink( $imageModel->file_name );
            @unlink( $imageModel->thumb_name );
            if ( !$imageModel->delete() )
                throw new Exception( "数据删除失败" );
            $var['state'] = 'success';
            $var['message'] = '删除完成';
        } catch ( Exception $e ) {
            $var['state'] = 'error';
            $var['message'] = '失败：'.$e->getMessage();
        }
        exit( CJSON::encode( $var ) );
    }

}
