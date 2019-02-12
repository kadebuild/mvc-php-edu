<?php
class Model_Registration extends Model
{

	public function action()
	{
		$this->db_connect();
		$stmt = $this->pdo->prepare('INSERT INTO '.$this->table['user'].' (login, pass, email) VALUES (?, ?, ?)');
		$stmt->execute(array($_POST['login'],md5($_POST['password']),$_POST['email']));
		if ($stmt)
			mail($_POST['email'], "Регистрация на сайте ComputerStar", "Добро пожаловать на сайт ComputerStar! Напоминаем Ваши данные:\nЛогин: ".$_POST['login']."\nПароль: ".$_POST['password']."");
		return $stmt;
	}

}
?>