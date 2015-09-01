<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.framework');

$this

?>
<h1>Sandbox copy</h1>

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

<p>Work in progress...</p>

<?php } else { ?>
<p>All done.</p>

<?php } ?>

