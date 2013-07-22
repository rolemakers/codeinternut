<?php

  echo utf8_decode('<center><p>Web Team Rolemak - CodeInternut KOHANA !</p></center>'); 
  
  if(is_dir('modules/codeinternut'))
  {
	  echo utf8_decode('<center><p>Web Team Rolemak - Codeinternut já está instalado em sua aplicação!</p></center>'); 
  }
  else
  {
	shell_exec('wget https://github.com/rolemakers/codeinternut/archive/master.zip');
	shell_exec('mv master.zip modules/master.zip');
	
	if (file_exists('modules/master.zip'))
	{
	  $zip = new ZipArchive;	
	  if ($zip->open('modules/master.zip') === TRUE)
	  {	
		$folde_name = ($zip->statIndex(0));
		$content_name = (substr($folde_name['name'],0, -1));
		$zip->extractTo('modules');
		$zip->close();
	  }  
	  shell_exec('mv modules/codeinternut-master modules/codeinternut && rm modules/master.zip');
	}
	if(is_dir('modules/codeinternut'))
	{
	  echo utf8_decode('<center><p>Web Team Rolemak - Codeinternut instalado com sucesso!</p></center>');
	  echo utf8_decode('<center><p>Web Team Rolemak - Apague o arquivo instalador</p></center>');
	  shell_exec('chmod 0555 -R modules/codeinternut');
	}  
  }
  
?>