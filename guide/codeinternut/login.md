# Login

Este método consiste toda ação de login.

## Uso

Para instanciar essa função utilize dentro de sua aplicação o código abaixo.

Obs: Obrigatóriamente o $_POST deve ter email e password.

~~~~
$response = Codeinternut::login($_POST, $referrer);

// $_POST['email'] && $_POST['password']
~~~~

## String

O primeiro parâmetro se refere ao $_POST.

O segundo parâmetro se refere ao URL que será redirecionado após o login.