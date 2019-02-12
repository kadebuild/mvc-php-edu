<?php

class Controller_Shop extends Controller
{

	function __construct()
	{
		$this->model = new Model_Shop();
		$this->view = new View();
	}
	
	function index()
	{
		$data = $this->model->action();		
		$this->view->generate('view_shop.php', 'template_view.php', $data);
	}
	
	function buy()
	{
		$data = $this->model->buy();
		$this->view->generate('view_shop_buy.php', 'template_view.php', $data);
	}
}
?>