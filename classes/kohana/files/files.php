<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Files Functions
 * @package    Files Functions
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
	 
	   /*
		 Metódo utilizado para criar cache HTML para KOstache
		 *
		 * @ $variables array variaveis para uso da função.*
		 * @return Array
		 *
		 *
		 Como usar:
		 $response = Codeinternut::instance('files')->kostache_cache(
		 array(
		 'content'  => 'Model_Index::GetTesteIndex()', // Função ou array em para uso no mustache, se for função passe como string usando ''
		 'lifetime' => 30,                            // Tempo de duração do cache em segundos
		 'cache_name'=>__FUNCTION__                  // nome do cache a ser armazenado na pasta padrão do modulo cache Kohana
		 ));
		 *
	*/
	
	public function kostache_cache($variables)
	{			
		// trata a variável content, uma vez passada como string como um código php essa é tratada e retornada seu resultado original.
		if(is_string($variables['content']))
		{			
			
			$string_content = '$content  = '.$variables['content'].';';
			eval($string_content);
		}
		else
		{			
			$content = $variables['content'];
		}

		// Busca por cache ativo ou cria um novo.
		$KOstache_cache    = Cache::instance('file')->get($variables['cache_name']);	
 		if ($KOstache_cache)
	  	{	
			return $KOstache_cache;			
		}
		else
		{			
			Cache::instance('file')->set($variables['cache_name'], $content, $variables['lifetime']);			
			return $content;
		}			
	}
	
	/*
		Metódo utilizado para carregar Less Cache rapidamente
		 *
		 * @ $file = nome do arquivo less
		 *
		 *
		 Como usar:
		 Codeinternut::instance('files')->lessCache(DOCROOT. "assets/less/default");
	*/
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
