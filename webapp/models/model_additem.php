<?php
class Model_Additem extends Model
{

	public function action()
	{
		if (!isset($_GET['cat'])) {
			$this->db_connect();
			$stmt = $this->pdo->prepare('SELECT category_name FROM '.$this->table['item_category']);
			$stmt->execute();
			$data = [];
			foreach ($stmt as $buf)
				array_push($data,$buf);
			return $data;
		}
		else {
			$this->db_connect();
			$stmt = $this->pdo->prepare('SELECT id_char, char_name FROM '.$this->table['item_char_name'].' WHERE id_item_category = (SELECT id_item_category FROM '.$this->table['item_category'].' WHERE category_name = ?)');
			$stmt->execute(array($_GET['cat']));
			$data = [];
			foreach ($stmt as $buf)
				array_push($data,$buf);
			return $data;
		}
	}

	public function add()
	{
		$this->db_connect();
		if (isset($_POST['cat']) && isset($_POST['price_assembly'])) 
		{
			$stmt = $this->pdo->prepare('SELECT id_item_category FROM '.$this->table['item_category'].' WHERE category_name = ?');
			$stmt->execute(array($_POST['cat']));
			$id_cat = $stmt->fetch();
			if (isset($id_cat)) {
				$stmt = $this->pdo->prepare('INSERT INTO '.$this->table['item'].' (name, id_item_category, price, price_assembly, qty) VALUES (?, ?, ?, ?, ?)');
				$status = $stmt->execute(array($_POST['name'],$id_cat['id_item_category'],$_POST['price'],$_POST['price_assembly'],$_POST['qty']));
				if ($status) {
					$stmt = $this->pdo->query('SELECT last_insert_id() as id');
					$id_item = $stmt->fetch();
					$stmt = $this->pdo->query('SELECT id_char FROM '.$this->table['item_char_name'].' WHERE id_item_category = '.$id_cat['id_item_category']);
					foreach ($stmt as $buf)
					{
						$stmt2 = $this->pdo->prepare('INSERT INTO '.$this->table['item_char'].' (id_item, id_char, value) VALUES (?,?,?)');
						$status = $stmt2->execute(array($id_item['id'],$buf['id_char'],$_POST[''.$buf['id_char'].'']));
						if (!$status)
						{
							return "Ошибка при добавлении товара: не удалось добавить характеристики товара";
						}
					}
					return "Товар добавлен успешно";
				}
				else
				{
					return "Ошибка при добавлении товара: не удалось добавить товар";
				}
			}
			else
			{
				return "Ошибка при добавлении товара: не найдена категория товара";
			}
		}
	}
	
}
?>