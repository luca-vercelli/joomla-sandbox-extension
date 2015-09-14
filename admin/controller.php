<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// This is for debug (I don't think it's dangerous, user is admin)
ini_set('display_error','On');
 
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
        
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DONE'));
        JFactory::getApplication()->enqueueMessage("<A href=\"". JURI::root() .SANDBOX_FOLDER. "\" target=\"_blank\">".JText::_("COM_SANDBOX_MESSAGE_ACCESS")."</A>");
        
        JControllerLegacy::display();
    }
    
    //create - step 0
    public function create() {
        comSandboxHelper::dropSandboxTables();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JControllerLegacy::display();
    }
    
    //create - step 1
    public function fs_clean() {
        comSandboxHelper::prepareSandboxFolder();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JControllerLegacy::display();
    }
    
    //create - step 2
    public function db_copy() {
        comSandboxHelper::performDatabaseCopy();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_COPIED'));
        JControllerLegacy::display();
    }
    
    //create - step 3
    public function fs_copy_frontend() {
        comSandboxHelper::performFileCopyFrontend();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_FE_COPIED'));
        JControllerLegacy::display();
    }
    
    //create - step 4
    public function config_php() {
        comSandboxHelper::updateConfigPHP();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_FE_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_CONFIGPHP'));
        JControllerLegacy::display();
    }
    
    //create - step 5
    public function fs_copy_admin() {
        comSandboxHelper::performFileCopyAdmin();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_FE_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_CONFIGPHP'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_BE_COPIED'));
        JControllerLegacy::display();
    }
    
    //create - step 6
    public function fs_copy_images() {
        comSandboxHelper::performFileCopyImages();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_FE_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_CONFIGPHP'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_BE_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_IM_COPIED'));
        JControllerLegacy::display();
    }
    
    //create - step 7
    public function fs_copy_media() {
        comSandboxHelper::performFileCopyMedia();
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_SF_CLEAN'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DB_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_FE_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_CONFIGPHP'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_BE_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_IM_COPIED'));
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_MEDIA_COPIED'));
        JFactory::getApplication()->enqueueMessage("<A href=\"". JURI::root() .SANDBOX_FOLDER. "\" target=\"_blank\">".JText::_("COM_SANDBOX_MESSAGE_ACCESS")."</A>");
        JControllerLegacy::display();
    }
    
    public function remove() {
        comSandboxHelper::dropSandboxTables();
        if (file_exists(SANDBOX_FULL_PATH)) {
            comSandboxHelper::recurseDelete(SANDBOX_FULL_PATH, true);
        }
        
        JFactory::getApplication()->enqueueMessage(JText::_('COM_SANDBOX_MESSAGE_DONE'));
        
        JControllerLegacy::display();
    }
}

