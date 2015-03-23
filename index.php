<!DOCTYPE html>
<?php
	session_start();
	if (isset($_POST['logout'])){
			SetCookie("name","",time()-3600);
			session_destroy();
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Авторизация</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<script type="text/javascript">
		function ShowRegForm() {
			if (document.getElementById('regForm').style.display == "none") {
				document.getElementById('regForm').style.display = "inline";
			}
			else if (document.getElementById('regForm').style.display == "inline") {
				document.getElementById('regForm').style.display = "none";
			}
		}
		
		function HideErrorMessage() {
			document.getElementById('errmsg').style.display = "none";
		}
		
	</script>			
					
</head>

<body style=" width: 1365px;">
<div style="background-image: url(images/headerbackground.png); text-align:center;" id="header">
<a href="main.php"><img src="images/label.png" alt="заглавная картинка" style="width: 50%; height: 150px;" /></a>
</div>

<div id="all" style="position:relative;">
<div style="position: absolute; width: 600px;">
<form id="autoForm" name="autoForm" action="main.php" method="POST" style="margin-left:15px;">
<table>
<tr>
	<th>Логин</th>
	<td><input type="text" name="log" size="20" maxlength="18"></td>
</tr>
<tr>
	<th>Пароль</th>
	<td><input type="password" name="pass" size="20" maxlength="16"></td>
</tr>
<tr>
	<td></td>
	<td><input class="button" type="submit" value="Войти" name="enter" style="position: relative; margin: 0px; left: 200px; top: -65px;"></td>
</tr>
</table>
</form>

<p style="margin-top: -20px; margin-left: 15px; font-size: 140%; text-align:justify;">Данный сайт предназначен для исследователей Института, желающих приобрести качественное оборудование.
Здесь Вы можете самостоятельно выбрать фирму-производителя и заказать все необходимые товары. В наличии
имеется как сложное научное оборудование, так и приборы для повседневной жизни и работы 
в лаборатории.<br /></p>
</div>

<div style="position:absolute; width: 720px; left: 630px;">
<p style=" font-size: 140%;">Если у Вас еще нет учетной записи, создайте ее, нажав на кнопку</p>  

<div id="regButton"> 
<input class="button" type="button" value="Регистрация" name="registration" onclick="ShowRegForm(); HideErrorMessage()">
</div>
	<div id="regForm" style="display: none">
	<form name="registrationForm" action="index.php" method="POST">
	<table><tr><th>Логин</th><td><input type="text" name="login" size="20" maxlength="20" onChange="CheckLogin()" required></td><td></td></tr>
		<tr class="description"><td></td><td>Латинские буквы и цифры, не меньше 5 символов</td><td></td></tr>
		<tr><th>Имя</th><td><input type="text" name="name" size="20" maxlength="20" required></td><td></td></tr>
		<tr class="description"><td></td><td>Русские буквы</td><td></td></tr>
		<tr><th>Фамилия</th><td><input type="text" name="fname" size="20" maxlength="38" required></td><td></td></tr>
		<tr class="description"><td></td><td>Русские буквы</td><td></td></tr>
		<tr> <th>E-mail</th> <td><input type="text" name="email" size="20" maxlength="38" required></td><td></td></tr>
		<tr class="description"><td></td><td>Латинские буквы и цифры</td><td></td></tr>
		<tr> <th>Пароль</th> <td><input type="password" name="password" size="20" maxlength="30" required></td><td></td></tr>
		<tr class="description"><td></td><td>Латинские буквы и цифры, не меньше 10 символов</td><td></td></tr>
		<tr> <th>Повторите пароль</th> <td><input type="password" name="repassword" size="20" maxlength="30" required></td><td></td></tr>
		<tr> <th></th> <td><input class="button" type="submit" name="enter_reg" value="Зарегистрироваться" style="position: relative; left: 90px; top: 10px;"></td></tr></table></form>
	</div>


<?php 
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("Ошибка соединения с БД " . mysqli_error($link));
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
	if(isset($_POST['enter_reg'])){
		$login=$_POST['login'];
		$email=$_POST['email'];
		$name=$_POST["name"];
		$fname=$_POST["fname"];
		$password=$_POST['password'];
		$repassword=$_POST['repassword'];		 
		if($password == $repassword){                                                         //проверка пароля
			$password=md5($password);
			if (preg_match("/^([A-Za-z0-9])*$/", $login) && strlen($login)>=5) {               //проверка логина
				if(preg_match("/^[A-ЩЭЮЯЁ]([а-я])+$/", $name)) {                               //проверка имени
					if(preg_match("/^[A-ЩЭЮЯЁ]([а-я])+$/", $fname)) {                          //проверка фамилии
						if(preg_match("/^[^@]+@([a-z0-9\-]+\.)+[a-z]{2,4}$/", $email))	 {     //проверка почты
							$query = "SELECT ID FROM users WHERE Login='$login'" or die("Ошибка при выполнении запроса к БД " . mysqli_error($link));
							$result = $link->query($query);
							$myrow = mysqli_fetch_array($result);
							if (!empty($myrow['ID'])) {
								echo ('<h1 id="errmsg" class="errmsg">Такой логин уже существует</h1>');
							} else {
								//хранимка
								$query = "CALL p('$login','$name','$fname','$email','$password')";
								//быстро кончилась
								//$query = "INSERT INTO users VALUES ('','$login','$name','$fname','$email','$password')" or die("Ошибка при выполнении запроса к БД " . mysqli_error($link));
								$result = $link->query($query);
								if ($result='TRUE'){
									echo '<h1 id="errmsg" class="errmsg">Вы были успешно зарегистрированы!</h1><br>';    
								}  
							}
						}
						else echo '<h1 id="errmsg" class="errmsg">Неверный формат адреса элктронной почты</h1>';
					}
					else echo '<h1 id="errmsg" class="errmsg">Неверный формат фамилии</h1>';
				}
				else echo '<h1 id="errmsg" class="errmsg">Неверный формат имени</h1>';
			}
			else echo '<h1 id="errmsg" class="errmsg">Неверный формат логина</h1>';
		} 
		else{
			echo '<h1 id="errmsg" class="errmsg">Пароли не совпадают</h1>';
		}  
	}
	
	
?>
</div>
</div>
</body>
</html>