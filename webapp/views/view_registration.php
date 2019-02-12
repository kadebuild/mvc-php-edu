<?php if (isset($data)) extract($data); ?>
<?php if($status) { ?>
<p style="color:green">Вы успешно зарегистрированы!</p>
<?php } else { ?>
<h1>Регистрация нового пользователя</h1>
<form action="registration/reg" method="post">
Логин: <input type="text" name="login" value="">
E-mail: <input type="text" name="email" value="">
Пароль: <input type="password" name="password" value="">
<input type="submit" name="reg_button" value="Зарегистрироваться" style="width:150px; height:25px"">
</form>
<?php } ?>