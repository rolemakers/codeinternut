# Codeinternut WebTeam Rolemak

Esse módulo foi criado pela WebTeam da Rolemak, com o intuito de organizar funções, que poderam ser usadas em diversos projetos. Provendo de um desenvolvimento ágil e interativo entre a equipe.

## Instalação

Obs: Esse módulo é para utilização com framework kohana( testado na versão 3.2 ).

1 - Faça o download do módulo [Download Codeinternut](https://github.com/rolemakers/codeinternut.git).

2 - Para primeira instalação extraia do conteúdo zip o arquivo install/install_codeinternut.php e faça o upload desse arquivo na raiz de seu framework kohana.

3 - Execute a url de seu projeto ex: [www.seuprojeto.com.br/install_codeinternut.php](#).

4 - Será exibido algumas mensagens na tela sobre a instalação, feito isso delete o arquivo install da raiz de seu projeto.

5 - Em seguida ative seu novo modulo no arquivo bootstrap de seu Kohana application/bootstrap.php, incluindo a linha abaixo em seu Kohana::modules()
~~~
'codeinternut'     => MODPATH.'codeinternut'
~~~

Feito isso seu módulo já deve estar funcionando normalmente, para consultar mais sobre as funções existentes acesse [www.seuprojeto.com.br/guide](#), será listado uma documentação de todas as
funções e como utilizar.