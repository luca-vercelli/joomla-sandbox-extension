<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the Component
 */
class SandboxViewSandbox extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
                // Assign data to the view
                $this->this_is_sandbox = (comSandboxHelper::testIfSandbox());
                $this->sandbox_folder_exists = (comSandboxHelper::testIfSandboxFolderExists());
                $this->sandbox_tables_exist = (comSandboxHelper::testIfSandboxTablesExist());
                
                JToolbarHelper::title(JText::_("Sandbox copy"));
                // Display the view
                parent::display($tpl);
        }
}
