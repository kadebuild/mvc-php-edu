<?php
	if (isset($_GET['cat'])) 
	{
		if (isset($_GET['id'])) {
			if (isset($data)) 
			{
				echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <a href="/shop">Каталог</a> > <a href="/shop?cat='.$_GET['cat'].'">'.$data['cat'].'</a> > <span class="current">'.$data['name'].'</span></div>';
				echo '<div class="prod_box_big"><div class="top_prod_box_big"></div><div class="center_prod_box_big">';
				echo '<div class="product_img_big"><img src="/images/laptop.gif" alt="" border="0"/></div><div class="details_big_box"><div class="product_title_big">'.$data['name'].'</div><hr><div class="specifications">';
				if ($_GET['cat'] > 0)
				{
					for ($i = 0, $n = count($data['char']); $i < $n; $i++)
					{
						echo $data['char'][$i]['char_name'].': <span class="blue">'.$data['char'][$i]['value'].'</span><br/>';
					}
				}
				else
				{
					for ($i = 0, $n = count($data['item']); $i < $n-1; $i++) 
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
				if ($_SESSION['rank'] == 1) { echo '<a href="/shop"><h2>'.$data['status'].'<br>Назад в каталог</h></a>'; }
				echo '</div></div><div class="bottom_prod_box_big"></div></div>';
			}
			else
			{
				echo 'Товар отсутствует';
			}
		}
	}
?>