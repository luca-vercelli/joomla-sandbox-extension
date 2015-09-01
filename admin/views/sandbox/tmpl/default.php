<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.framework');

//echo $this->msg;

?>
<h1>Sandbox copy</h1>


<?php if ($this->this_is_sandbox) { ?>
Running inside Sandbox. Nothing to be done.<br>
<?php } else { ?>

<p>
This procedure will create a sandbox copy of your site.<br>
All files will be copied in subfolder <code><?php echo SANDBOX_FOLDER; ?></code>.<br>
All tables will be cloned with <code><?php echo SANDBOX_PREFIX; ?></code> prefix.<br>
New site will be accessible at address: <code><?php echo JURI::root().SANDBOX_FOLDER; ?></code>.<br>
</p>

<p> Checking if Sandbox site already exists:<br>
   <?php if ($this->sandbox_folder_exists) { ?>
   <b>Sandbox folder already exists! creating a new sandbox will overwrite it.</b><br>
   <?php } else { ?>
   Sandbox folder does not exist.<br>
   <?php } ?>
   
   <?php if ($this->sandbox_tables_exist) { ?>
   <b>One or more sandbox tables do exist! creating a new sandbox will overwrite them.</b><br>
   <?php } else { ?>
   Sandbox tables do not exist.<br>
   <?php } ?>
<p>
<b>After click, you must not change page until a confirmation message or an error message appears.</b>
</p>

<p>
<BUTTON ONCLICK="location.href='<?php echo JURI::root() . 'administrator/index.php?option=com_sandbox&task=create&view=sandbox_work&layout=create'?>'">Create sandbox now.</BUTTON>
<br>
<?php if ($this->sandbox_folder_exists || $this->sandbox_tables_exist) { ?>
<BUTTON ONCLICK="location.href='<?php echo JURI::root() . 'administrator/index.php?option=com_sandbox&task=remove'?>'">Destroy sandbox site.</BUTTON>
<?php } ?>
</p>



<?php } ?>

