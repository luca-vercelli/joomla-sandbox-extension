<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.framework');

$this

?>
<h1><?php echo JText::_('COM_SANDBOX_MESSAGE_TITLE');?></h1>

<?php if ($this->next != "") { ?>

<script>
var oldonload=document.body.onload;
document.body.onload = function(){
  if (oldonload!=null) oldonload();
  location.href='<?php
  echo "{$this->follow}";
  ?>';
}
</script>

<p><?php echo JText::_('COM_SANDBOX_MESSAGE_WORK_IN_PROGRESS');?></p>

<?php } else { ?>
<p><?php echo JText::_('COM_SANDBOX_MESSAGE_ALL_DONE');?></p>

<?php } ?>

