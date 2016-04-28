<?php

class DB
{

	public $DB;

	public function __construct() {
	
		$this->DB = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		
		if (!$this->DB) {
			die("Não foi possivel conectar na base de dados!".PHP_EOL);
		}

	}
	
	
	public function _query($sql) {
	
		if (!$result = $this->DB->query($sql)) {
			die("Não foi possível executar a consuta: ".$sql.PHP_EOL);
		}
		
		return $result;

	}


	public function _getRow($sql) {

		if (!$result = $this->DB->query($sql)) {
			die("Não foi possível executar a consuta: ".$sql.PHP_EOL);
		}
		
		return $result->fetch_assoc();

	}


	public function _getAll($sql) {
	
		if (!$result = $this->DB->query($sql)) {
			die("Não foi possível executar a consuta: ".$sql.PHP_EOL);
		}
		
		$results = array();
		
		while ($row = $result->fetch_assoc()) {
			$results[] = $row;
		}
		
		return $results;

	}

}

?>
