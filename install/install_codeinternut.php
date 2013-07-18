<?php
		
  /*
  	INSTALL CODE INTERNUT

  */
  echo utf8_decode('<center><p>Web Team Rolemak - Instalador do modulo CodeInternut!</p></center>'); 
  if($_SERVER['HTTP_HOST'] != 'www.zoje.com.br')
  { 
	 getContentUrl('modules/', 'http://www.zoje.com.br/soa/zipfiles/', 'codeinternut.zip',$unzip = true, $validate_cache = 1);
  }
  
  
  /*
  	GET CONTENT URL
  */
  function getContentUrl($path_name = false, $url = false, $file_name = false, $unzip = false,$validate_cache=false)
  {	  
	
	$folder_name = explode('.',$file_name);
	
	if(!file_exists($path_name))
	{
	  echo utf8_decode('A pasta de '.$path_name.' não foi encontrada, verifique e tente novamente!');
	  exit;
	}
	elseif(is_dir($path_name.$folder_name[0].'/'))
	{
	  echo utf8_decode('<center><p>Web Team Rolemak - O módulo já foi instalado, as atualizações serão fornecidas diariamente de forma automática.!</p></center>');
	  unlink($_SERVER['SCRIPT_FILENAME']);
	  exit;
	}

	$ch = curl_init($url.$file_name);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	$data = curl_exec($ch);	
	curl_close($ch);	
	file_put_contents($path_name.$file_name, $data);
	
	//UNZIP	
	if($unzip)
	{
	  $zip = new ZipArchive;	
	  if ($zip->open($path_name.$file_name) === TRUE)
	  {	
		  $zip->extractTo($path_name);
		  $zip->close();
	  }
	  unlink($path_name.$file_name);	  
	}
	shell_exec('cd '.$path_name.' && chmod 777 -R '.$folder_name[0]);
	
	
	if(is_dir($path_name.$folder_name[0].'/'))
	{	
		echo utf8_decode('<center><p>Web Team Rolemak - Modulo instalado com sucesso!</p></center>');
		unlink($_SERVER['SCRIPT_FILENAME']);
		if(!file_exists('install_codeinternut.php'))
		{
			echo utf8_decode('<center><p>Web Team Rolemak - Arquivo de instalação excluido com sucesso!</p></center>');
		}		
	}
	else
	{
		echo utf8_decode('<center><p>Web Team Rolemak - Desculpe houve alguma problema com a instalação, tente novamente mais tarde!</p></center>');
	}
	
  }

?>