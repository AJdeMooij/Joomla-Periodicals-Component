<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Periodicals Model
 */
class PeriodicalsModelPeriodicals extends JModelItem
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param       type    The table type to instantiate
	 * @param       string  A prefix for the table class name. Optional.
	 * @param       array   Configuration array for model. Optional.
	 * @return      JTable  A database object
	 * @since       2.5
	 */
	public function getTable($type = 'Details', $prefix = 'ThermometerTable', $config = array()) 
	{
			return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		parent::populateState();

	}

	public function getItems()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select(
				$this->getState(
					'list.select',
					'a.id,a.file,a.year,a.month,a.day, 
					CONVERT(if(
						instr(month, ",") > 0, 
						LEFT(month, instr(month, ",") - 1),
						month
					),DECIMAL) as firstmonth, 
					CONVERT(if(
						INSTR(",", day),
						LEFT(day, INSTR(day, ",")),
						day
					),DECIMAL) as firstday'
				)
			)
			->from($db->quoteName('#__periodicals') . ' AS a')
			->where('published=1')
			->order(array('year desc', 'firstmonth desc', 'firstday desc'));

		$db->setQuery($query);
		return $db->loadObjectList();
	}

}
