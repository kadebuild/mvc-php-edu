<?php
class Controller_Main extends Controller
{
	function index()
	{
		$this->view->generate('view_main.php', 'template_view.php');
	}
}
?>