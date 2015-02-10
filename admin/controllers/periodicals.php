<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Kerknieuws Controller
 */
class PeriodicalsControllerPeriodicals extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'periodical', $prefix = 'PeriodicalsModel', $config = Array()) 
	{
		$model = parent::getModel($name, $prefix, array_merge($config, array('ignore_request' => true)));
		return $model;
	}

	public function delete()
	{
		// Import filesystem
		jimport('joomla.filesystem.file');

		// Get the ID's of the deleted files
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');

		// Delete the files
		$table = $this->getModel()->getTable();
		foreach($cid as $ci)
		{
			$table->load($ci);
			Jfile::delete($table->file);
		}

		// Delete the records
		parent::delete();
	}
}