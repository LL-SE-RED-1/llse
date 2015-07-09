<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
 * Numbers representing Terms
 */ 
define('TERM_SPRING', '1');
define('TERM_SUMMER', '2');
define('TERM_SPRING_SUMMER', '3');
define('TERM_AUTUMN', '4');
define('TERM_WINTER', '5');
define('TERM_AUTUMN_WINTER', '6');
define('TERM_SUMMER_SHORT', '7');
define('TERM_WINTER_SHORT', '8');

define('ROLE_TEACHER', 1);
define('ROLE_STUDENT', 0);

define('STATUS_UNDONE', 0);
define('STATUS_UNSCORED', 1);
define('STATUS_SCORED', 2);

define('SEARCH_TYPE_FILE', "课程资源");
define('SEARCH_TYPE_HOMEWORK', "作业");
/* End of file constants.php */
/* Location: ./application/config/constants.php */
