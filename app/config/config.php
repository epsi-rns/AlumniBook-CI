<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*|--------------------------------------------------------------------------| Base Site URL*/
$config['base_url']	= "http://localhost/ci/book/";

/*|--------------------------------------------------------------------------| Index File*/

$config['index_page'] = "index.php";

/*|--------------------------------------------------------------------------| URI PROTOCOL */
$config['uri_protocol']	= "AUTO";

/*|--------------------------------------------------------------------------| URL suffix */
$config['url_suffix'] = ".html";

/*|--------------------------------------------------------------------------| Default Language*/
$config['language']	= "english";

/*|--------------------------------------------------------------------------| Default Character Set */
$config['charset'] = "UTF-8";

/*|--------------------------------------------------------------------------| Enable/Disable System Hooks */
$config['enable_hooks'] = FALSE;


/*|--------------------------------------------------------------------------| Class Extension Prefix */
$config['subclass_prefix'] = 'MY_';


/*|--------------------------------------------------------------------------| Allowed URL Characters */
$config['permitted_uri_chars'] = 'a-z 0-9~%,.:_-';


/*|--------------------------------------------------------------------------| Enable Query Strings */
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';

/*|--------------------------------------------------------------------------| Error Logging Threshold */
$config['log_threshold'] = 0;

/*|--------------------------------------------------------------------------| Error Logging Directory Path */
$config['log_path'] = '';

/*|--------------------------------------------------------------------------| Date Format for Logs */
$config['log_date_format'] = 'Y-m-d H:i:s';

/*|--------------------------------------------------------------------------| Cache Directory Path */
$config['cache_path'] = '';

/*|--------------------------------------------------------------------------| Encryption Key */
$config['encryption_key'] = "";

/*|--------------------------------------------------------------------------| Session Variables */
$config['sess_cookie_name']		= 'ci_session';
$config['sess_expiration']		= 7200;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;

/*|--------------------------------------------------------------------------| Cookie Related Variables */
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";

/*|--------------------------------------------------------------------------| Global XSS Filtering */
$config['global_xss_filtering'] = FALSE;

/*|--------------------------------------------------------------------------| Output Compression */
$config['compress_output'] = FALSE;

/*|--------------------------------------------------------------------------| Master Time Reference */
$config['time_reference'] = 'local';


/*|--------------------------------------------------------------------------| Rewrite PHP Short Tags */
$config['rewrite_short_tags'] = FALSE;


?>
