<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $menuarr = array(
				array('label'=>'博客首页', 'url'=>array('/site')),
				//array('label'=>'关于我', 'url'=>array('/site/about')),
				//array('label'=>'联系我', 'url'=>array('/contact')),
				//array('label'=>'登陆', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
    );

    public function arrmenu(){

       $ar = Yii::app()->db->createCommand('SELECT article_type_name FROM article_type order by id desc')->queryAll();
       $re[0]['label'] = "首页";
       $re[0]['url'][] = "/site/index";
       for($i = 1; $i < count($ar)+1; $i++){
           $re[$i]['label']   = $ar[$i]['article_type_name'];
           $re[$i]['url'][]     = "/article-".$ar[$i]['article_type_name'];
       }
       return $re;


        //echo '<pre>';print_r($re);

    }
}