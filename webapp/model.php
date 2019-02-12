<?php

class Model
{
	public $pdo;
	public $table;
	
	public function db_connect() {
		require_once 'dbdata.php';
		$dsn = "mysql:host=$host;dbname=$dbase;charset=utf8";
		$opt = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
		$this->pdo = new PDO($dsn, $user, $pass, $opt);
		$this->table = $table;
	}
}