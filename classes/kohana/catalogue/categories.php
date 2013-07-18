<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Catalogue_Categories
{

	# Menu Catalogo Maquinas Vallery
		
	 /*
     * Menu Categorias
     * @variables      array    conjunto de variaveis para leitura do catalog menu9 SOA de Maquinas de Costura
	 * @return  Array 
	   
	 * Como Usar:
	   $menu = codeinternut::instance('catalogue')->machinesMenu(
													$variables = array(
													  'options'=> array('brand' => 'zoje'),
													  'cache' => array('active' => true,'save_path'=> APPPATH.'sql_cache/','life_time'=> 172800,)
													));
    */			
	public function machinesMenu($variables=array())
    {	
	
	  if($variables['options'])
	  {
		$variables_fixed = array('segid'=> "1");
		
		(!$variables['options']['brand'] ? $variables['options']['brand'] = 'zoje' : $variables['options']['brand'] = $variables['options']['brand'] );
		
		$variables['options'] = array_merge($variables['options'],$variables_fixed);
		
		foreach($variables['options'] as $key=>$values)
		{
		  ($values) ? $options .= '-'.$values : ''; 
		}			
	  }
	  
 	   // Construindo o nome do arquivo com as opções de select	
	  if($variables['options'])
	  {		
		foreach($variables['options'] as $key=>$values)
		{
		  ($values) ? $options .= '-'.$values : ''; 
		}			
	  }
	  
	  // Com cache ativo	
	  if($variables['cache']['active'])
	  {	
	    
		$response = codeinternut::instance('sql')->generate_cache_sql(
		  array(
			'save_path'      => $variables['cache']['save_path'],
			'life_time'      => $variables['cache']['life_time'],
			'file_name'      => __FUNCTION__.$options.'.txt',
			'soa_url'        => $this->soa_menu, 
			'soa_conditions' => $variables['options'],	
			'sql_query'      => false));
	  }
	  else
	  {
		$json = Request::factory($this->soa_menu)->method('POST')->method('POST')->post($variables['options'])->execute();
		$response = json_decode($json, true);	
	  }
	  $new_response = codeinternut::instance('default')->reset_array_multi($response);
	  return $new_response;	 	  
	}
	
}