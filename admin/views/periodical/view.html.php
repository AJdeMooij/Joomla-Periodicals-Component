<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * PeriodicalsEdit View
 */
class PeriodicalsViewPeriodical extends JViewLegacy
{
	/**
	 * display method of Periodicals edit view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
		$randomText = $this->get('Text');

        // Figure out which elements to show based on the component settings 
		$params = JComponentHelper::getParams('com_periodicals');
    	$hide = array("jform[year]" => $params->get('use_year'), "jform[month][]" => $params->get("use_month"), "jform[day][]" => $params->get("use_day"));

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
		$this->params = $params;
		$this->hide = $hide;
		$this->isNew = ($this->item->id == 0);
 
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
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_PERIODICALS_MANAGER_PERIODICALS_NEW')
		                             : JText::_('COM_PERIODICALS_MANAGER_PERIODICALS_EDIT'));
		JToolBarHelper::save('periodical.save');
		JToolBarHelper::cancel('periodical.cancel', $isNew ? 'JTOOLBAR_CANCEL'
																: 'JTOOLBAR_CLOSE');
	}
}
