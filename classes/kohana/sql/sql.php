<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Sql_Sql
{
		 
	 /*
		* Este Método para qualquer necessidade de usar o Banco de dados
		* Principalmente usada para fazer um select
		
		Como Chamar a função na aplicação:
		$array = Codeinternut::dbselect("SELECT * FROM videos");
		
		Caso seja em um Banco de dados diferente:
		$array = Codeinternut::instance('sql')->dbselect("SELECT * FROM videos", "zoje");
	*/

	public function dbselect($sql, $db=NULL, $soa_url=NULL)
	{
		if($soa_url == true)
		{
			$array = Request::factory($soa_url)
			->method('POST')
			->post(array('sql' => $sql, 'db' =>$db))
			->execute()
			->body();
		}
		else
		{
			$array = DB::query(Database::SELECT, $sql)->execute($db)->as_array();
		}
		
		return $array;
	}
	  
	
	/*
	   Metódo utilizado para gravar ou atualizar dados em uma tabela do banco de dados, que esteja configurado no database da aplicação.
	 *
	 * @$table      string  nome da tabela em que os dados serão salvos
	   @$data       array   array contendo nome do campo => valor do campo a ser alterado, se entre as chaves estiver a chave primaria com uma valor existente
	   no banco de dados os dados então serão atualizado.
	  
	   @return      string  ùltima chave alterado primarykey
	 
	   Como Chamar a função na aplicação:
	   $var = Codeinternut::instance('sql')->dbsave($table,array('campo'=>'valor',campo2=>'valor2',campor3=>'valor3'...));
	 */	
	 	
	  public function dbsave($table,$data)
	  {
		if (!$table || !$data) {
			return false;
		}
		$fields = array();
		$updatefields = array();
		$values = array();
		foreach ($data as $fieldname => $value)
		{
		  $value = addslashes($value);
		  $values[] = "'{$value}'";
		  $fields[$fieldname] = "`{$fieldname}`";	
		  $updatefields[] = "`{$fieldname}` = '{$value}'";
		}
		$fields = implode(',', $fields);
		$updatefields = implode(',', $updatefields);
		$values = implode(',', $values);
		$sql = ("INSERT INTO `{$table}` (" . $fields .') VALUES (' . $values . ') ON DUPLICATE KEY UPDATE ' . $updatefields);
		$query = DB::query(Database::INSERT, $sql)->execute();
		if($query)
		{
		  return mysql_insert_id(); 	
		}else
		{
		  return false;
		}
	  }
	  
	/*
	   Metódo utilizado para deletar alguma item do banco de dados
	 *
	 * @$id                string/number  valor de comparação para deletar no banco de dados se for chave primaria irá deletar somente um objeto, se for chaves duplicadas
	                               irá deletar todas as chaves de igual valor.
	   @$table		       string         nome da tabela que sofrerá alteração				   
	   @$field             string   nome do campo de comparação para excluir os dados;
	  
	   @return      string  ùltima chave alterado primarykey
	 
	   Como Chamar a função na aplicação:
	   $var = Codeinternut::instance('sql')->dbdelete($table,array('campo'=>'valor',campo2=>'valor2',campor3=>'valor3'...));
	 */	
	 	  
	  static function dbdelete($id,$table,$field)
	  {
		if($id && $table && $field)
		{
			$sql = sprintf("DELETE FROM `".$table."` WHERE ".$field."='%s'",$id);
			$query = DB::query(Database::DELETE, $sql)->execute();		
			if($query == true)
			{ 
			  return true;
			}
			else{
			  return false;
			}
		}	
		return false;
	  }

	/**
	* Com esse método é possível executar um select em uma tabela e armazenar em cache, após a primeira consulta um cache é armazenado em arquivo txt e
	  em suas próximas consultas até se encerrar o sua lifetime o conteúdo é gerado a partir de um arquivo .txt e não em uma nova consulta sql, otimizando o resultado
	  e agilizando sua resposta.
	*
	*@variables array contendo todas as variaveis possíveis para consulta;
	*@return array com todos os dados solicitados
	*
	* Como usar	
		$response = codeinternut::instance('sql')->gera_cache_sql(
			  array(
			  'save_path'      => '/var/www/projeto/mysqcache', // caminho para salvar e/ou buscar o cache
			  'life_time'      => 17800, //tempo de vida do cache
			  'file_name'      => 'teste.txt', 
			  'soa_url'        => 'www.soa.com.br/query', // or false se não for definido nada
			  'soa_conditions' => $variables['options'],	 //condições para consulta no SOA em array exemplo 'options'=> array('limit'=>false,'category'=>false,'product'=> false,'internalcode' => false),								  
			  'sql_query'      => "SELECT * FROM resellers", //select em banco local, com essa opção ativa inutiliza a opção de soa_url e suas conditions, lembre-se de definir o nome correto do arquivo para o cache		
			  'database'       => 'mydb', Banco a ser selecionado, essa opção é possível após a configuração do config/database de sua aplicação.
			  )
			);
	* 
	****/
	
	public function generate_cache_sql($variables)
	{
	  $file_name       = $variables['save_path'].$variables['file_name'];
	  $cache_file_time = Codeinternut::instance('files')->get_file_data($file_name,( $variables['life_time'] ?  $variables['life_time'] : 86400 ));
	 
	  if($cache_file_time)
	  {
		$response = Codeinternut::instance('files')->read_array_file($file_name);
	  }
	  else
	  {
		if($variables['soa_url'] && !$variables['sql_query'])
		{	
		  $json = Request::factory($variables['soa_url'])->method('POST')->post($variables['soa_conditions'])->execute()->body();
		  $response = json_decode($json, true);	
		}
		elseif($variables['sql_query'])
		{
		  $sql = sprintf($variables['sql_query']);
		  $response = DB::query(Database::SELECT, $sql)->execute($variables['database'])->as_array();			
		}
		
		if(count($response))
		{
		   Codeinternut::instance('files')->record_array_file($file_name,$response);
		   $response = Codeinternut::instance('files')->read_array_file($file_name);
		}
	  }
	  
	  return $response; 
	}
	
	/**
	*
	* Função para limpar uma pasta de caches sql
	*
	* Como Usar
	* $response = odeinternut::instance('sql')->clear_cache_sql(
									array(
										'dir_path'=>APPPATH.'sql_cache/'
									));
	*
	* @return  boolean;
	*/
		 
	public function clear_cache_sql($variables)
	{
	  if($variables['dir_path'])
	  {
	  	shell_exec('rm -rf '.$variables['dir_path'].'*');		
		
		if(Codeinternut::instance('default')->isEmpty($variables['dir_path']))
		{
		  return true;
		}
		else
		{
			return false;	
		}
	  }
	  else
	  {
		return false;
	  }
	}	

}
