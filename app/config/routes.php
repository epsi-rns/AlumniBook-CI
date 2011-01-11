<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "main";
$route['scaffolding_trigger'] = "";

$route['browse/(.*)']		= "main/browse/$1";
$route['alumni/(.*)']			= "main/browse/alumni/$1";
$route['(a|o)det/(\d+)']	= "detail/$1/$2";

?>