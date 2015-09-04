<?php

//REM. '.' folder is /administrator

define("SANDBOX_FOLDER", 'sandbox');
define("SANDBOX_PREFIX", 'sandbox_');
define("SANDBOX_FULL_PATH", JPATH_SITE.'/'.SANDBOX_FOLDER);  //
define("SIZE_LIMIT", 10000000);

class comSandboxHelper
{
    /**********************  DATABASE *********************************/
        
    public static function getDatabaseName()
    {
      $cfg = JFactory::getConfig();
      return $cfg->get('db');
    }
    
    public static function getTablesPrefix() //including '_'
    {
      $db =& JFactory::getDBO(); //Returns a reference to the global database object
      return $db->getPrefix();
    }
    
    public static function dropSandboxTables() {
        $tableSchema = comSandboxHelper::getDatabaseName();
        $db = JFactory::getDbo();
        
        //delete old sandbox tables, it they exist
        $db->setQuery( "SELECT table_name FROM information_schema.tables " .
                       "WHERE table_schema='$tableSchema' AND table_name LIKE '".SANDBOX_PREFIX."%' " );
        $table_names = $db->loadObjectList();
        
        if (!empty($table_names)) {
          foreach($table_names as $key=>$row) {
           $t2 = $row->table_name;
           $db->setQuery( "DROP TABLE $t2 " );
           $db->execute();
          }
        }
    }
    
    public static function testIfSandboxTablesExist() {
        $tableSchema = comSandboxHelper::getDatabaseName();
        $db = JFactory::getDbo();
        
        //delete old sandbox tables, it they exist
        $db->setQuery( "SELECT table_name FROM information_schema.tables " .
                       "WHERE table_schema='$tableSchema' AND table_name LIKE '".SANDBOX_PREFIX."%' " );
        $table_names = $db->loadObjectList();
        
        return (!empty($table_names));
    }
    
    public static function performDatabaseCopy()
    {
        $tableSchema = comSandboxHelper::getDatabaseName();
        $srcPrefix = comSandboxHelper::getTablesPrefix(); //warning, includes "_"
        $destPrefix = SANDBOX_PREFIX;                     //warning, includes "_"
        $l = strlen($srcPrefix);
        
        $db = JFactory::getDbo();
        
        //retrieve new tables
        $db->setQuery( "SELECT table_name FROM information_schema.tables " .
                       "WHERE table_schema='$tableSchema' AND table_name LIKE '{$srcPrefix}%' " );
        $table_names = $db->loadObjectList();
        
        //clone tables
        if (empty($table_names)) { //which sould not happen...
           throw new RuntimeException(JText::_("No tables found! Something's wrong here.'"));
        }
        else {
          foreach($table_names as $key=>$row) {
           $t1 = $row->table_name;
           $t2 = $destPrefix.substr($t1,$l);
           $db->setQuery( "CREATE TABLE $t2 LIKE $t1 " );
           $db->execute();
           $db->setQuery( "INSERT INTO $t2 SELECT * FROM $t1 "  );
           $db->execute();
         }
        }
    }
    
    /**********************  FILESYSTEM *********************************/
    
    public static function testIfSandbox()
    {
      return (comSandboxHelper::getTablesPrefix() == SANDBOX_PREFIX);
    }
    
    public static function testIfSandboxFolderExists()
    {
        return file_exists(SANDBOX_FULL_PATH);
    }
    
    /**
    * Recursive copy of folder $src into $dst. $src must exist, $dst must not exist.
    */
    public static function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) {            //and file <> dst ???
                if ( is_dir($src . '/' . $file) ) { 
                    comSandboxHelper::recurseCopy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else {
                    if ( filesize($src . '/' . $file) < SIZE_LIMIT ) {
                        copy($src . '/' . $file, $dst . '/' . $file); 
                    }
                } 
            } 
        } 
        closedir($dir); 
    }
    
    /**
    * Recursive copy of folder $src into $dst. $src must exist, $dst must not exist.
    * $exclude_arr contains the names of top-level folders to exclude
    */
    public static function recurseCopyExclude($src, $dst, $exclude_arr)
    {
        $dir = opendir($src);
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' ) && ( !in_array($file,$exclude_arr) )) {
                if ( is_dir($src . '/' . $file) ) { 
                    comSandboxHelper::recurseCopy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    if ( filesize($src . '/' . $file) < SIZE_LIMIT ) {
                        copy($src . '/' . $file, $dst . '/' . $file); 
                    }
                } 
            } 
        } 
        closedir($dir); 
    }
    
    /**
    * Delete $file, or recursive delete folder $file.
    */
    public static function recurseDelete($file,$delete_root=true) { 
      if (is_dir($file)) {
        $objects = scandir($file); 
        foreach ($objects as $object) { 
          if ($object != "." && $object != "..") { 
            comSandboxHelper::recurseDelete($file."/".$object);
          } 
        }  
        reset($objects);
      }
      if ($delete_root) {
        if (is_dir($file))
          rmdir($file); 
        else
          unlink($file);
      }
    }
    
    /**
    * Destroy and re-create folder SANDBOX_FULL_PATH.
    */
    public static function prepareSandboxFolder() {
        if (!file_exists(SANDBOX_FULL_PATH)) {   
            mkdir(SANDBOX_FULL_PATH, 0777);
            if (!file_exists(SANDBOX_FULL_PATH)) {
                throw new RuntimeException("<code>".SANDBOX_FOLDER."</code>".JText::_(' cannot be created!'));
            }
        } else {
            if (!is_dir(SANDBOX_FULL_PATH)) {
                throw new RuntimeException("<code>".SANDBOX_FOLDER."</code>".JText::_(' exists but it is not a folder!'));
            }
            if (!is_writable(SANDBOX_FULL_PATH)) {
                throw new RuntimeException("<code>".SANDBOX_FOLDER."</code>".JText::_(" folder exists but it is not writable!"));
            }
        }
        comSandboxHelper::recurseDelete(SANDBOX_FULL_PATH, false);
        
        //could use $app = JFactory::getApplication(); ... $app->enqueueMessage(JText::_('blabla'), 'notice');
        //or throw new RuntimeException(JText::_('blabla'));
    }
    
    public static function performFileCopyFrontend()
    {
        comSandboxHelper::recurseCopyExclude('..', SANDBOX_FULL_PATH, array(SANDBOX_FOLDER,'tmp','administrator','images','media') );
        @mkdir(SANDBOX_FULL_PATH.'/tmp');
    }
    
    public static function performFileCopyAdmin()
    {
        comSandboxHelper::recurseCopy('../administrator', SANDBOX_FULL_PATH.'/administrator' );
    }
    
    public static function performFileCopyImages()
    {
        comSandboxHelper::recurseCopy('../images', SANDBOX_FULL_PATH.'/images' );
    }
    
    public static function performFileCopyMedia()
    {
        comSandboxHelper::recurseCopy('../media', SANDBOX_FULL_PATH.'/media' );
    }
    
    
    /**********************  CONFIG.PHP *********************************/
    
    public static function updateConfigPHP()
    {
        $file = SANDBOX_FULL_PATH.'/configuration.php';
        
        $prev = new JConfig;
        $prev = JArrayHelper::fromObject($prev);
        $prev['dbprefix'] = SANDBOX_PREFIX;
        $prev['tmp_path'] = SANDBOX_FULL_PATH.'/tmp';
        $prev['log_path'] = SANDBOX_FULL_PATH.'/log';
        
        $config = new JRegistry('config');
        $config->loadArray($prev);
        $configuration = $config->toString('PHP', array('class' => 'JConfig', 'closingtag' => false));
        JFile::write($file, $configuration);
    }
}

