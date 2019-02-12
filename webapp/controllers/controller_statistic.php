<?php

class Controller_Statistic extends Controller
{

	function __construct()
	{
		$this->model = new Model_Statistic();
		$this->view = new View();
	}
	
	function index()
	{
		$data = $this->model->action();		
		$this->view->generate('view_statistic.php', 'template_view.php', $data);
	}
}
?>