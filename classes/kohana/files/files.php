<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Files_Files
{
	
     /***
	   Metódo utilizado para verificar data de criação de um determinado arquivo
	 *
	 * @$file_name         string   caminho completo do arquivo a ser verificado    
	   @$validate_cache	   string   valor de comparação para o tempo de criação do arquivo.
	   
	   Ex: se o o valor($validate_cache) informado for menor do que a data de criação do arquivo($file_name) a função retorna false			   
	  
	   @return      Boolean
	 
	   Como Chamar a função na aplicação:
	   Codeinternut::instance('files')->get_file_data($file_name,$validate_cache)

	 */	
	 
	  public function get_file_data($file_name,$validate_cache,$return=true)
	  { 	
	  
		file_exists($file_name) ? shell_exec('chmod -R 777 '.$file_name) : $return = false;	  
			
		if($return)
		{
		   $time = time() - (filemtime($file_name)); 
		  ($time > $validate_cache) ? $response = 0 : $response = 1;
		}
		else
		{
			$response = 0;
		}
		return $response;
	  }
	  
  	/*
	   Metódo utilizado para ler um arquivo em array gravado em um txt, normalmente utilizado após a criação de um cache de dados para posterior leitura;
	 *
	 * @$file_name         string   caminho completo do arquivo a ser lido e interpretado 
	   @return      array
	   Como Chamar a função na aplicação:
	   Codeinternut::read_array_file('caminho_do_arquivo')

	 */	
	 	  
	  public function read_array_file($file_name)
	  {	  
		  $fd = @fopen($file_name, 'r');
		  $file_content = fread($fd, filesize($file_name));
		  fclose($fd);
		  $array = unserialize($file_content);
		  return $array;
	  }
	  

	/*
	   Metódo utilizado para gravar um array em um arquivo txt, com a possibilidade de posterior leitura deste,utilizado para fins de armazenagem de cache de dados
	 *
	 * @$file_name         string   caminho completo do arquivo a ser lido e interpretado 
	   @$array             string   array de dados enviada para gração
	   @return      array
	   Como Chamar a função na aplicação:
	   Codeinternut::record_array_file('caminho _do_arquivo',array('field'=>'valor1','field2'=>'valor2'....)) 

	 */	
	 
	  public function record_array_file($file_name,$array) 
	  { 
		  (is_array($array)) ? $content = serialize($array) : $content = $array;
		  $fd = @fopen($file_name, 'w+');
		  fwrite($fd,$content);
		  fclose($fd);
		  chmod($file_name, 0777);
		  return true;
	  }	
	  
}