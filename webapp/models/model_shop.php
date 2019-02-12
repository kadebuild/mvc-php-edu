<?php

class Model_Shop extends Model
{
	private $itemPerPage = 10;
	private $topItem = 5;
	
	public function action()
	{	
		if (!isset($_GET['cat'])) {
			return $this->get_category_list();
		}
		else
		{
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				if ($_GET['cat'] > 0) {
					return $this->get_item();
				}
				else 
				{
					return $this->get_assembly();
				}
			}
			else {
				if ($_GET['cat'] == 0)
				{
					return $this->get_all_assembly();
				}
				else if ($_GET['cat'] > 0)
				{
					$data = $this->get_all_item();
					$data['top'] = $this->get_top_item();
					return $data;
				}
			}
		}
	}

	public function buy()
	{
		if (isset($_GET['id']) && isset($_GET['cat']) && ($_SESSION['rank'] == 1))
		{
			$data['status'] = "Ошибка при обработке заказа. Попробуйте совершить покупку чуть позже.";
			if ($_GET['cat'] > 0) 
			{
				$data = $this->get_item();
				$stmt = $this->pdo->prepare('UPDATE item SET qty=qty-1, sold=sold+1 WHERE id_item = ?');
				$stmt->execute(array($_GET['id']));
				if ($stmt) 
				{
					$data['status'] = "Благодарим за покупку";
				}
				else
				{
					$data['status'] = "К сожалению товар отсутствует на складе";
				}
			}
			else if ($_GET['cat'] == 0)
			{
				$this->db_connect();
				$stmt = $this->pdo->prepare('UPDATE assembly SET qty = 0 WHERE id_assembly = ? AND qty > 0');
				$stmt->execute(array($_GET['id']));
				if ($stmt) 
				{
					$data['status'] = "Благодарим за покупку";
				}
				else
				{
					$data['status'] = "К сожалению товар отсутствует на складе";
				}
			}
			return $data;
		}
	}
	
	private function get_category_list()
	{
		$this->db_connect();
		$stmt = $this->pdo->prepare('SELECT id_item_category, category_name FROM '.$this->table['item_category']);
		$stmt->execute();
		$data = [];
		foreach ($stmt as $buf)
			array_push($data,$buf);
		return $data;
	}
	
	private function get_item()
	{
		$this->db_connect();
		$stmt = $this->pdo->prepare('SELECT t1.name, t1.price, t1.price_assembly, t2.category_name as cat FROM '.$this->table['item'].' as t1 INNER JOIN '.$this->table['item_category'].' as t2 ON t1.id_item_category = t2.id_item_category WHERE t1.id_item = ?');
		$stmt->execute(array($_GET['id']));
		$data = $stmt->fetch();
		$stmt = $this->pdo->prepare('SELECT t1.value, t2.char_name FROM '.$this->table['item_char'].' as t1 INNER JOIN '.$this->table['item_char_name'].' as t2 ON t1.id_char = t2.id_char WHERE t1.id_item = ?');
		$stmt->execute(array($_GET['id']));
		$i = 0;
		foreach ($stmt as $buf)
		{
			$data['char'][$i] = $buf;
			$i++;
		}
		return $data;
	}
	
	private function get_assembly()
	{
		$this->db_connect();
		$stmt = $this->pdo->prepare('SELECT assembly_name as name, price FROM '.$this->table['assembly'].' WHERE id_assembly = ?');
		$stmt->execute(array($_GET['id']));
		$data = $stmt->fetch();
		$data['cat'] = "Собранные компьютеры";
		$stmt = $this->pdo->prepare('SELECT t1.id_item, t1.qty, t2.name, t3.category_name, t3.id_item_category FROM '.$this->table['assembly_item'].' as t1 INNER JOIN '.$this->table['item'].' as t2 ON t1.id_item = t2.id_item INNER JOIN '.$this->table['item_category'].' as t3 ON t2.id_item_category = t3.id_item_category WHERE t1.id_assembly = ?');
		$stmt->execute(array($_GET['id']));
		$i = 0;
		foreach ($stmt as $buf)
		{
			$data['item'][$i] = $buf;
			$i++;
		}
		return $data;
	}
	
	private function get_all_assembly()
	{
		$this->db_connect();
		$stmt = $this->pdo->query('SELECT COUNT(id_assembly) as count FROM '.$this->table['assembly'].' WHERE qty > 0');
		$data = $stmt->fetch();
		$data['cat'] = "Собранные компьютеры";
		$data['total'] = ceil($data['count'] / $this->itemPerPage);
		$data['page'] = (isset($_GET['p']) && ($_GET['p'] > 1 && $_GET['p'] <= $data['total'])) ? $_GET['p'] : 1;
		$firstItemIndex = $data['page'] * $this->itemPerPage - $this->itemPerPage;
		$stmt = $this->pdo->query('SELECT id_assembly as id, assembly_name as name, price FROM '.$this->table['assembly'].' WHERE qty > 0 LIMIT '.$firstItemIndex.', '.$this->itemPerPage);
		$i = 0;
		foreach ($stmt as $buf) 
		{
			$data['item'][$i] = $buf;
			$i++;
		}
		return $data;
	}
	
	private function get_all_item()
	{
		$this->db_connect();
		$stmt = $this->pdo->prepare('SELECT COUNT(id_item) as count, category_name as cat FROM '.$this->table['item'].' as t1, '.$this->table['item_category'].' as t2 WHERE t1.qty > 0 AND t1.id_item_category = t2.id_item_category AND t1.id_item_category = ?');
		$stmt->execute(array($_GET['cat']));
		$data = $stmt->fetch();
		$data['total'] = ceil($data['count'] / $this->itemPerPage);
		$data['page'] = (isset($_GET['p']) && ($_GET['p'] > 0 && $_GET['p'] <= $data['total'])) ? $_GET['p'] : 1;
		$firstItemIndex = $data['page'] * $this->itemPerPage - $this->itemPerPage;
		$stmt = $this->pdo->prepare('SELECT id_item as id, name, price FROM '.$this->table['item'].' WHERE qty > 0 AND id_item_category = ? LIMIT '.$firstItemIndex.', '.$this->itemPerPage);
		$stmt->execute(array($_GET['cat']));
		$i = 0;
		foreach ($stmt as $buf) {
			$data['item'][$i] = $buf;
			$i++;
		}
		return $data;
	}
	
	private function get_top_item()
	{
		$stmt = $this->pdo->prepare('SELECT id_item as id, name, price FROM '.$this->table['item'].' WHERE qty > 0 AND id_item_category = ? ORDER BY sold DESC LIMIT '.$this->topItem);
		$stmt->execute(array($_GET['cat']));
		$i = 0;
		foreach ($stmt as $buf)
		{
			$data[$i] = $buf;
			$i++;
		}
		return $data;
	}
}
?>