<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
Jhtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$canChange = $user->authorise('core.edit.state', 'com_periodicals');
$canEdit = $user->authorise('core.edit', 'com_periodicals');

// Get sortfields
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_periodicals'); ?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist table table-striped" id="nieuwsbladen">
		<thead>
			<tr>
				<th width="25">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th width="35">
					<?php echo JHtml::_('grid.sort', 'COM_PERIODICALS_PERIODICALS_HEADING_ID', 'a.id', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_PERIODICALS_PERIODICALS_FILENAME', 'a.upload_filename', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_PERIODICALS_PERIODICALS_DATUM', 'date', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $this->sortDirection, $this->sortColumn);?>
				</th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<td colspan="5"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach($this->items as $i => $item): ?>
				<tr class="row<php echo $i % 2;?>">
					<td>
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td>
						<?php echo $item->id; ?>
					</td>
					<td class="nowrap has-context">
					<?php 
						if($canEdit)
						{
							echo '<a href="' . JRoute::_('index.php?option=com_periodicals&task=periodical.edit&id='.(int) $item->id) . '">';
							echo $this->escape($item->upload_filename);
							echo '</a>';							
						}
						else
						{
							echo $this->escape($item->upload_filename);
						}
					?>
					</td>
					<td>
						<?php
							echo PeriodicalsHelper::dateToString($item->year, $item->month, $item->day);
						?>
					</td>
					<td>
						<div class="btn-group">
						<?php
							echo JHtml::_('jgrid.published', $item->published, $i, 'periodicals.', $canChange, 'cb');
						?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
    	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
