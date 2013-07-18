<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Print_Print
{
	  
	/**
	 * Este Método é usado para imprir uma array na tela, seu retorno é o próprio array e o restante da aplicação não é executada.
	 * Obs: também pode imprimir uma váriavél comum
	 *
	 * @array    array a ser impresso
	   @return   array
	 
	   Como usar:
	    Codeinternut::instance('print')->printrd($array);
	 */
	 
	  public function printrd($array)
	  {
		  echo "<div style='z-index: 100; position: absolute; border: 1px sold #666666; background: #cccccc; width: 700px'>";
		  echo "<pre>";
		  print_r($array);
		  echo "</pre>";
		  echo "</div>";
		  die();
	  }	
	  
	/**
	 * Este Método é usado para imprir uma array na tela, seu retorno é o próprio array e o restante da aplicação é executada
	 * Obs: também pode imprimir uma váriavél comum
	 *
	 * @array    array a ser impresso
	   @return   array
	 
	   Como Usar:
	   Codeinternut::instance('print')->printr($array);
	 */	  
	 
	  public function printr($array)
	  {
		  echo "<div style='z-index: 100; position: absolute; border: 1px sold #666666; background: #cccccc; width: 700px'>";
		  echo "<pre>";
		  print_r($array);
		  echo "</pre>";
		  echo "</div>";
	  }
	  
	  	
	/******
	 * Com esse método é possível imprimir um array ou qualquer váriavel direto para um arquivo txt, html, md, etc, possiblitando também o envio desse
	   arquivo para um e-mail, sua utilização é útil para não prejudicar ou expor usuários e equipes de desenvolvimento a erros/mensagens na tela de produção.
	 *
	 * @variables    array com opções que permitam seu uso
	 * @return       arquivo para diretório ou e-mail
	 *
	 *
	 * Como usar:
	 		codeinternut::instance('print')->printrtofile(
					  array(
					  	'content'        => 'variable_for_print',
						'file_name'      => 'myfile.txt',
						'send_email'     => 'leandros@vallery.com.br',
					  ));
	 * Caso o parametro "send_email", não seja informado o arquivo será gravado em um diretório em /application/print_cache/file_name, do contrário
	   o arquivo é enviado por e-mail e não gravado em diretório.
	 *
	 * Na ausência do paramentro "file_name" o arquivo irá adotar o nome do timestamp atual com extensão. md
	 * 
	 *****/	
	 
	  public function printrtofile($variables=array())
	  {

		$dir  = APPPATH.'print_cache/';
		$file = $variables['file_name'] ? $variables['file_name'] : time().'.md';
		if(!is_dir($dir))
		{
		  mkdir($dir, 0777, true);
		}
		$f = fopen($dir.$file, 'w+');
		fwrite($f, "********* Arquivo criado em: " . date(" d/m/Y "." H:m:s ") . "*********" . "\r\n");
		$results = print_r($variables['content'], true);
		fwrite($f, $results . "\r\n");	
		shell_exec('chmod 0777 -R '.$dir);
		fclose($f);

		if($variables['send_email'])
		{
		  $module = Codeinternut::instance('mail');
		  
		  $module->sendmail(array(
			'from'               => 'rolemak@rolemak.com.br',
			'fromname'           => utf8_decode('Rolemak Send´s'),
			'to'                 => $variables['send_email'],
			'subject'            => utf8_decode('...:Print to File:... - Codeinternut'),
			'body'               => utf8_decode('Faça o Download de seu arquivo!'),
			'authentication'     => true,
			'attachment'         => true,
			'attachment_content' => array('content' => $content = file_get_contents($dir.$file), 'file_name' => 'file.txt'),
		  ));
		
		  if($send)
		  {
		  	unlink($dir.$file);	
		  }
		}		
	  }	  
}