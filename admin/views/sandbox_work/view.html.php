<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the Component
 */
class SandboxViewSandbox_work extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
                //I use the layout as a parameter... :(
                
                // Assign data to the view
                
                $l = parent::getLayout();
                parent::setLayout(null);
                
                if ($l == null) die('Expecting template');
                
                if ($l == "create") {
                    $this->next="fs_clean";
                } elseif  ($l == "fs_clean") {
                    $this->next="db_copy";
                } elseif  ($l == "db_copy") {
                    $this->next="fs_copy_frontend";
                } elseif  ($l == "fs_copy_frontend") {
                    $this->next="config_php";
                } elseif  ($l == "config_php") {
                    $this->next="fs_copy_admin";
                } elseif  ($l == "fs_copy_admin") {
                    $this->next="fs_copy_images";
                } elseif  ($l == "fs_copy_images") {
                    $this->next="fs_copy_media";
                } elseif  ($l == "fs_copy_media") {
                    $this->next="";
                }
                $this->follow = JURI::root() . "administrator/index.php?option=com_sandbox&task={$this->next}&view=sandbox_work&layout={$this->next}";
 
                JToolbarHelper::title(JText::_("Sandbox copy"));
                // Display the view
                parent::display($tpl);
        }
}
