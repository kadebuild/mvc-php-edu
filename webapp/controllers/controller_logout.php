<?php

class Controller_Logout extends Controller
{
	function index()
	{
		if(isset($_SESSION['login']) && isset($_SESSION['rank']))
		{
			session_unset();
			session_destroy();
			setcookie(session_name(), '', time() - 60*60*24*32, '/');
			header('Location:/');
		}		
		$this->view->generate('main_view.php', 'template_view.php');
	}
	
}
