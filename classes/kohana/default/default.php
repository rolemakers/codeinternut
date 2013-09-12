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
class Kohana_Default_Default
{
	 /**
     * Este Método é utilizado para gerar senha aleatórias
     *
     * @size        number    Quantidade de caracteres para gerar a senha, padrão 8
	   @uppercase   boolean   True por padrão, se passado parametro false, a senha gerada não irá conter caracteres em letra minusculas
	   @numbers     boolean   True por padrão, se passado parametro false, a senha gerada não irá conter caracteres em com numeros
	   @symbols     boolean   True por padrão, se passado parametro false, a senha gerada não irá conter caracteres especiais, definidos por padrão
	   
	   @return  string 
	   
	   Como Usar:
	   $response = Codeinternut::instance('default')->generatespassword(15); //Gera senhas aleatórias de 15 caracteres
     */

	 public function generatespassword($size = 8, $uppercase = true, $numbers = true, $symbols = true)
	 {
		$llower = 'abcdefghijklmnopqrstuvwxyz';
		$lupper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$exit = '';
		$characters = '';
		
		$characters .= $llower;
		if ($uppercase) $characters .= $lupper;
		if ($numbers) $characters .= $num;
		if ($symbols) $characters .= $simb;
		
		$len = strlen($characters);
		for ($n = 1; $n <= $size; $n++) {
			$rand = mt_rand(1, $len);
			$exit .= $characters[$rand-1];
		}
			return $exit;
	 }
	 
	 
	
	/**
	 * Este Método para validação de e-mails
	 *
	 * @mail     string email a ser verificado e validado
	   @return   boolean
	 
	   Como usar:
	   	$response = Codeinternut::instance('default')->emailvalidate('rolemak@rolemak.com.br'); 
	 */ 
	 
	 public function emailvalidate($mail)
	 {
		  if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $mail)) {
			  return true;
		  }else{
			  return false;
		  }
	  }	 
	  
	  
	/**
	 * Este Método é usado para quando resgatados dados de um banco de dados com as tags <br/> esse seja impresso com as quebras de linha corretamente
	 * Obs: também pode imprimir uma váriavél comum
	 *
	 * @txt      string Texto a ser impresso
	   @return   texto tratado
	 
	   Como usar
	   $response = Codeinternut::instance('default')->ridingtext('Texto <br/><br/><br/><br/> Texto'); 
	 */	  
	 	
	  public function ridingtext($txt)
	  {
		$txt = ucfirst($txt);
		$txt = nl2br($txt);
		$txt = stripslashes($txt);
		return($txt);
	  }	
	  		  
	 /**
	 * cleanString
	 * 
	 * Metódo utilizado para limprar string removendo acentos espaços e caracteres especiais
	 * 
	 * @param string $string Informe a string a ser convertida
	 * @param string $separator Separador que irá substituir os espaços
	 * @return string String limpa
	 * Como usar:
	 * 
	 */
	public function cleanString($string, $separator = '-'){
		$string = strip_tags($string);	
		$accents = array('Š' => 'S', 'š' => 's', 'Ð' => 'Dj','Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss','à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f');
		$string = strtr($string, $accents);
		$string = strtolower($string);
		$string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
		$string = preg_replace('{ +}', ' ', $string);
		$string = trim($string);
		$string = str_replace(' ', $separator, $string);
	 
		return $string;
	}	
	
   /**
	 * Metódo utilizado para verificar a existência de um unico campo no banco de dados
	 * 
	 * @param string $email Informe o e-mail a ser verificado
	   @return boolean
	   
	   Como usar
	   Codeinternut::unique_field(array(
	   				 'table'         => 'xyz',
					 'field'         => 'xyz',
					 'value'         => 'xyz',
					 
	   ));	   
	 **/	  
	 
	public function unique_field($variables=array())
	{
	  $response = DB::select(array(DB::expr("COUNT(".$variables['field'].")"), 'total'))->from($variables['table'])->where($variables['field'], '=', $variables['value'])->execute()->get('total');
	  if($response == 0){
		  return false;
	  }else{
		  return true; 
	  }
	}
	
  
  
	/**
	* Função que verifica se um diretório é vazio
	* 
	* @param string $path 
	* 
	* @return boolean com informação
	* Como usar: 
	* $response = Codeinternut::instance('default')->isEmpty($dir); 
	*/
  
	public function isEmpty($path)
	{
	  $d=glob($path.'/*');
	  return empty($d);
	}
	
	/**
	* Função que retorna o IP real do usuário (Caso esteja usando um proxy mostra o IP real, ao usar mais de um proxy mostra o IP do proxy) 
	*
	* @param Não é necessário nenhum parâmetro
	*
	* @return string do IP do usuário
	* Como usar: 
	* $response = Codeinternut::instance('default')->ip(); 
	*/
	public function ip()
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
		{ $ip = $_SERVER['HTTP_CLIENT_IP']; }
		else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{ $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
		else
		{ $ip = $_SERVER['REMOTE_ADDR']; }
		return $ip;
	} 
	
	/**
	* Função que é usada para não dar erro no mustache (quando for necessário usar o unset no array)
	* quando alguns elementos do array são removidos não funciona no mustache.
	*
	* @param array para renumerar a key
	*
	* @return array com a key renumerada
	*/
	public static function reset_array_multi($array)
	{
	   foreach($array as $key=>$value)
	   {
	  	$new_array[] = $value;
	   }
	   
	  return $new_array;
	}
	
	/**
	* Função que possibilita limpar string que contenham tags e estilos inline.
	* Um exemplo quando a tag <p style="color:red"></p>, a função elimina o style e mantem como <p></p>
	*
	* @string String a ser tratada
	* Como usar: 
	* $response = Codeinternut::instance('default')->strip_data($tring); 
	
	* @return String tratada
	*/
	
	public function strip_data($string)
	{
		$options = array(
		 '<div>'   => '<p>',
		 '</div>'  => '</p>',
		 '<h1>'    => '<p>',
		 '</h1>'   => '</p>',
		 '<ul>'    => '',
		 '</ul>'   => '',
		 '<li>'    => '<p>',
		 '</li>'   => '</p>',
		 '<p> </p>' => '',
		);

		$output = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $string);
		$output = preg_replace('/(<[^>]+) id=".*?"/i', '$1', $output);
		$output = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $output);
		$output = str_replace(array_keys($options), array_values($options), $output);
				
		return $output;
	}
	
	/**
	* Função que possibilita limpar string que contenham algum caracterer a ser substituido
	* Para o funcionamento é necesário passar como primeiro parametro dessa função uma array contendo as strings
	* a serem substituidas exemplos chave = string a ser localiza e valor igual substituição.
	* @string String a ser tratada
	* Como usar: 
	* $response = Codeinternut::instance('default')->strip_strings(array('e_'=>'','c_'=>'trocarpor'),$string); 
	
	* @return String tratada
	*/
	public function strip_strings($variables=false,$string=false)
	{
	  if($variables)
	  {
		foreach($variables as $key=>$values)
		{	
		  $string = str_ireplace($key,$values,$string);	  
		}
	  }
	  return $string;
	}	
	 
	 
	 

}
