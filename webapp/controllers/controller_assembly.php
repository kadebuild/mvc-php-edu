<?php

class Controller_Assembly extends Controller
{
	function __construct()
	{
		$this->model = new Model_Assembly();
		$this->view = new View();
	}
	
	function index()
	{
		$data = $this->model->action();
		$this->view->generate('view_assembly.php', 'template_view.php', $data);
	}
	
	function buy()
	{
		$data = json_decode($_POST['assembly']);
		$correct_assembly = true;
		$assembly_items = 0;
		$assembly_string = '';
		for ($i = 0; $i < count($data); $i++)
		{
			if ($data[$i] == 0 && $i != (count($data)-1)) 
			{
				$correct_assembly = false;
				break;
			}
			$assembly_items++;
			$assembly_string .= $data[$i].',';
		}
		$assembly_string = substr($assembly_string, 0, -1);
		if ($correct_assembly && $_SESSION['rank'] >= 1)
			echo $this->model->buy($assembly_items, $assembly_string, $data);
		else
			echo 'Ошибка при обработке заказа';
	}
}
