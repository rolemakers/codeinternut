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
		
		$options = '';
		foreach($variables['options'] as $key=>$values)
		{
		  ($values) ? $options .= '-'.codeinternut::instance('default')->cleanString($values) : ''; 
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
	  	$options = '';
		foreach($variables['options'] as $key=>$values)
		{
		  ($values) ? $options .= '-'.codeinternut::instance('default')->cleanString($values) : ''; 
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
	  
	  // tratando variáveis e criando nome do arquivo que armazena o cache da consulta.
	  if($variables['options'])
	  {		
	  	$options = '';
		foreach($variables['options'] as $key=>$values)
		{
		  ($values) ? $options .= '-'.codeinternut::instance('default')->cleanString($values) : ''; 
		}			
	  }
	  $file_name   = $variables['cache']['save_path'].__FUNCTION__.$options.'.txt';
	  
	  // verificando a existência de um arquivo de cache e retornando seus valores.
	  if($variables['cache']['active'])
	  {		
		$cache_file_time = Codeinternut::instance('files')->get_file_data($file_name,( $variables['life_time'] ?  $variables['life_time'] : 86400 ));
		if($cache_file_time)
		{
			$response = Codeinternut::instance('files')->read_array_file($file_name);
		}
	  }
	  
	  //fazendo a consulta e criando um arquivo cache para leitura futura.
	  if(!count($response))
	  {
		
		// resgatando dados do catalogo em vallery
		$soa_vallery = Codeinternut::instance('catalogue')->machines($variables);
		$changes_keys_v = array('e_'=> '');
		foreach($soa_vallery['products'] as $keys=>$values)
		{	
		  foreach($values as $key_value=>$value_values)
		  {  
			$products['vallery'][$values['e_modelo']]['v_'.Codeinternut::instance('default')->strip_strings($changes_keys_v,$key_value)] = $value_values;
		  }
		}
		
		// resgatando dados do catalogo em zoje.br	
		$soa_zojebr  = Codeinternut::instance('catalogue')->machinesZojeBr($variables = array(
						  'options'=> array('limit' => false,'category' => false,'product'=> false,'internalcode' => false),
						  'cache' => array('active' => true,'save_path' => APPPATH.'sql_cache/','life_time'=> 172800)
						));
		$changes_keys_z = array('p_'=>'', 'c_'=>'');			
		foreach($soa_zojebr['products'] as $keys=>$values)
		{
		  foreach($values as $key_value=>$value_values)	
		  {  
			$products['zoje'][$values['p_internalcode']]['z_'.Codeinternut::instance('default')->strip_strings($changes_keys_z,$key_value)] = $value_values;
		  }			
		}
		
		// Comparando chaves e efetuando o merge de das informações em seus respectivos arrays
		foreach($products['vallery'] as $key=>$value)
		{
		  if(array_key_exists($key, $products['zoje']))
		  {	
			$new_response['products'][] = array_merge($products['vallery'][$key], $products['zoje'][$key]);
		  }
		  else
		  {
			$new_response['products'][] = $value;
		  }
		}
		
		$response['rows']      = count($new_response['products']);
		$response['trail']     = $soa_vallery['trail'] ? $soa_vallery['trail'] : '';
		$response['Unity']     = $soa_vallery['Unity'] ? $soa_vallery['Unity'] : '';
		$response['products'] = $new_response['products'];
		Codeinternut::instance('files')->record_array_file($file_name,$response);		
						
	  }

		return $response;	  
	}
	
	
}
