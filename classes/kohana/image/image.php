<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Image_Image
{
	/*
	Instalando o SCREENSHOTS
	sudo apt-get install python-qt4 libqt4-webkit python-pip xvfb
	$ wget https://raw.github.com/millisami/python-webkit2png/master/webkit2png.py
	$ chmod +x webkit2png
	EX: $ sudo xvfb-run --server-args="-screen 0, 1024x768x24" ./webkit2png.py -o google.png http://www.google.com
	
	Como usar:
	Codeinternut::instance('image')->webscreenshots();
	*/
	
	  /*
      Ex:
	  $save_dir = '/var/www/data/apache2/zoje-soa/imagefly/teste';
	  $complete_url = '/var/www/data/apache2/zoje-soa/imagefly/teste.html';
	  $save_data = se true, ativa save em banco de dados de media
	  teste    = xvfb-run --server-args="-screen 0, 1024x768x24" ./webkit2png.py -o google.png http://www.google.co
     */
	 
	 
	 
		
	public function webscreenshots($complete_url=false,$save_dir=false,$save_data=false)
	{
		shell_exec('xvfb-run --server-args="-screen 0, 1024x768x24" /usr/bin/./webkit2png.py -o '.$save_dir.'.png '.$complete_url);

		if($save_data)
		{
			// contruindo as variaveis
			$data['m_name']  = 'screenshot-'.time();
			$data['m_type']  = 'png';
			$data['it_name'] = 15;
			$data['m_image'] = Image::factory($save_dir.'.png');
			$id = Codeinternut::instance('sql')->dbsave('media', $data);
			return $id;
		}
		return true;		
	}	
	
}