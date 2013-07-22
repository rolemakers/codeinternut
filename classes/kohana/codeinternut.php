<?php defined('SYSPATH') or die('No direct access allowed.');

///Leandro
/**
 * CodeInternut— Códigos desenvolvidos.
  *
 * @package    CodeInternut
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 * Conheça mais na documentação oficial em http://www.zoje.com.br/soa/index.php/guide/codeinternut
 */
class Kohana_Codeinternut{
		
	/***
	* Essa função permite a utilização de um metódo de um outro objeto/classe criada na estrutura de códigos 
	* desse módulo, instancie a classe e depois chame o método a ser utilizado.
	
	@ $param string objeto a ser instanciado;
	
	*
	*Como usar;
		$response =   Codeinternut::instance('print')->printr($array);
		$response =   Codeinternut::instance('database')->dbsave($table, $array);
	*														  
	*
	*/	
	public static function instance($param)
	{
		$classe = 'Kohana_'.ucfirst($param).'_'.ucfirst($param);
		return new $classe;
	}
	
	/***
	* Essa função é responsável por instanciar e listar todos os metodos contidos em um objeto selecionado pelo parametro $param
	*
	
	@ $param string objeto a ser instanciado;
	*
	*Como usar:
			$methods = Codeinternut::getmethods('print');
			$methods = Codeinternut::getmethods('database');
			$methods = Codeinternut::getmethods('catalogue');
	*/
	public static function getmethods($param)
	{		
		return get_class_methods(self::instance($param));
	}	
	
	
	
}
	  
	  
	  
