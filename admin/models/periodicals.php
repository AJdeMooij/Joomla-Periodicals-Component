<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * PeriodicalsList Model
 */
class PeriodicalsModelPeriodicals extends JModelList
{
	/**
	 * Config
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
			'id', 'a.id',
			'file', 'a.file',
			'upload_filename', 'a.upload_filename',
			'year', 'a.year',
			'month', 'a.month',
			'day', 'a.day',
			'date',
			'published', 'a.published'
			);
		}
		parent::__construct($config);
	}

	/**
	 * Populate state with ordering
	 */
	protected function populateState($ordering = null, $direction = null)
    {
        parent::populateState('date', 'desc');
    }

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// Select some fields from the hello table
		$query
		    ->select(
		    	$this->getState(
		    		'list.select',
		    		'a.id,a.file,a.upload_filename,a.year,a.month,a.day,a.published,
		    		concat(year,RIGHT(CONCAT("00",a.month),2),RIGHT(CONCAT("00",day),2)) as date'
		    	)
		    )
		    ->from($db->quoteName('#__periodicals') . ' AS a')
		    ->order($db->escape($this->getState('list.ordering', 'default_sort_column')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
 
		return $query;
	}

}
