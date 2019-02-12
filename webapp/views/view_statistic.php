<script>
function enableDate(val)
{
	if (val == 0) {
		document.getElementById('d1').disabled = false;
		document.getElementById('d2').disabled = false;
	} else {
		document.getElementById('d1').disabled = true;
		document.getElementById('d2').disabled = true;
	}
}
</script>
<?php
echo '<div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <span class="current">Статистика</span></div>';
echo '<form action="" method="GET"><br>Категория: <select name="cat" onchange="enableDate(this.value)" id="s">';
foreach ($data['cat'] as $buf)
{
	if ($buf['id_item_category'] == $_GET['cat'])
		echo '<option selected value="'.$buf['id_item_category'].'">'.$buf['category_name'].'</option>';
	else
		echo '<option value="'.$buf['id_item_category'].'">'.$buf['category_name'].'</option>';
}
if (isset($_GET['cat']) && $_GET['cat'] == 0)
	echo '<option selected value="0">Собранные компьютеры</option></select><br>';
else
	echo '<option value="0">Собранные компьютеры</option></select><br>';
echo 'С: <input type="date" name="sdate" id="d1" disabled/><br> 
По: <input type="date" name="edate" id="d2" disabled/><br>
<input type="submit" value="Статистика"><input type="button" value="Сбросить" onclick='?> "location.href = '/statistic'"> <?php '</form>';

?>
<h2>Статистика продаж <?php echo $data['cat'][$_GET['cat']-1]['category_name']; ?></h2>
<?php  
	define ('GChart_DIR',dirname(__FILE__).'/gchart');  
	require_once (GChart_DIR.'/GChart.php');
	$pie3d=new GChart_Pie3D(1000,200);
	$value = ($_GET['cat'] == 0 ? "р" : "шт");
	for ($i = 0, $n = count($data['item']); $i < $n; $i++)
	{
		$pie3d->add($data['item'][$i]['sold'],$data['item'][$i]['name'].' / '.$data['item'][$i]['sold'].''.$value,'FF'.$i);
	}
?>
<br>
<img src="<?php echo $pie3d->get_image_string(); ?>" />