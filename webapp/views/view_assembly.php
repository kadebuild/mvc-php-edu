<div id="dialog-form" title="" style="display:none">
	<div id="item_menu">
	</div>
</div>
<script type="text/javascript">
var assembly_array = [0,0,0,0,0,0,0,0];
$("#dialog-form").dialog({ autoOpen: false, modal:true, width:610, draggable:false, maxHeight:500 });
function openmenu(cat_number) {
	var item_list = "<br>";
	for (var i = 0; i < data[cat_number].item.length; i++) {
		item_list += '<div class="prod_box_big"><div class="top_prod_box_big"></div><div class="center_prod_box_big"><div class="product_img_big"><img src="/images/item/' + data[cat_number].item[i].id_item + '.jpg" alt="" border="0" style="max-width:100px; height:100px"/></div><div class="details_big_box"><div class="product_title_big">' + data[cat_number].item[i].name + '</div><hr><div class="specifications"><span class="blue">' + data[cat_number].item[i].chars + '</span><br/></div><div class="prod_price_big"><span class="price">' + data[cat_number].item[i].price + '</span><br></div></div><button type="button" style="width:150px; height:25px" onclick="additem(' + i + ', ' + cat_number + ')">Добавить</button></div><div class="bottom_prod_box_big"></div></div>';
	}
	document.getElementById("item_menu").innerHTML = item_list;
	$("#dialog-form").dialog({ title:""+document.getElementById("item_name"+cat_number).textContent });
	$("#dialog-form").dialog( "open" );
}
function additem(id_item, cat_number) {
	assembly_array[cat_number] = data[cat_number].item[id_item].id_item;
	$("#dialog-form").dialog( "close" );
	document.getElementById("item"+cat_number).textContent = data[cat_number].item[id_item].name;
	document.getElementById("image"+cat_number).src = "images/item/" + data[cat_number].item[id_item].id_item + ".jpg";
	document.getElementById("image"+cat_number).style = "max-width:150px; height:100px";
	document.getElementById("assembly_price").textContent = parseInt(document.getElementById("assembly_price").textContent,10) + parseInt(data[cat_number].item[id_item].price,10);
<?php
if ($_SESSION['rank'] >= 1) {
?>
	var filled_array = true;
	for (var i = 0; i < assembly_array.length-1; i++)
	{
		if (assembly_array[i] == 0)
		{
			filled_array = false;
			break;
		}
	}
	if (filled_array)
		document.getElementById("buy_button").disabled = false;
<?php
}
?>
}
<?php
if ($_SESSION['rank'] >= 1) {
?>
function assembly() {
	 $.ajax({
	type: "POST",
	url: "/assembly/buy",
	data: "assembly=" + JSON.stringify(assembly_array),
	traditional: true,
	success: function(resp) {
	  document.getElementById("assembly_button").textContent = resp;
	},
	error: function(resp) {
		document.getElementById("assembly_button").textContent = "Ошибка при обработке заказа";
	}
	 });
}
<?php
}
?>
var data = <?php echo $data; ?>;
<?php
echo '</script><div class="crumb_navigation"> Навигация: <a href="/">Главная</a> > <span class="current">Сборка компьютера</span></div>
<br><div id="assembly_button">Итоговая стоимость сборки: <span id="assembly_price">0</span> рублей<br>';
if ($_SESSION['rank'] == 1) { echo '<input id="buy_button" type="button" value="Купить" onclick="javascript:assembly();" disabled>'; }
else if ($_SESSION['rank'] == 2) { echo '<input id="buy_button" type="button" value="Собрать" onclick="javascript:assembly();" disabled>'; }
echo '<input type="reset" value="Сбросить" onclick="javascript:location.reload();"></div><hr>
<h2>Необходимые комплектующие</h2>
<div class="center_content_full">
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(0);"><div id="item_name0">Процессор</div></a></div>
<div class="product_img"><a href="javascript:openmenu(0);"><img id="image0" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item0">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(0);" class="prod_details">Выбрать</a> </div></div>
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(1);"><div id="item_name1">Материнская плата</div></a></div>
<div class="product_img"><a href="javascript:openmenu(1);"><img id="image1" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item1">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(1);" class="prod_details">Выбрать</a> </div></div>
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(2);"><div id="item_name2">Оперативная память</div></a></div>
<div class="product_img"><a href="javascript:openmenu(2);"><img id="image2" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item2">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(2);" class="prod_details">Выбрать</a> </div></div>
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(3);"><div id="item_name3">Жесткий диск</div></a></div>
<div class="product_img"><a href="javascript:openmenu(3);"><img id="image3" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item3">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(3);" class="prod_details">Выбрать</a> </div></div>
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(4);"><div id="item_name4">Блок питания</div></a></div>
<div class="product_img"><a href="javascript:openmenu(4);"><img id="image4" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item4">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(4);" class="prod_details">Выбрать</a> </div></div>
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(5);"><div id="item_name5">Кулер</div></a></div>
<div class="product_img"><a href="javascript:openmenu(5);"><img id="image5" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item5">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(5);" class="prod_details">Выбрать</a> </div></div>
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(6);"><div id="item_name6">Корпус</div></a></div>
<div class="product_img"><a href="javascript:openmenu(6);"><img id="image6" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item6">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(6);" class="prod_details">Выбрать</a> </div></div>
</div><h2>Дополнительные комплектующие</h2>
<div class="center_content_full">
<div class="prod_box"><div class="top_prod_box"></div><div class="center_prod_box">
<div class="product_title"><a href="javascript:openmenu(7);"><div id="item_name7">Видеокарта</div></a></div>
<div class="product_img"><a href="javascript:openmenu(7);"><img id="image7" src="images/noimage.png" alt="" border="0" /></a></div>
<div id="item7">Не выбрано</div></div><div class="bottom_prod_box"></div><div class="prod_details_tab"> <a href="javascript:openmenu(7);" class="prod_details">Выбрать</a> </div></div>
</div>';
?>