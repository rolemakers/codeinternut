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
class Kohana_Login_Login
{
	/**
	  * 
	  * Função usada para o login
	  *
	  * Como Usar
	  * $response = codeinternut::instance('login')->login($post);
	  *
	  * o $post deverá conter $_POST['email'] && $_POST['password']
	  *
	  * $return referrer ou errors;
	 */
	 
	 public function login($post, $referrer=false)
	 {
		if(!$post)
		{
			$response['text'] =  Kohana::message('messages', 'notPost');
		}
		elseif(!$post['email'])
		{
			$response['text'] =  Kohana::message('messages', 'notEmail');
		}
		elseif(!$post['password'])
		{
			$response['text'] =  Kohana::message('messages', 'notPassword');
		}
		
		if($post)
		{
			$validation = Validation::factory($post)
			 ->rule('email' , 'not_empty')
			 ->rule('email', 'email')
			 ->rule('password' , 'not_empty');
		
			if($validation->check())
			{
			   $auth = Auth::instance()->login($post['email'], $post['password'],false);
			  
			   if(!$auth)
			   {
				 $response['text'] =  Kohana::message('messages', 'notlogin');
				 $response['type'] =  "error";
			   }
			   else
			   {
				   if($auth > 0)
				   {
					   $response['text'] =  Kohana::message('messages', 'logged-success');
					   $response['type'] =  "success";
					 if($referrer)
					 {
						 unset($post);
						$this->request->redirect($referrer);
					 }
				   }
			   }
			}
			else
			{
			   $response['text'] = $validation->errors('forms');
			}
			
			if($response)
			return $response;
			else
			return true;
		}
	 }
}