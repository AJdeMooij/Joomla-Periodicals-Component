<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance('Periodicals');
 
// Perform the Request task and Execute request task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
