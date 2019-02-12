<?php
class Model_Statistic extends Model
{
	private $limitStatistic = 10;
	
	public function action()
	{
		$this->db_connect();
		$stmt = $this->pdo->query('SELECT * FROM '.$this->table['item_category']);
		$i = 0;
		foreach ($stmt as $buf)
		{
			$data['cat'][$i] = $buf;
			$i++;
		}
		if (!isset($_GET['cat']))
		{
			$stmt = $this->pdo->query('SELECT id_item, name, sold FROM '.$this->table['item'].' ORDER BY sold DESC LIMIT '.$this->limitStatistic);
			$i = 0;
			foreach ($stmt as $buf)
			{
				$data['item'][$i] = $buf;
				$i++;
			}
		}
		else if ($_GET['cat'] > 0) 
		{
			$stmt = $this->pdo->prepare('SELECT id_item, name, sold FROM '.$this->table['item'].' WHERE id_item_category = ? ORDER BY sold DESC LIMIT '.$this->limitStatistic);
			$stmt->execute(array($_GET['cat']));
			$i = 0;
			foreach ($stmt as $buf)
			{
				$data['item'][$i] = $buf;
				$i++;
			}
		}
		else if ($_GET['cat'] == 0)
		{
			$query = "";
			$array = array();
			if ($_GET['sdate'] != "") 
			{
				$query = "WHERE date >= ? ";
				$start_date = $_GET['sdate'];
				array_push($array, $start_date);
			}
			if ($_GET['edate'] != "")
			{
				$query .= ($query != "") ? "AND date <= ?" : "WHERE date <= ?";
				$end_date = $_GET['edate'];
				array_push($array, $end_date);
			}
			$end_date = "".$_GET['edate'];
			$stmt = $this->pdo->prepare('SELECT SUM(price) as sold, date as name FROM '.$this->table['assembly'].' '.$query.' GROUP BY date');
			$stmt->execute($array);
			$i = 0;
			foreach ($stmt as $buf)
			{
				$data['item'][$i] = $buf;
				$i++;
			}
		}
		return $data;
	}
}
?>