<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Modulename Controler
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Modulename
 * @category   Base
 * @author    Leandro Santana
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Controller_Codeinternut extends Controller {

    public function action_index()
    {      	
     
	  $class      = Request::current()->post('class');
	  $method     = Request::current()->post('method');
	  $variables  = Request::current()->post('variables');	  
	  	 
	  if($class && $method)
	  {
	  	$return = Codeinternut::instance($class)->$method($variables);
		echo $return;
	  }
	  else
	  {
	  	echo '<p>Métdo não encontrado.</p>';
	  }
	  
    }
 
}
