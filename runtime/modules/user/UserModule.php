<?php
class UserModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));

		$this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'site/error'),
            'user' => array(
                'class' => 'CWebUser',             
                'loginUrl' => Yii::app()->createUrl('/login'),
            )
        ));

        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.business.views.layouts');
        $this->layout = 'column2';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
        $controller->layout = 'column2';
        $publicController = array('register');
        if (!$this->isDefaultUser()){     
           Yii::app()->controller->redirect('/');
        }
        elseif(Yii::app()->user->isGuest && !in_array($controller->id, $publicController))
        {
          Yii::app()->controller->redirect('/');
        }
        else  
        {
            Yii::app()->widgetFactory->widgets['CBreadcrumbs']=array( 'homeLink'=>CHtml::link('Home', array('/admin')));
            return true;  
        }
        }  
        else  
          return false;  
      }  

      public function isDefaultUser()
      {
      		if(!Yii::app()->user->isGuest && Yii::app()->user->_user_Type!='user')
      			return false;
      		else
      			return true;
      }
}
