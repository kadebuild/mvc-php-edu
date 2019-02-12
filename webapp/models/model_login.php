<?php
class Model_Login extends Model
{

	public function action()
	{
		$this->db_connect();
		$stmt = $this->pdo->prepare('SELECT * FROM '.$this->table['user'].' WHERE login = ?');
		$stmt->execute(array($_POST['login']));
		return $stmt->fetch();
	}

}
?>