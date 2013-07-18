# testandooooooooooooo
## testandooooooooooooo

Através desse metódo é possível exluir, inserir e atualizar dados em uma tabela no banco de dados instanciado em sua aplicação.

## Uso

Para instanciar essa função é necessário identicar qual ação executar, se a ação for atualizar ou inserir dados em uma tabela use dbsave se for excluir use dbdelete
~~~
Codeinternut::dbsave($table,$data);

Codeinternut::dbdelete($id,$table,$field);

Codeinternut::dbselect($sql, $db=NULL, $soa_url=NULL);
~~~

###dbsave

#### $table
$table é string informar nesse parametro o nome da tabela que sobre a alteração `Ex: 'products'`;

#### $data
$data é um array seu valor deve ser um array de chaves e valores, chave deve ter o mesmo nome do campo da tabela que sofrerá a alteração e o valor o dado a ser alterado
se entre o array de dados for informado o campo de chave primeira `id` e seu valor contido na tabela os dados relacionados a esse id serão então atualizados e não inseridos em um novo registro.

~~~
$data = array(
	'id'=> 1,
	'product_name' => 'Nome do Produto',
	'preco' => '11111.5565',
);
~~~

###dbdelete

#### $id
$id é o campo chave da tabela o campo de comparação para o funcionamento de método é necessário que ele seja definido `EX: 1`

#### $table
$table é o nome da tabela aque sofrerá alteração `EX: 'products'`.

#### $field
$field é o de comparação do $id, `Ex: field = id`

No final a sintaxe ficaria assim. `DELETE FROM $table WHERE $field = $id`;


###dbselect

####$sql

$sql é o seu código mysql, `Ex: "SELECT * FROM users"`

####$db

$db será usado somente se você precisar fazer uma busca em outro banco de dados, `Ex: "Zoje"`

####$soa_url

$soa_url será usado apenas se for usado um serviço SOA.
Neste parâmetro é necessário colocar o link completo do SOA, `Ex: "http://www.zoje.com.br/soa/"`

~~~
$response = Codeinternut::dbselect("SELECT * FROM roles");
~~~