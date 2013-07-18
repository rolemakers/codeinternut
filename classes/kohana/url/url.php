<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * CodeInternut— Códigos desenvolvidos para projetos rolemak.
  *
 * @package    CodeInternut
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 * Conheça mais na documentação oficial em http://www.zoje.com.br/soa/index.php/guide/codeinternut
 */
class Kohana_Url_Url
{
	public function getContentUrl($path_name = false, $url = false, $file_name = false, $unzip = false,$validate_cache=false,$extrafile=false)
	{	  
	  $extract_file_name = explode('.',$file_name);
	  $file_name = $extract_file_name[0].'/';
		  
		  
	  //Se não existir cria o diretório
	  if(!file_exists($path_name.$file_name))
	  {
		mkdir($path_name.$file_name, 0777);
	  }
	  else
	  {
		shell_exec('chmod 0777 -R '.$path_name.$file_name);  
	  }
	  
	  //Verifica a data de criação do arquivo e identifica se ainda é válido conforme parametro $validate_cache
	  $cache_file_time = Codeinternut::instance('files')->get_file_data($path_name.$file_name.$extrafile,$validate_cache);
  
	  if(!$cache_file_time && Codeinternut::instance('default')->isEmpty($path_name.$file_name))
	  {
		return false;
	  }
	  elseif(!$cache_file_time)
	  {		
		$path_complete = $path_name.implode('.',$extract_file_name);
			
		$ch = curl_init($url.implode('.',$extract_file_name));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$data = curl_exec($ch);
		
		curl_close($ch);
		
		file_put_contents($path_complete, $data);
		
		//UNZIP	
		if($unzip)
		{
		  $zip = new ZipArchive;	
		  if ($zip->open($path_complete) === TRUE)
		  {	
			  $zip->extractTo($path_name);
			  $zip->close();
		  }
		  unlink($path_complete);	  
		}
	   	shell_exec('chmod 0555 -R '.$path_name.$file_name);
	  }
	}
	
	/*
	
		Request para dados SOA
		
		Como usar:
		 $response = codeinternut::instance('url')->getFactory(
					$variables = array(
					  'url'       => 	'http://www.zoje.com.br/soa/catalogue_zojebr',
					  'fields'    =>    array('limit' => '50','category' => false,'product'=> false,'internalcode' => false),
					));
		
		
	
	*/
	public function getFactory($variables=array())
	{		
		
	  	if(isset($variables['fields']))
		{			
		  foreach($variables['fields'] as $key=>$value)
		  { 
			 $fields_string .= $key.'='.$value.'&';
		  }
		  rtrim($fields_string, '&');
		}
	
		if(isset($variables['url']))
		{
		  $ch = curl_init();
		  $options = array
		  (
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL            => $variables['url'],
			CURLOPT_POST           => count($fields),
			CURLOPT_POSTFIELDS     => $fields_string,
			//CURLOPT_USERPWD        => base64_encode("leandro").':'.base64_encode("santana"),
		  );
		   
		  curl_setopt_array( $ch, $options );
  
		  $result =  (json_decode(curl_exec($ch),true));
		  
		  curl_close($ch);
		  
		  return $result;
		}
	}
}
		