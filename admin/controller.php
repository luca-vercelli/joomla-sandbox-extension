<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * Component Controller
 */
class SandboxController extends JControllerLegacy
{

//warning. if ./sandbox is a link that points to . then 
//whole joomla site will be destroyed!!!

    public function prova() {
        JControllerLegacy::display();
    }

    //this was the old create() task
    //too long to execute
    public function create_old() {
        comSandboxHelper::dropSandboxTables();
        comSandboxHelper::prepareSandboxFolder();
        comSandboxHelper::performDatabaseCopy();
        comSandboxHelper::performFileCopy();
        comSandboxHelper::updateConfigPHP();
        
        JFactory::getApplication()->enqueueMessage(JText::_('Done.'));
        JFactory::getApplication()->enqueueMessage("<A href=\"". JURI::root() .SANDBOX_FOLDER. "\" target=\"_blank\">".JText::_("Access sandbox site")."</A>");
        
        JControllerLegacy::display();
    }
    
    //create - step 0
    public function create() {
        comSandboxHelper::dropSandboxTables();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JControllerLegacy::display();
    }
    
    //create - step 1
    public function fs_clean() {
        comSandboxHelper::prepareSandboxFolder();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JControllerLegacy::display();
    }
    
    //create - step 2
    public function db_copy() {
        comSandboxHelper::performDatabaseCopy();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Database copied.'));
        JControllerLegacy::display();
    }
    
    //create - step 3
    public function fs_copy_frontend() {
        comSandboxHelper::performFileCopyFrontend();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Database copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Frontend files copied.'));
        JControllerLegacy::display();
    }
    
    //create - step 4
    public function config_php() {
        comSandboxHelper::updateConfigPHP();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Database copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Frontend files copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Configuration.php updated.'));
        JControllerLegacy::display();
    }
    
    //create - step 5
    public function fs_copy_admin() {
        comSandboxHelper::performFileCopyAdmin();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Database copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Frontend files copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Configuration.php updated.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Admin files copied.'));
        JControllerLegacy::display();
    }
    
    //create - step 6
    public function fs_copy_images() {
        comSandboxHelper::performFileCopyImages();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Database copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Frontend files copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Configuration.php updated.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Admin files copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Images copied.'));
        JControllerLegacy::display();
    }
    
    //create - step 7
    public function fs_copy_media() {
        comSandboxHelper::performFileCopyMedia();
        JFactory::getApplication()->enqueueMessage(JText::_('Database clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Sandbox folder clean.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Database copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Frontend files copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Configuration.php updated.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Admin files copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Images copied.'));
        JFactory::getApplication()->enqueueMessage(JText::_('Media copied.'));
        JFactory::getApplication()->enqueueMessage("<A href=\"". JURI::root() .SANDBOX_FOLDER. "\" target=\"_blank\">".JText::_("Access sandbox site")."</A>");
        JControllerLegacy::display();
    }
    
    public function remove() {
        comSandboxHelper::dropSandboxTables();
        if (file_exists(SANDBOX_FULL_PATH)) {
            comSandboxHelper::recurseDelete(SANDBOX_FULL_PATH, true);
        }
        
        JFactory::getApplication()->enqueueMessage(JText::_('Done.'));
        
        JControllerLegacy::display();
    }
}

