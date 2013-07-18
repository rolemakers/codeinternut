# Envio de E-mails

Esse método consiste em enviar e-mail utilizando a classe PHPmailer.

À duas formas de envio de e-mail nesse módulo, uma sem o uso de autenticação e outra com autenticação SMTP, requerido em alguns servidores de hospedagem

Abaixo um breve resumo de como utilizar esse modulo.

## Uso
Para instanciar essa função utilize dentro de sua aplicação o código abaixo.
~~~~
Codeinternut::sendmail($from, $fromname, $to, $subject, $body);
Codeinternut::sendmail_certified($from, $fromname, $to, $subject, $body)
~~~~

### sendmail

#### $from
$from é string sua definição é obrigatório pois ela será a informação que o usuário que receber o e-mail terá sobre qual e-mail lhe enviou tal informação.
`Ex: $from = teste@rolemak.com.br`	

#### $fromname
$fromname é string sua definição é obrigatório pois assim como `$from` ela será a informação que o usuário que receber o e-mail terá sobre qual nome do pessoa que lhe enviou tal informação.
`Ex: $fromname = WebTeam`

#### $to
$to é string sua definição é obrigatório esse será o destino do e-mail enviado que irá receber a mensagem `Ex: contato@rolemak.com.br`.

#### $subject
$subject é string sua definição é obrigatório esse será o assunto impresso na mensagem `Ex: Formulário de Contato` 

#### $body
$body é um texto sua definição é obrigatório nele será definido o conteúdo da mensagem, pode conter HTML `Ex: <p>Esse é um e-mail de confirmação de pedido.</p>`

OBS: Quanto utlizar a classe de envio autenticado, o e-mail e a senha de autenticação podem ser alterados direto no Método do modulo através das váriaveis 
Caminho: `MODPATH\codeinternut\classes\kohana\codeinternut.php` Função `sendmail_certified`
~~~~
	  $mail->Username   = "rolemakcomercial@gmail.com";
	  $mail->Password   = "********";
~~~~



