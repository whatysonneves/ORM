# ORM
Abstrair consultas com o banco de dados, usando a orientação a objetos.

### Exemplo simples
	require_once "ORM.php";

	$conn = ORM::run();
	$pessoa = array(
		"nome" => "Whatyson",
		"sobrenome" => "Neves"
	);

	echo $conn->setTable("users")->create($pessoa, true); // ($pessoa) para executar
	// INSERT INTO users (nome, sobrenome) VALUES ("Whatyson", "Neves")

Código de exemplo de um Create.
