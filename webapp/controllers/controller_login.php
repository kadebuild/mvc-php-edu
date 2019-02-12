<?php

class Controller_Login extends Controller
{
	function __construct()
	{
		$this->model = new Model_Login();
		$this->view = new View();
	}
	
	function index()
	{
		if(isset($_POST['login']) && isset($_POST['password']))
		{
			$data = $this->model->action();
			if(isset($data) && $data['login'] == $_POST['login'])
			{
				if ($data['pass'] == md5($_POST['password']))
				{
					$_SESSION['login'] = $data['login'];
					if ($data['rank'] == 'Администратор')
						$_SESSION['rank'] = 2;
					else
						$_SESSION['rank'] = 1;
				}
			}
			else
			{
				$data["login_status"] = "access_denied";
			}
		}
		else
		{
			$data["login_status"] = "";
		}
		header('Location:/');
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
	
}
