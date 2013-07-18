# Impressão de Dados

Esses métodos consistem em imprimir um array ou váriavel comum para verificação dos dados.
Abaixo um breve resumo de como utilizar essas funções e suas diferenças


### printr
Essa função faz com que um array passado como parametro $array, seja impresso na tela sem parar a execução do resto da aplicação.

#### Uso
~~~~
Codeinternut::printr($array);
~~~~


### printrd
Essa função faz com que um array passado como parametro $array, seja impresso na tela, nesse caso nada será executado após a impressão do array, parando a execução do resto da aplicação.

#### Uso
~~~~
Codeinternut::printrd($array);
~~~~

### printrtofile
Com essa função é possível imprimir um array ou qualquer váriavel direto para um arquivo txt, html, md, etc, possiblitando também o envio desse arquivo para um e-mail, sua utilização é útil para não prejudicar ou expor usuários e equipes de desenvolvimento a erros/mensagens na tela de produção.

#### Uso
~~~~
codeinternut::printrtofile(
					  array(
					  	'content'        => 'variable_for_print',
						'file_name'      => 'myfile.txt',
						'send_email'     => 'email@dominio.com',
					  ));	
~~~~

