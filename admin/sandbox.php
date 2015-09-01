<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JPATH_COMPONENT . '/helper.php' );

// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by HelloWorld
//Search for class SandboxController in file controller.php
$controller = JControllerLegacy::getInstance('Sandbox');
 
// Perform the Request task
// When no task is given in the request variables, the default task will be executed.
// It's the display task by default. The JController class has such a task. 
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();


