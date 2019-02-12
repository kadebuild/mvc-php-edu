<?php
	if (!isset($_GET['cat'])) 
	{
		echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <span class="current">Каталог</span></div>';
		echo '<div class="center_content_full">';
		echo '<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">';
		echo '<div class="product_title"><a href="?cat=0">Собранные компьютеры</a></div>';
		echo '<div class="product_img"><a href="?cat=0"><img src="images/category/0.jpg" alt="" border="0" style="height:100px; max-width:100px"/></a></div>';
		echo '<div class="prod_price"><span class="price"></span></div></div>';
		echo '<div class="bottom_prod_box"></div>';
		echo '<div class="prod_details_tab"> <a href="?cat=0" class="prod_details">Подробнее</a></div></div>';
		foreach ($data as $value) {
			echo '<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">';
			echo '<div class="product_title"><a href="?cat='.$value['id_item_category'].'">'.$value['category_name'].'</a></div>';
			echo '<div class="product_img"><a href="?cat='.$value['id_item_category'].'"><img src="images/category/'.$value['id_item_category'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/></a></div>';
			echo '<div class="prod_price"><span class="price"></span></div></div>';
			echo '<div class="bottom_prod_box"></div>';
			echo '<div class="prod_details_tab"> <a href="?cat='.$value['id_item_category'].'" class="prod_details">Подробнее</a></div></div>';
		}
		echo '</div>';
	}
	else
	{
		if (isset($_GET['id'])) {
			if (isset($data)) 
			{
				echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <a href="shop">Каталог</a> > <a href="shop?cat='.$_GET['cat'].'">'.$data['cat'].'</a> > <span class="current">'.$data['name'].'</span></div>';
				echo '<div class="prod_box_big"><div class="top_prod_box_big"></div><div class="center_prod_box_big">';
				echo '<div class="product_img_big"><img src="images/item/'.$_GET['id'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/></div><div class="details_big_box"><div class="product_title_big">'.$data['name'].'</div><hr><div class="specifications">';
				if ($_GET['cat'] > 0)
				{
					for ($i = 0, $n = count($data['char']); $i < $n; $i++)
					{
						echo $data['char'][$i]['char_name'].': <span class="blue">'.$data['char'][$i]['value'].'</span><br/>';
					}
				}
				else
				{
					for ($i = 0, $n = count($data['item']); $i < $n; $i++) 
					{
						echo '<a href="shop?cat='.$data['item'][$i]['id_item_category'].'&id='.$data['item'][$i]['id_item'].'">'.$data['item'][$i]['category_name'].' '.$data['item'][$i]['name'].' - '.$data['item'][$i]['qty'].'шт<br></a>';
						for ($j = 0, $m = count($data['item'][$i]['char']); $j < $m; $j++)
						{
							echo $data['item'][$i]['char'][$j]['char_name'].': '.$data['item'][$i]['char'][$j]['value'].'<br>';
						}
					}
				}
				echo '</div><div class="prod_price_big"><span class="price">'.$data['price'].'р</span><br>';
				if (isset($data['price_assembly'])) { echo '<span class="price">'.$data['price_assembly'].'р в сборке</span>'; }
				echo '</div>';
				if ($_SESSION['rank'] == 1) { echo '<a href="shop/buy?cat='.$_GET['cat'].'&id='.$_GET['id'].'" class="addtocart">Купить</a>'; }
				echo '</div></div><div class="bottom_prod_box_big"></div></div>';
			}
			else
			{
				echo 'Товар отсутствует';
			}
		}
		else {
			echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <a href="shop">Каталог</a> > <span class="current">'.$data['cat'].'</span></div>';
			if ($data['count'] > 0) 
			{
				echo '<div class="center_content_full">';
				for ($i = 0, $n = count($data['item']); $i < $n; $i++) 
				{
					echo '<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">';
					echo '<div class="product_title"><a href="?cat='.$_GET['cat'].'&id='.$data['item'][$i]['id'].'">'.$data['item'][$i]['name'].'</a></div>';
					echo '<div class="product_img"><a href="?cat='.$_GET['cat'].'&id='.$data['item'][$i]['id'].'">';
					if ($_GET['cat'] == 0) 
					{
						if (file_exists('images/item/assembly_'.$data['item'][$i]['id'].'.jpg'))
							echo '<img src="images/item/assembly_'.$data['item'][$i]['id'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/>';
						else
							echo '<img src="images/category/'.$_GET['cat'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/>';
					}
					else 
					{
						if (file_exists('images/item/'.$data['item'][$i]['id'].'.jpg'))
							echo '<img src="images/item/'.$data['item'][$i]['id'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/>';
						else
							echo '<img src="images/category/'.$_GET['cat'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/>';
					}
					echo '</a></div><div class="prod_price"><span class="price">'.$data['item'][$i]['price'].'р</span></div></div>';
					echo '<div class="bottom_prod_box"></div>';
					echo '<div class="prod_details_tab"> <a href="?cat='.$_GET['cat'].'&id='.$data['item'][$i]['id'].'" class="prod_details">Подробнее</a></div></div>';
				}
				echo '</div><br><hr><p align="center">';
				$prev_page_button = '';
				$next_page_button = '';
				if ($data['page'] > 1) {
					$prev_page_button = '<a href="?cat='.$_GET['cat'].'&p='.($data['page']-1).'">Назад</a>';
				}
				if ($data['page'] < $data['total'])
				{
					$next_page_button = '<a href="?cat='.$_GET['cat'].'&p='.($data['page']+1).'">Вперед</a>';
				}
				echo $prev_page_button.' | '.$data['page'].' из '.$data['total'].' | '.$next_page_button;
				echo '</p>';
				if ($_GET['cat'] > 0)
				{
					echo '<hr><div class="center_content_full" align="center"><h1>TOP '.count($data['top']).'</h1>';
				for ($i = 0, $n = count($data['top']); $i < $n; $i++) 
				{
					echo '<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">';
					echo '<div class="product_title"><a href="?cat='.$_GET['cat'].'&id='.$data['top'][$i]['id'].'">'.$data['top'][$i]['name'].'</a></div>';
					echo '<div class="product_img"><a href="?cat='.$_GET['cat'].'&id='.$data['top'][$i]['id'].'">';
					if (file_exists('images/item/'.$data['item'][$i]['id'].'.jpg'))
						echo '<img src="images/item/'.$data['top'][$i]['id'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/>';
					else
						echo '<img src="images/category/'.$_GET['cat'].'.jpg" alt="" border="0" style="height:100px; max-width:100px"/>';
					echo '</a></div><div class="prod_price"><span class="price">'.$data['top'][$i]['price'].'р</span></div></div>';
					echo '<div class="bottom_prod_box"></div>';
					echo '<div class="prod_details_tab"> <a href="?cat='.$_GET['cat'].'&id='.$data['top'][$i]['id'].'" class="prod_details">Подробнее</a></div></div>';
				}
					echo '</div>';
				}
			}
			else
			{
				echo '<br>В данной категории нет товаров';
			}
		}
	}
?>