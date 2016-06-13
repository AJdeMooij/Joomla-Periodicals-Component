<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * PeriodicalsEdit Controller
 */
class PeriodicalsControllerPeriodical extends JControllerForm
{
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->view_list = 'periodicals';
	}

	public function save($key = NULL, $urlVar = NULL)
	{
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication()->input;
		$user = JFactory::getUser();
		$isNew = $jinput->get('jform', null, null)["id"] == "";

		if(
			($isNew && !$user->authorise('core.create', 'com_periodicals'))
				|| (!$isNew && !$user->authorise('core.edit', 'com_periodicals'))
		) {
			$app->enqueueMessage(JText::_( 'COM_PERIODICALS_OPERATION_NOT_ALLOWED' ), 'error');
			return parent::cancel($key, $urlVar);
		}

		$uploadFile = $isNew || (!$isNew && $form["upload_filename"] != null);
		$fileinfo = ($uploadFile ? $this->_uploadFile() : array());

		if($fileinfo === false) return parent::cancel($key, $urlVar);

		$jform = $jinput->get('jform', null, null);
		$months = $jform["month"];
		sort($jform["month"]);
		sort($jform["day"]);
		$jform["month"] = implode(",", $jform["month"]);
		$jform["day"] = implode(",", $jform["day"]);
		$jform = array_merge($jform, $fileinfo);

		$jinput->post->set('jform', $jform);

		// Save the data to the database	
		return parent::save($key, $urlVar);
	}

	/**
	 * Function to check and upload the selected file
	 */
	private function _uploadFile()
	{
	    // Neccesary libraries and variables
	    jimport( 'joomla.filesystem.folder' );
	    jimport('joomla.filesystem.file');
		
	    // Get the uploaded file
		$jinput = JFactory::getApplication()->input;
		$files = $jinput->files->get('jform');

		// Select the file
		$file = $files['file'];

		// Check if the file is safe
		if(!$this->_isValidFile($file))
			return false;

		// Create the upload path
		$uploadPath = $this->_prepareName($file['name']);
		
		// Try uploading the file
		if (isset($file))
			if(!JFile::upload($file['tmp_name'], $uploadPath))
				return false;

		// Add filename to post data
		$fileinfo = array('file' => $uploadPath, 'upload_filename' => addslashes($file['name']));

		// Return the array to be merged with the jform
		return $fileinfo;
	}

	/**
	 * Safety checks on the file
	 * @return true iff file is safe
	 */
	private function _isValidFile($file)
	{
		$app = JFactory::getApplication();
		$form = JFactory::getApplication()->input->get('jform', null, null)["id"];

		//any errors the server registered on uploading
		$fileError = $file['error'];
		if ($fileError > 0) 
		{
	        switch ($fileError) 
			{
		        case 1:
		        $app->enqueueMessage(
		        	JText::_( 'COM_PERIODICALS_FILE_LARGER_THAN_INI_ALLOWS' ), 'error');
		        return false;
		 
		        case 2:
		        $app->enqueueMessage(
		        	JText::_( 'COM_PERIODICALS_FILE_TO_LARGE_THAN_HTML_FORM_ALLOWS' ), 'error');
		        return false;
		 
		        case 3:
		        $app->enqueueMessage(
		        	JText::_( 'COM_PERIODICALS_ERROR_PARTIAL_UPLOAD' ), 'error');
		        return false;
		 
		        case 4:
		        $app->enqueueMessage(
		        	JText::_( 'COM_PERIODICALS_ERROR_NO_FILE' ), 'error');
		        return false;
	        }
		}

		// Check the filename and the upload location
		$params = JComponentHelper::getParams('com_periodicals');

		//check for filesize
		$fileSize = $file['size'];
		if($fileSize > $params->get('max_file_size') * 1000000)
		{
		    JFactory::getApplication()->enqueueMessage(
		    	JText::_( 
		    		sprintf('COM_PERIODICALS_FILE_TO_BIG', $params->get('max_file_size')), 
		    		'error')
		    	);
		    return false;
		}
		
		// Check extension
		if(!$this->_checkExtension($file['name'], ".pdf"))
		{
			JFactory::getApplication()->enqueueMessage(
				JText::_('COM_PERIODICALS_INVALID_EXTENSION'), 'error');
			return false;
		}

		// Check mime type
		$file_info = finfo_open(FILEINFO_MIME_TYPE);
		if(finfo_file($file_info, $file['tmp_name']) !== "application/pdf")
		{
			JFactory::getApplication()->enqueueMessage(
				JText::_('COM_PERIODICALS_INVALID_MIME_TYPE'), 'error');
			return false;
		}

		return true;
	}

	/**
	 * Function to make the filename safe for upload
	 * @return String 	Full upload path
	 */
	private function _prepareName($filename)
	{
		// Get param settings
		$params = JComponentHelper::getParams('com_periodicals');

		// Clean up filename
		$nameArray = explode('.', $filename);
		array_pop($nameArray);
		$name = implode($nameArray, '-');
		$filename =  preg_replace("/[^A-Za-z0-9]/i", "-", $name);

		// Obscure title to make it harder to guess if set in preferences
		if($params->get('obscure_titles') == 1)
		{
			$filename .= uniqid(rand(), false);
		}
		
		// Target directory path as set in params
		$default_location = $params->get('default_location');
		$url = (
			isset($default_location)) ? 
			$default_location . "/" : 
			JPATH_SITE . "/administrator/components/com_periodicals/files/";

		// Create the folder if not exists in images folder
	    if ( !JFolder::exists( $url ) ) {
	        JFolder::create( $url, 0777 );
			copy(JPATH_SITE . "/administrator/components/com_periodicals/index.html", $url . "/index.html");
	    }

	    // Check if the file already exists and rename the file if necessary
		if(Jfile::exists($url . $filename . '.pdf'))
		{
			$suffix = 1;
			while(JFile::exists($url . $filename . $suffix . '.pdf'))
				$suffix++;
			$filename = $filename . $suffix;
		}

		// return full upload path
		return $url . $filename . '.pdf';
	}

	/**
	 * Checks if the extension is valid. i.e. if the file ends with '.pdf'
	 */
	private function _checkExtension($filename, $extension)
	{
		return (substr($filename, -strlen($extension)) === $extension);
	}

}
