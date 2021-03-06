<?php

class SiteController extends Controller
{
	/**
	 * Declares the behaviors.
	 * @return array the behaviors
	 */
	public function behaviors()
	{
		return array(
			'seo'=>'ext.seo.components.SeoControllerBehavior',
		);
	}

	/**
	 * Declares class-based actions.
	 * @return array the actions
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$model = new TestForm();

		$gridDataProvider = new CArrayDataProvider(array(
			array('id'=>1, 'firstName'=>'Mark', 'lastName'=>'Otto', 'language'=>'CSS'),
			array('id'=>2, 'firstName'=>'Jacob', 'lastName'=>'Thornton', 'language'=>'JavaScript'),
			array('id'=>3, 'firstName'=>'Stu', 'lastName'=>'Dent', 'language'=>'HTML'),
		));

		$gridColumns = array(
			array('name'=>'id', 'header'=>'#'),
			array('name'=>'firstName', 'header'=>'First name'),
			array('name'=>'lastName', 'header'=>'Last name'),
			array('name'=>'language', 'header'=>'Language'),
			array(
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'htmlOptions'=>array('style'=>'width: 50px'),
				'viewButtonUrl'=>null,
				'updateButtonUrl'=>null,
				'deleteButtonUrl'=>null,
			)
		);

		$rawData = array();
		for ($i = 0; $i < 100; $i++)
			$rawData[] = array('id'=>$i + 1);

		$listDataProvider = new CArrayDataProvider($rawData, array(
			'pagination'=>array('pageSize'=>8),
		));

		$this->render('index', array(
			'model'=>$model,
			'gridDataProvider'=>$gridDataProvider,
			'gridColumns'=>$gridColumns,
			'listDataProvider'=>$listDataProvider,
			'parser'=>new CMarkdownParser(),
		));
	}

	public function actionSetup()
	{
		$parser = new CMarkdownParser();
		Yii::app()->clientScript->registerCss('TextHighligther', file_get_contents($parser->getDefaultCssFile()));

		$this->render('setup', array(
			'parser'=>$parser,
		));
	}

	public function actionMaintenance()
	{
		$this->layout = '/layouts/maintenance';
		$this->render('maintenance');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}