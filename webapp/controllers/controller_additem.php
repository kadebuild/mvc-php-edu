<?php

class Controller_Additem extends Controller
{
	function __construct()
	{
		$this->model = new Model_Additem();
		$this->view = new View();
	}
	
	function index() 
	{
		if ($_SESSION['rank'] == 2) 
		{
			$data = $this->model->action();
			$data[0]['status'] = "getitem";
			$this->view->generate('view_additem.php', 'template_view.php', $data);
		} 
		else 
		{
			$this->error_redirect();
		}
	}
	
	function add()
	{
		if ($_SESSION['rank'] == 2) 
		{
			if(isset($_POST['name']) && isset($_POST['qty']) && isset($_POST['price']))
			{
				$data['status'] = $this->model->add();
				$this->view->generate('view_additem.php', 'template_view.php', $data);
			}
			else
			{
				$data['status'] = "Не задано одно из важных полей";
				$this->view->generate('view_additem.php', 'template_view.php', $data);
			}
		}
		else 
		{
			$this->error_redirect();
		}
	}
	
	function error_redirect() {
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
	}
}
