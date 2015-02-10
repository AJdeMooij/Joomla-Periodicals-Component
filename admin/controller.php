<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * General Controller of Periodicals component
 */
class PeriodicalsController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) 
	{
		// Require helpers
		require_once JPATH_COMPONENT . '/helpers/periodicals.php';

		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'Periodicals'));
 
		// call parent behavior
		parent::display($cachable);
	}
}
