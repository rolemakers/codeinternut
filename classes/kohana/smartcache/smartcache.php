<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Smartcache_Smartcache
{
	/* $file = Less Cache */
	public function lessCache($file=false){
		if(file_exists($file.".less")){
			$date1 = date(filemtime($file.".less"));
			$date2 = date(filemtime($file.".css"));
			if($date1+1500 > $date2){
				Less::compile($file.".less");
			}
		}
	}
}
