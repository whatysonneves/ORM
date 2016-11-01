<?php

require_once "./CRUD.php";

class ORM extends CRUD {

	public static function run() {

		$conn = new parent("localhost", "root", "", "locacar");
		return $conn;

	}

}

$conn = ORM::run();

var_dump($conn->setTable("teste")->create(array("nome" => "Whatyson Neves"), true));
var_dump($conn->update(array("nome" => "Whatyson Neves"), "", true));

?>