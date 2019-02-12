<?php
class Model_Assembly extends Model
{
	public function action()
	{
		$this->db_connect();
		$stmt = $this->pdo->query('SELECT id_item, id_item_category, name, price_assembly as price FROM '.$this->table['item'].' WHERE qty > 0 AND id_item_category in (1,2,3,4,5,6,7,8) ORDER BY id_item_category');
		$i = 0;
		$cat = -1;
		foreach ($stmt as $buf)
		{
			if ($cat != ($buf['id_item_category'] - 1))
			{
				$cat = $buf['id_item_category'] - 1;
				$i = 0;
			}
			$data[$cat]['item'][$i] = array("id_item"=>$buf['id_item'], "name"=>$buf['name'], "price"=>$buf['price'], "chars"=>"");  
			$stmt2 = $this->pdo->query('SELECT t2.char_name, t1.value FROM '.$this->table['item_char'].' as t1 INNER JOIN '.$this->table['item_char_name'].' as t2 ON t1.id_char = t2.id_char WHERE t1.id_item = '.$buf['id_item']);
			$chars_string = '';
			foreach ($stmt2 as $buf2)
			{
				$chars_string .= "".$buf2['char_name'].": ".$buf2['value']."<br>";
			}
			$data[$cat]['item'][$i]['chars'] = $chars_string;
			$i++;
		}
		return json_encode($data);
	}
	
	public function buy($assembly_items, $assembly_string, $data)
	{
		$this->db_connect();
		$stmt = $this->pdo->query('SELECT id_item_category FROM '.$this->table['item'].' WHERE id_item in ('.$assembly_string.') ORDER BY id_item_category');
		$i = 1;
		$correct_assembly = true;
		foreach ($stmt as $buf)
		{
			if ($buf['id_item_category'] != $i && $i <= $assembly_items)
				$correct_assembly = false;
			$i++;
		}
		if ($correct_assembly) 
		{
			$stmt = $this->pdo->query('SELECT SUM(price_assembly) as sum FROM '.$this->table['item'].' WHERE id_item in ('.$assembly_string.')');
			$assembly_price = $stmt->fetch();
			if ($_SESSION['rank'] == 1)
			{
				$assembly_name = 'Пользовательская сборка';
				$assembly_amount = 0;
			}
			else if ($_SESSION['rank'] == 2)
			{
				$assembly_name = 'Собранный компьютер';
				$assembly_amount = 1;
			}
			$stmt = $this->pdo->prepare('INSERT INTO '.$this->table['assembly'].' (assembly_name, date, qty, price) VALUES (?,NOW(),?,?)');
			$stmt->execute(array($assembly_name, $assembly_amount, $assembly_price['sum']));
			if ($stmt)
			{
				$stmt = $this->pdo->query('SELECT last_insert_id() as id');
				$id_assembly = $stmt->fetch();
				foreach ($data as $buf)
				{
					if ($buf != 0)
					{
						$stmt = $this->pdo->prepare('INSERT INTO '.$this->table['assembly_item'].' (id_assembly, id_item, qty) VALUES (?,?,?)');
						$stmt->execute(array($id_assembly['id'], $buf, 1));
						if (!$stmt)
						{
							$correct_assembly = false;
							break;
						}
					}
				}
			}
			else
				return 'Ошибка при добавлении новой сборки';
			if (!$correct_assembly)
				return 'Ошибка при добавлении комплектующих в сборку';
			else
			{
				$stmt = $this->pdo->query('UPDATE '.$this->table['item'].' SET qty=qty-1, sold=sold+1 WHERE id_item in ('.$assembly_string.')');
				if ($stmt) {
					if ($_SESSION['rank'] == 1)
						return 'Благодарим за покупку!';
					else if ($_SESSION['rank'] == 2)
						return 'Сборка добавлена в каталог товаров';
				}
				else
					return 'Непредвиденная ошибка при работе с базой';
			}
		}
		else
			return 'Ошибка некорректная сборка';
	}
}
?>