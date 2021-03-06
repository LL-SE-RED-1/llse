<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$db['resource']['hostname'] = '218.244.137.223';
$db['resource']['username'] = 'ims';
$db['resource']['password'] = 'ims@2015';
//$db['resource']['password'] = 'root';
$db['resource']['database'] = 'llse';
$db['resource']['dbdriver'] = 'mysql';
$db['resource']['dbprefix'] = 'res_';
$db['resource']['pconnect'] = false;
$db['resource']['db_debug'] = TRUE;
$db['resource']['cache_on'] = FALSE;
$db['resource']['cachedir'] = '';
$db['resource']['char_set'] = 'utf8';
$db['resource']['dbcollat'] = 'utf8_general_ci';
$db['resource']['swap_pre'] = '';
$db['resource']['autoinit'] = TRUE;
$db['resource']['stricton'] = FALSE;

$db['adaptor']['hostname'] = '218.244.137.223';
$db['adaptor']['username'] = 'ims';
$db['adaptor']['password'] = 'ims@2015';
//$db['resource']['password'] = 'root';
$db['adaptor']['database'] = 'llse';
$db['adaptor']['dbdriver'] = 'mysql';
$db['adaptor']['dbprefix'] = 'res_';
$db['adaptor']['pconnect'] = false;
$db['adaptor']['db_debug'] = TRUE;
$db['adaptor']['cache_on'] = FALSE;
$db['adaptor']['cachedir'] = '';
$db['adaptor']['char_set'] = 'utf8';
$db['adaptor']['dbcollat'] = 'utf8_general_ci';
$db['adaptor']['swap_pre'] = '';
$db['adaptor']['autoinit'] = TRUE;
$db['adaptor']['stricton'] = FALSE;

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '218.244.137.223';
$db['default']['username'] = 'ims';
$db['default']['password'] = 'ims@2015';
//$db['default']['username'] = 'ims';
//$db['default']['password'] = 'ims@2015';
$db['default']['database'] = 'llse';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
/* End of file database.php */
/* Location: ./application/config/database.php */
