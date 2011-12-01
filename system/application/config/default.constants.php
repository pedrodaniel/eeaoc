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

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*Tamanios Imagenes*/
define('TAM_1',"900");
define('TAM_2',"400");
define('TAM_3',"200");
define('TH',"80");

/*Globales de Sistema*/
define('URL_BASE',"http://localhost/sitio_eeaoc/system/application/");
define('PATH_BASE',"C:/AppServ/www/sitio_eeaoc/upload/");
define('PATH_INICIO',"C:/AppServ/www/sitio_eeaoc");

/*Para Facebook*/
define('APP_ID', '201312843260601');
define('APP_SECRET', 'b96882ad6f528c898ecd90fce696fbbb');


/* End of file constants.php */
/* Location: ./system/application/config/constants.php */