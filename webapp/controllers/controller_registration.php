<?php

class Controller_Registration extends Controller
{
	function __construct()
	{
		$this->model = new Model_Registration();
		$this->view = new View();
	}
	
	function index()
	{
		$this->view->generate('view_registration.php', 'template_view.php', $data);
	}
	
	function reg()
	{
		if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email']))
		{
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				$data['status'] = $this->model->action();
				header('Location:/registration');
				$this->view->generate('view_registration.php', 'template_view.php', $data);
			}
		}
		else
		{
			$data['status'] = "false";
			$this->view->generate('view_registration.php', 'template_view.php', $data);
		}
	}
	
}
