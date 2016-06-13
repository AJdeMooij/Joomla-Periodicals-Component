<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('jquery.framework');
JHtml::_('formbehavior.chosen', 'select');
$document = JFactory::getDocument();
$document->addScript('components/com_periodicals/js/jquery.mask.js');
?>
<form action="<?php echo JRoute::_('index.php?option=com_periodicals&view=periodical&layout=edit&id=' 
    . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>
                <?php echo JText::_('COM_PERIODICALS_PERIODICALS_EDIT_DETAILS'); ?>
            </legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php  
                    foreach ($this->form->getFieldset() as $field):
                        if(!isset($this->hide[$field->name]) || $this->hide[$field->name] == "1")
                        {
                    ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls">
                            <?php
                                if($field->name == 'jform[file]' && !$this->isNew)
                                {   
                                    $output = '<input id="jform_upload_filename"';
                                    $output .= ' class="required" name="jform[ignore]"';
                                    $output .= ' type="text" disabled="" value="';
                                    $output .= $this->item->upload_filename;
                                    $output .= '"></input>';
                                    $output .= '<input id="jform_file"';
                                    $output .= ' type="hidden" value="';
                                    $output .= $this->item->file;
                                    $output .= '" name="jform[file]"></input>';
                                    echo $output;
                                }
                                else
                                    echo $field->input; 
                            ?>
                            </div>
                        </div>
                    <?php
                        } else { // Field should be hidden
                            $output = '<input id="';
                            $output .= $field->fieldname;
                            $output .= '" class="required" name="';
                            $output .= $field->name;
                            $output .= '" type="hidden" value="0"></input>';
                            echo $output;
                        } 
                    endforeach; 
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="periodical.edit" />
    <input type="hidden" name="action" value="<?=$isNew ? 'create' : 'edit'?>"/>
    <?php echo JHtml::_('form.token'); ?>
    <script>
    	jQuery("#jform_year").mask("0000");
    </script>
</form>
