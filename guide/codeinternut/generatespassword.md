# Gerador de Senhas

Esse método consiste em criar senhas aleatórias, dentro de sua funcionalidade está quantidade de caracteres a inclusão ou não de letras números e caracteres especiais.

Abaixo um breve resumo de como utilizar esse modulo.

## Uso
Para instanciar essa função utilize dentro de sua aplicação o código abaixo.
~~~~
Codeinternut::generatespassword(
	$size = 8, 
	$uppercase = true, 
	$numbers = true, 
	$symbols = true
	);
~~~~

### $size
Size é number se definida irá gerar quantidade de caracteres fornecedida nessa váriavel. Se nada dor definido seu padrão é 8
`Ex: $size = 12`	

### $uppercase
uppercase é boolean se definido como false não irá retornar letras mínusculas na senha gerada. Se nada dor definido seu padrão é TRUE
`Ex: $size = false`	

### $numbers
numbers é boolean se definido como false não irá retornar números na senha gerada. Se nada dor definido seu padrão é TRUE
`Ex: $numbers = false`	

### $symbols
symbols é boolean se definido como false não irá retornar caracteres speciais na senha gerada. Se nada dor definido seu padrão é TRUE
`Ex: $symbols = false`	

