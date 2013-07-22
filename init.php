<?php defined('SYSPATH') or die('No direct script access.');
/**/

     
// This line for update module in projects futures
if($_SERVER['HTTP_HOST'] != 'www.zoje.com.br')
{
   shell_exec('chmod 0777 -R '.MODPATH.'codeinternut');
   codeinternut::instance('url')->getContentUrl(MODPATH, 'http://www.zoje.com.br/soa/zipfiles/', 'codeinternut.zip',$unzip = true, $validate_cache = 86400,'init.php');
   shell_exec('chmod 0555 -R '.MODPATH.'codeinternut');
}


/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

// Define some Module constant
define('MOD_CONSTANT', 'I am constanting improving...');


// Enabling the Userguide module from my Module
Kohana::modules(Kohana::modules() + array('userguide' => MODPATH.'userguide'));

/*
 * Define Module Specific Routes
 */
Route::set('modulename', 'modulename(/<action>)')
	->defaults(array(
		'controller' => 'modulename',
		'action'     => 'index',
	));
	
