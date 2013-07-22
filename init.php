<?php defined('SYSPATH') or die('No direct script access.');
/*
	VERSIONAMENTO DO MODULE	
	atualização do modulo para os projetos
*/
$config = Kohana::$config->load('config')->as_array();
foreach($config as $key => $val)
{
  $request_configs[$key] = $val;
}	

$start_update = codeinternut::instance('files')->get_file_data(__FILE__,$request_configs['update_time']);
if($request_configs['update_module'] && !$start_update)
{
  shell_exec('wget '.$request_configs['url_module'].'/'.$request_configs['file_name']);
  shell_exec('mv '.DOCROOT.$request_configs['file_name'].' '.MODPATH.$request_configs['file_name']);
  
  if (file_exists(MODPATH.$request_configs['file_name']))
  {
	$zip = new ZipArchive;	
	if ($zip->open(MODPATH.$request_configs['file_name']) === TRUE)
	{	
	  $folde_name = ($zip->statIndex(0));
	  $content_name = (substr($folde_name['name'],0, -1));
	  $zip->extractTo(MODPATH);
	  $zip->close();
	}  
	if(is_dir(MODPATH.$content_name))
	{
	  shell_exec('rm -r '.MODPATH.$request_configs["module_name"].' && mv '.MODPATH.$content_name .' '.MODPATH.$request_configs["module_name"]);
	  shell_exec('rm '.MODPATH.$request_configs['file_name'].'&& chmod 0555 -R '.MODPATH.$request_configs["module_name"]);
	}
  }  
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
	
