<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Catalogue_Catalogue extends Kohana_Catalogue_Categories
{
	
		
	/***
	* Construindo váriavéis para utilizar nesse objeto e em suas heranças;
	* soaAddress é encontrado em modules/codeinternut/config/soaAddress.php
	* Informe nesse arquivo as url necessárias para acionar os catalogos.
	*/
	
	public function __construct()
	{
	  $this->configs = Kohana::$config->load('soaAddress')->as_array();
	  foreach($this->configs as $key => $val)
	  {
		$this->$key = $val;
	  }	  	  	
	}
	  
    /***
     * Catalogo de Máquinas
     * @variables      array    conjunto de variaveis para leitura do catalogo SOA de Maquinas de Costura
	 * @return  Array 
	   
	 * Como Usar:
	 * $products = codeinternut::instance('catalogue')->machines(
					$variables = array(
								'options'=> array('brand'=> 'zoje','category'=> false,'subcategory' => false, 'product'=> false,'limit'=> 200,),
								'cache' => array('active' => true,'save_path' => APPPATH.'sql_cache/', 'life_time'=> 172800,)
								 ));
    */	
	public function machines($variables=array())
	{				  	
	
	  if($variables['options'])
	  {
		$variables_fixed = array('root'=>  '5');
		
		(!$variables['options']['brand'] ? $variables['options']['brand'] = 'zoje' : $variables['options']['brand'] = $variables['options']['brand'] );
		
		$variables['options'] = array_merge($variables['options'],$variables_fixed);
		
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
			'soa_url'        => $this->soa_url, 
			'soa_conditions' => $variables['options'],	
			'sql_query'      => false));
	  }
	  else
	  {
		$catalogue = request::factory($this->soa_url)->method('POST')->post($variables['options'])->execute();		
		$response = json_decode($catalogue, true); 
	  }
	  
	  $new_response['trail'] = $response['trail'];
	  $new_response['Unity'] = $response['Unity'];

	  $new_response['rows']  = $response['rows'];
		  
	  count($response['products']['product_id']) ? $new_response['products'][] = $response['products'] 
												 : $new_response['products']   = $response['products'];		
	  
	  return $new_response;	  
	}

 	 /** Catalogo Zoje BR
	 *
     * @variables      array    conjunto de variaveis para leitura do catalog SOA de Maquinas de Costura ZOJE BR
	 * @return  Array 
	 * 
	 * Como Usar:
	   $products = codeinternut::instance('catalogue')->machinesZojeBr(
					  $variables = array(
									'options'=> array('limit' => false,'category' => false,'product'=> false,'internalcode' => false),
									'cache' => array('active' => true,'save_path' => APPPATH.'sql_cache/','life_time'=> 172800)
									));							  
    */			
	public function machinesZojeBr($variables=array())
    {		
	  
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
			'soa_url'        => $this->soa_zojebr, 
			'soa_conditions' => $variables['options'],	
			'sql_query'      => false));
	  }
	  else
	  {
		$json = Request::factory($this->soa_zojebr)->method('POST')->post($variables['options'])->execute()->body();
		$response = json_decode($json, true);	 
	  }	  
	  return $response;	 
	}
	
	
	/*
	Merge Zoje BR X SOA Vallery
	
	Como usar:
	$products = codeinternut::instance('catalogue')->merge_machines_zojebr(
					$variables = array(
								'options'=> array('brand'=> 'zoje','category'=> false,'subcategory' => false, 'product'=> false,'limit'=> 300),
								'cache' => array('active' => true,'save_path' => APPPATH.'sql_cache/', 'life_time'=> 172800,)
								 ));	
	
	
	*/
	public function merge_machines_zojebr($variables=array())
	{
		
	  // *** Construindo o nome do arquivo com as opções de select *** //
	  if($variables['options'])
	  {		
		foreach($variables['options'] as $key=>$values)
		{
		  ($values) ? $options .= '-'.$values : ''; 
		}			
	  }
	  $file_name   = $variables['cache']['save_path'].__FUNCTION__.$options.'.txt';
	  
	  if($variables['cache']['active'])
	  {		
	  	$cache_file_time = Codeinternut::instance('files')->get_file_data($file_name,( $variables['life_time'] ?  $variables['life_time'] : 86400 ));
		if($cache_file_time)
		{
			$response = Codeinternut::instance('files')->read_array_file($file_name);		
		}
	  }
	  
	  if(!count($response))
	  {
		// *** Vallery *** //
		$soa_vallery = self::machines($variables);
		
		foreach($soa_vallery['products'] as $keys=>$values)
		{
			$change_key_soa_valley[$values['e_modelo']] = $values;
		}
		
		// ***Zoje BR *** //	
		$soa_zojebr  = self::machinesZojeBr($variables = array(
									  'options'=> array('limit' => false,'category' => false,'product'=> false,'internalcode' => false),
									  'cache' => array('active' => true,'save_path' => APPPATH.'sql_cache/','life_time'=> 172800)
									 ));
		foreach($soa_zojebr['products'] as $keys=>$values)
		{
		  $change_soa_zojebr[$values['p_internalcode']] = $values;
		}
		
		// *** Merge Catalogo *** //
		foreach($change_key_soa_valley as $key=>$value)
		{
		  if(array_key_exists($key, $change_soa_zojebr))
		  {	
			$new_response['products'][] = array_merge($change_key_soa_valley[$key], $change_soa_zojebr[$key]);
		  }
		  else
		  {
			$new_response['products'][] = $value;
		  }
		}
		$response['rows']     = count($new_response['products']);
		$response['products'] = $new_response['products'];
		Codeinternut::instance('files')->record_array_file($file_name,$response);
	  }

	  return 	$response;			 	
	}
	
}