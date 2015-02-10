<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * Periodicals component helper.
 */
abstract class PeriodicalsHelper
{
	/**
	 * Year / Month / Day to nice string
	 */
	static function dateToString($year, $month, $day, $fullnames = true, $capitals = false)
	{
		$params = JComponentHelper::getParams('com_periodicals');

		$monthName = PeriodicalsHelper::_monthsToString($month, $fullnames = true, $capitals = false);

		$output = "";
		if($params->get("use_day") == 1 && $day != 0)
			$output .= $day . " ";
		if($params->get("use_month") == 1 && $month != 0)
			$output .= $monthName . " ";
		if($params->get("use_year") == 1)
			$output .= $year;

		return $output;
	}

	private static function _monthsToString($months, $fullnames = true, $capitals = false)
	{
		
		// Array of months
		$months = explode(",", $months);

		// Result array to be build up
		$result = array();

		// Convert each month to what it should be
		foreach($months as $month)
		{
			$monthName = ($fullnames) ? JFactory::getDate()->monthToString($month) : $month;
			if($capitals)
				$monthName = ucfirst($monthName);
			array_push($result, $monthName);
		}

		return implode("/", $result);
	}
}
