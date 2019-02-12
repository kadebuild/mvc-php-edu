<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Computer Star</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />
<script type="text/javascript" src="/js/boxOver.js"></script>
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
</head>
<body>
<div id="main_container">
  <div class="top_bar">
	<div id="login_menu" align="right">
		<?php
		if (isset($_SESSION['login'])) 
		{
		?>
		Здравствуйте, <?php echo $_SESSION['login']; ?> / <a href="logout">Выход</a>
		<?php
		}
		else
		{
		?>
		<form action="login" method="post">
		Логин: <input type="text" name="login" value="">
		Пароль: <input type="password" name="password" value="">
		<input type="submit" name="login_button" value="Войти" style="width:80px; height:25px"">
		</form>
		<a href="registration">Зарегистрироваться</a>
		<?php
		}
		?>
	</div>
  </div>
  <div id="header">
  </div>
  <div id="main_content">
    <div id="menu_tab">
      <div class="left_menu_corner"></div>
      <ul class="menu">
        <li><a href="/" class="nav1"> Главная</a></li>
        <li class="divider"></li>
        <li><a href="/shop" class="nav2">Каталог</a></li>
        <li class="divider"></li>
        <li><a href="/assembly" class="nav3">Сборка компьютера</a></li>
        <li class="divider"></li>
		<?php if ($_SESSION['rank'] == 2) { ?>
			<li><a href="/additem" class="nav4">Добавить товар</a></li>
			<li class="divider"></li>
			<li><a href="/statistic" class="nav5">Статистика</a></li>
			<li class="divider"></li>
		<?php } ?>
        <li><a href="/contacts" class="nav6">Контакты</a></li>
      </ul>
      <div class="right_menu_corner"></div>
    </div>
    <!-- end of menu tab -->
	<?php include 'webapp/views/'.$content_view; ?>
  </div>
  <!-- end of main content -->
  <div class="footer">
    <div class="center_footer">Контрольная работа по WEB программированию</div>
  </div>
</div>
<!-- end of main_container -->
</body>
</html>
