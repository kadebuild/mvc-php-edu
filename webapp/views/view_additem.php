<?php
	if (!isset($_GET['cat'])) 
	{
		echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <span class="current">Добавить товар</span></div><div class="center_content_full">';
		echo '<form action="additem?cat" method="GET">';
		if (!isset($data['status']))
		{
			foreach ($data as $value) {
				echo '<input type="submit" name="cat" value="'.$value['category_name'].'">';
			}
		}
		else 
		{
			echo $data['status'];
		}
		echo '</form>';
	}
	else 
	{
		echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <a href="additem">Добавить товар</a> > <span class="current">'.$_GET['cat'].'</span></div><div class="center_content_full">';
		echo '<form action="additem/add" method="POST">';
		echo 'Категория товара: <input type="text" name="cat" value="'.$_GET['cat'].'" readonly="" />';
		echo '<br>Название товара: <input type="text" name="name">';
		echo '<br>Цена товара за единицу: <input type="text" name="price">';
		echo '<br>Цена товара в сборке: <input type="text" name="price_assembly">';
		echo '<br>Количество товара: <input type="text" name="qty">';
		echo '<br>Характеристики<hr>';
		foreach ($data as $value) {
			echo $value['char_name'].': <input type="text" name="'.$value['id_char'].'">';
			echo '<br>';
		}
		echo '<br>';
		echo '<input type="submit" name="item" value="Добавить">';
		echo '<input type="reset" name="reset" value="Очистить">';
		echo '<a href="/additem">Назад</a>';
		echo '</form>';
	}
?>
</div>