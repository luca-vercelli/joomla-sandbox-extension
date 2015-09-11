<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.framework');

//echo $this->msg;

?>
<h1><?php echo JText::_('COM_SANDBOX_MESSAGE_TITLE');?></h1>


<?php if ($this->this_is_sandbox) { ?>
<?php echo JText::_('COM_SANDBOX_MESSAGE_RUNNING_IN_SANDBOX');?><br>
<?php } else { ?>

<p>
<?php echo JText::_('COM_SANDBOX_MESSAGE_DISCLAIMER');?><br>
<?php echo JText::_('COM_SANDBOX_MESSAGE_FILES_WILL_BE_COPIED');?> <code><?php echo SANDBOX_FOLDER; ?></code>.<br>
<?php echo JText::_('COM_SANDBOX_MESSAGE_TABLES_WILL_BE_COPIED');?> <code><?php echo SANDBOX_PREFIX; ?></code>.<br>
<?php echo JText::_('COM_SANDBOX_MESSAGE_NEW_SITE');?> <code><?php echo JURI::root().SANDBOX_FOLDER; ?></code>.<br>
<?php echo JText::_('COM_SANDBOX_MESSAGE_COOKIES');?><br>
</p>

<p> <?php echo JText::_('COM_SANDBOX_MESSAGE_CHECKING');?><br>
   <?php if ($this->sandbox_folder_exists) { ?>
   <b><?php echo JText::_('COM_SANDBOX_MESSAGE_FILES_EXIST');?></b><br>
   <?php } else { ?>
   <?php echo JText::_('COM_SANDBOX_MESSAGE_FILES_DONT_EXIST');?><br>
   <?php } ?>
   
   <?php if ($this->sandbox_tables_exist) { ?>
   <b><?php echo JText::_('COM_SANDBOX_MESSAGE_TABLES_EXIST');?></b><br>
   <?php } else { ?>
   <?php echo JText::_('COM_SANDBOX_MESSAGE_TABLES_DONT_EXIST');?><br>
   <?php } ?>
<p>
<b><?php echo JText::_('COM_SANDBOX_MESSAGE_AFTER_CLICK');?></b>
</p>

<p>
<BUTTON ONCLICK="location.href='<?php echo JURI::root() . 'administrator/index.php?option=com_sandbox&task=create&view=sandbox_work&layout=create'?>'">
<?php echo JText::_('COM_SANDBOX_MESSAGE_CREATE');?>
</BUTTON>
<br>
<?php if ($this->sandbox_folder_exists || $this->sandbox_tables_exist) { ?>
<BUTTON ONCLICK="location.href='<?php echo JURI::root() . 'administrator/index.php?option=com_sandbox&task=remove'?>'">
<?php echo JText::_('COM_SANDBOX_MESSAGE_DESTROY');?>
</BUTTON>
<?php } ?>
</p>



<?php } ?>

