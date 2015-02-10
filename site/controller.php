<?php
/**
* @package Joomla.Administrator
* @subpackage com_periodicals
*
* @copyright Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Periodicals Component Controller
 *
 * @since   0.0.1
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
		require_once JPATH_SITE . '/administrator/components/' . JRequest::getVar('option') . '/helpers/periodicals.php';

		parent::display($cachable, $urlparams);
	}
}

