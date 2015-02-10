<?php
/**
* @package Joomla.component
* @subpackage com_periodicals
*
* @copyright Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$this->params->set('fill', 1);

jimport('joomla.filesystem.file');
?>
<div class="item-page">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header">
		<h2 itemprop="name"> <?php echo $this->escape($this->params->get('page_title')); ?> </h1>
	</div>
<?php endif; ?>
	<div itemprop="articleBody">
<?php echo $this->params->get("body_prefix");?>
		<p>

		<?php
		$cur_year = "";
		$cur_month = "";
		if(empty($this->items))
		{
			echo JText::_("COM_PERIODICALS_NO_ITEMS");
		}
		foreach ($this->items as $k => $item):
			// Sets a new title if a new month or year has come and when requested by user
			if($this->params->get('use_titles'))
			{
				if($this->settings->get('use_year',1) && $this->settings->get('use_month',1) && $item->year != $cur_year)
				{
					$cur_year = $item->year;
					echo "</p><h2>" . $cur_year . "</h2><p>";
				}
				if($this->settings->get('use_month',1) && $this->settings->get('use_day',1) && $item->month != $cur_month)
				{
					$cur_month = $item->month;
					echo "</p><h3>";
					$monthName = JFactory::getDate()->monthToString($cur_month);
					if($this->params->get('use_month_capitals',1))
						$monthName = ucfirst($monthName);

					echo ($this->params->get('use_month_names',1)) ? $monthName : $cur_month;
					echo "</h3><p>";
				}
			}

			// Print the file. Use a link if the file is valid
			if(JFile::exists($item->file))
			{
				echo '<a title="' . $item->title . '" href="' . $item->url . '" target="_blank">' . $item->title . '</a><br/>';
			}
			else
			{
				echo '<span class="unavailable">' . $item->title . '</span><br/>';
			}
			
		endforeach;
		?>
		</p>
	</div>
</div>
