<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$active_group = "default";

$db['default']['hostname']	= "localhost:IluniBook";
//$db['default']['username']	= "iluni";
//$db['default']['password']	= "salemba";
$db['default']['username']	= "SYSDBA";
$db['default']['password']	= "masterkey";
$db['default']['database']	= "";
$db['default']['dbdriver']		= "ibase";
$db['default']['dbprefix']		= "";
$db['default']['active_r']		= TRUE;
$db['default']['pconnect']	= TRUE;
$db['default']['db_debug']	= TRUE;
$db['default']['cache_on']	= FALSE;
$db['default']['cachedir']		= "";

// Authentication
$db['auth']['hostname']	= "localhost";
$db['auth']['username']	= "";
$db['auth']['password']	= "";
$db['auth']['database']	= "auth.iluni.sqlite2";
$db['auth']['dbdriver']		= "sqlite";
$db['auth']['dbprefix']		= "";
$db['auth']['active_r']		= TRUE;
$db['auth']['pconnect']	= TRUE;
$db['auth']['db_debug']	= TRUE;
$db['auth']['cache_on']	= FALSE;
$db['auth']['cachedir']		= "";
$db['auth']['char_set']		= "utf8";							// ???
$db['auth']['dbcollat']		= "utf8_general_ci";			// ???
?>
