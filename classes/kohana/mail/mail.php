<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Products Rolemak
 * @package    Products Rolemak
   @$url       Definido por padrão
 * @category   Base
 * @author     WebTeam Rolemak
 * @copyright  (c) 2013 WebTeam Rolemak
 */
class Kohana_Mail_Mail
{
	
	/***
	* Construindo váriavéis para utilizar nesse objeto e em suas heranças;
	* mailer é encontrado em modules/codeinternut/config/mailer.php
	* Informe nesse arquivo as credenciais necessárias para o envio do e-mail autenticado;
	*/
	
	public function __construct()
	{
	  $this->configs = Kohana::$config->load('mailer')->as_array();
	  foreach($this->configs as $key => $val)
	  {
		$this->$key = $val;
	  }	  	  	
	}
	
	/**
	* Método para instanciar PHPMailer
	*
	*/
	public function instance()
	{
	  $classe = 'Kohana_Mail_Mailer_Phpmailer';
	  return new $classe;
	}
	
  /**
   * Método responsável pelo o envio de e-mails
   * Algumas opções são ativadas de acordo com a necessidade do sistema, são elas o envio de anexos e o envio de mensagem autenticada.
   *
   * Como usar:
   * Codeinternut::instance('mail')
					  ->sendmail(array(
					  	       'from'               => 'rolemak@rolemak.com.br',
							   'fromname'           => 'Remetente da mensagem',
							   'to'                 => 'leandros@vallery.com.br',
							   'subject'            => 'Assunto da mensagem',
							   'body'               => '<p>Corpo da mensagem</p>',
							   'authentication'     => true,
							   'attachment'         => true,
							   'attachment_content' => array('content' => $content, 'file_name' => 'file.txt'),
					  ));
   *
   * Cada varívavel têm um função especifica, segue detalhes:
   * @ from      string Informe o e-mail que será o remetente da mensagem, visível para o usuário que receber o e-mail
   * @ fromname  string Informe o nome do remetente da mensagem, visível para o usuário que receber o e-mail
   * @ to        string/array Informe nesse campo o endereço de e-mail do destinatário da mensagem, esse campo pode ser um array contendo 
   							  vários e-mails a função se encarrega de enviar para cada e-mail listado
                              exemplo array(0=>'email1@email.com.br', 1=>'email2@email.com.br'.....)
   * @ subject	          string Informe o assunto da mensagem, visível para o usuário que receber o e-mail		
   * @ body               string Informe o corpo da mensagem, pode ser um HTML formado com CSS inline
   * @ authentication     boolean Com essa opção como TRUE o e-mail é enviado com atenticação conforme definido no arquivo config/mailer.php na raiz do modulo
   * @ attachment         boolean Com essa opção como TRUE é possível ativar o envio de anexo na mensagem
   * @ attachment_content array Após ativado a opção de envio de anexo nessa varíavel é necessário informar o arquivo que será enviado e o nome que será visível para o usuário que receber;
   								exemplo: array('content' => $content, 'file_name' => 'file.txt'), o conteúdo/arquivo deve ser um binário para conseguir use a função file_get_contents
								exemplo: $content = file_get_contents(APPPATH.'print_cache/file.txt');
   *							
   */
	public function sendmail($variables=array())
	{
		
	  $mailer = $this->instance();	
	  $mailer->IsSMTP();	  
	  $mailer->SetLanguage("br");
	  $mailer->IsHTML(true);
	  $mailer->From = $variables['from'];
	  $mailer->FromName = $variables['fromname'];
	  $mailer->Port     = 25;  
	  
	  if($variables['authentication'])
	  {
		$mailer->SMTPAuth   = true;
		$mailer->SMTPSecure = $this->SMTPSecure;
		$mailer->Host       = $this->smtp;
		$mailer->Username   = $this->email;
		$mailer->Password   = $this->password;
		$mailer->Sender     = $variables['from']; 
	  }
	  
	  if(is_array($variables['to']))
	  {
		foreach($variables['to'] as $key=>$values)
		{
		  $mailer->AddAddress($values);	
		}
	  }
	  else
	  {
	  	$mailer->AddAddress($variables['to']);	
	  }
	  
	  if($variables['attachment'])
	  {
		$mailer->AddStringAttachment($variables['attachment_content']['content'], $variables['attachment_content']['file_name']);
	  }	  
	  
	  $mailer->Subject = $variables['subject'];
	  
	  
	  $mailer->Body    = $variables['body'] ? $variables['body'] : '&nbsp;';
	  
	  if(!$mailer->Send())
	  {
		return false;
	  }
	  else
	  {
		return true;
	  }
	}
}
