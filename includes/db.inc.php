<?php

class DB{
	private mysqli $conn_intern;
	private string $host = DB["host"];
	private string $user = DB["user"];
	private string $pwd = DB["pwd"];
	private string $name = DB["name"];

	function __construct()
	{
		try {
			$this->conn_intern = new MySQLi($this->host,$this->user,$this->pwd,$this->name);
			if($this->conn_intern->connect_errno>0) {
				if(TESTMODUS) {
					die("Fehler im Verbindungsaufbau. Abbruch");
				}
				else {
					header("Location: errors/db_connect.html");
				}
			}
			$this->conn_intern->set_charset("utf8mb4");
		}
		catch(Exception $e) {
			ta("Fehler im Verbindungsaufbau: ".$this->conn_intern->connect_error);
			if(TESTMODUS) {
				die("Fehler im Verbindungsaufbau. Abbruch");
			}
			else {
				header("Location: errors/db_connect.html"); //beispielhaft: eine Fehlerseite, die dem User erklärt, was denn geschehen ist UND wie er aus dieser verzwickten Situation wieder herauskommt
			}
		}
	}

	function ext_query(string $sql):mysqli_result|bool {
		try {
			$daten = $this->conn_intern->query($sql);
			if($daten===false) {
				if(TESTMODUS) {
					ta($sql);
					die("Fehler im SQL-Statement. Abbruch: " . $this->conn_intern->error);
				}
				else {
					header("Location: errors/db_query.html");
				}
			}
		}
		catch(Exception $e) {
			if(TESTMODUS) {
				die("Fehler im SQL-Statement. Abbruch: " . $this->conn_intern->error);
			}
			else {
				header("Location: errors/db_query.html");
			}
		}
		
		return $daten;
	}	
}




?>