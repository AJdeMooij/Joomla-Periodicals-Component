<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Periodicals View
 */
class PeriodicalsViewPeriodicals extends JViewLegacy
{
	protected $items;
    protected $state;
    protected $pagination;

	/**
	 * Periodicals view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$state = $this->get('State');
		$pagination = $this->get('Pagination');

		// Sorting
		$this->sortDirection = $state->get('list.direction');
        $this->sortColumn = $state->get('list.ordering');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		$user = JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_PERIODICALS_PERIODICALS_TITLE'));
		
		// Add new and edit buttons if user is allowed
		if($user->authorise('core.create', 'com_periodicals'))
			JToolBarHelper::addNew('periodical.add');
		if($user->authorise('core.edit', 'com_periodicals'))
			JToolBarHelper::editList('periodical.edit');
	
		// Add publish and unpublish buttons if user is allowed
		if($user->authorise('core.edit.state', 'com_periodicals'))
		{
			JToolBarHelper::publishList('periodicals.publish');
			JToolBarHelper::unpublishList('periodicals.unpublish');
		}

		// Add delete button if user is allowed
		if($user->authorise('core.delete', 'com_periodicals'))
			JToolBarHelper::deleteList('', 'periodicals.delete');
		
		// Add preferences if user is allowed
		if($user->authorise('core.admin', 'com_kerkniews'))
			JToolbarHelper::preferences('com_periodicals');
	}

	/**
	 * Gets the sort fields
	 */
	protected function getSortFields()
	{
		return array(
			'a.id' => JText::_('COM_PERIODICALS_PERIODICALS_HEADING_ID'),
			'a.filename' => JText::_('COM_PERIODICALS_PERIODICALS_FILENAME'),
			'a.year' => JText::_('COM_PERIODICALS_PERIODICALS_YEAR_LABEL'),
			'a.month' => JText::_('COM_PERIODICALS_PERIODICALS_MONTH_LABEL'),
			'a.day' => JText::_('COM_PERIODICALS_PERIODICALS_DAY_LABEL'),
			'a.published' => JText::_('JSTATUS'),
		);
	}
}
