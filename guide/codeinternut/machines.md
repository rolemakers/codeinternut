## Catalogo Maquinas

Metodo para leitura do catalogo SOA de Maquinas de Costura

## Uso

~~~
$products = codeinternut::machines(
	$variables = array (
		'options' => array (
			'brand'		  => 'zoje',
			'category' 	  => false,
			'subcategory' => false,
			'product'	  => false,
			'limit'		  => 200,
			),
		'cache' => array (
			'active' 	=> true,
			'save_path' => APPPATH.'sql_cache/',
			'life_time' => 172800, 
			)
		));
~~~
