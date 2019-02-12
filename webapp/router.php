<?php
class Router
{
	static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'main';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// получаем имя контроллера
		if ( !empty($routes[1]) )
		{
			if (strpos($routes[1], '?') != false) {
				$buf = explode('?', $routes[1]);
				$routes[1] = $buf[0];
			}
			$controller_name = $routes[1];
		}
		
		// получаем имя экшена
		if ( !empty($routes[2]) )
		{
			if (strpos($routes[2], '?') != false) {
				$buf = explode('?', $routes[2]);
				$routes[2] = $buf[0];
			}
			$action_name = $routes[2];
		}

		// добавляем префиксы
		$model_name = 'model_'.$controller_name;
		$controller_name = 'controller_'.$controller_name;

		/*
		echo "Model: $model_name <br>";
		echo "Controller: $controller_name <br>";
		echo "Action: $action_name <br>";
		*/

		// подцепляем файл с классом модели (файла модели может и не быть)

		$model_file = strtolower($model_name).'.php';
		$model_path = "webapp/models/".$model_file;
		if(file_exists($model_path))
		{
			include "webapp/models/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "webapp/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "webapp/controllers/".$controller_file;
		}
		else
		{
			Router::ErrorPage404();
		}
		
		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			// вызываем действие контроллера
			$controller->$action();
		}
		else
		{
			Router::ErrorPage404();
		}
	
	}

	function ErrorPage404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }
    
}
