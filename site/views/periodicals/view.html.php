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
* HTML View class for the Periodicals Component
*
* @since 0.0.1
*/
class PeriodicalsViewPeriodicals extends JViewLegacy
{
	protected $params;
	protected $items;
	protected $state;
	protected $settings;

	/**
         * Display the Periodicals view
         *
         * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
         *
         * @return  void
         */
	public function display($tpl = null) 
	{
		// prepare data
		$state	= $this->get('State');
		$params = $state->get('params');
		$items = $this->get('Items');
		$settings = JComponentHelper::getParams('com_periodicals');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
			return false;
		}

		// Set data for the view
		$this->state = $state;
		
		$this->params = $params;
		$this->settings = $settings;
 		$this->items = (empty($items)) ? array() : $this->_prepareItems($items);

		// Display the view
		parent::display($tpl);
	}

	/**
	 * Generates the url and title for each of the items
	 * @return Array of stdClass objects containing the items
	 */
	private function _prepareItems($items_raw)
	{
		$titles = $this->params->get('use_titles',1);
		$years = $this->params->get('years',1);
		$months = $this->params->get('months',1);
		$days = $this->params->get('days',1);

		// TODO: Parameter setting to fill the empty months
		$fill = $this->params->get('fill',1);		

		// Trackers
		$month = $items_raw[0]->firstmonth;
		$year = $items_raw[0]->year;

		// Prepare items
		$items = array();

		foreach($items_raw as $k => $i)
		{
			// Fill the gaps if they exist and if required by the user
			if($this->params->get('fill',1))
				$items = array_merge($items, $this->_generateMissing($month, $year, $i));

			$month = $i->firstmonth;
			$year = $i->year;

			$i->title = $this->_generateTitle($i->year, $i->month, $i->day);
			$i->url = JURI::base() . substr($i->file, strlen(JPATH_SITE . "/"));

			array_push($items, $i);
		}

		// Return the prepared list of items
		return $items;
	}

	/**
	 * generate the title of the row
	 * @return String 	Title of the row
	 */
	private function _generateTitle($year, $month, $day)
	{
		// Params
		$names = $this->params->get('use_month_names', 1);
		$caps = $this->params->get('use_month_capitals', 1);

		// Title
		$title = $this->params->get('prefix');
		
		if($this->params->get('prefix') != "") 
		{
			$title .= " ";
		}

		$title .= PeriodicalsHelper::dateToString($year, $month, $day, $names, $caps) . " " . $this->params->get('suffix');
		
		if($this->params->get('suffix') != "") 
		{	
			$title .= " " . $this->params->get('suffix');
		}

		// Return full title
		return $title;
	}

	/**
	 * Generates filler items to go in gaps if set by user
	 * Only generates the missing items between the last checked item and the next item
	 * @return Array of stdClass objects containing the items
	 */
	private function _generateMissing($month, $year, $item)
	{
		$items = array();
		$latest = explode(",", $item->month);
		$latest = max($latest);
		while ($year > $item->year || $month > $latest) {
			// Calculate next
			if($month == 1)
			{
				$month = 12;
				$year--;
			}
			else
			{
				$month--;
			}
			
			// Create a new object and set the relevant information
			$i = clone $item;
			$i->title = $this->_generateTitle($year, $month, 0);
			$i->url = "";
			$i->file = "";
			$i->year = $year;
			$i->month = $month;
			$i->day = 0;

			array_push($items, $i);
		}
		
		// Remove the last item of the array as it is the same date as the next item
		array_pop($items);

		// Return the array with the filler material
		return $items;
	}
}
