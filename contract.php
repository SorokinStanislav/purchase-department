<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Главная</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script type="text/javascript">
		function Message1(button) {	 
			if (window.confirm("Вы действительно хотите отказаться от приобретения этого товара?")) {
				button.type="submit";
			}
		}
	</script>			
</head>
<body>

<div style="background-image: url(images/headerbackground.png); text-align:center;" id="header">
<a href="main.php"><img src="images/label.png" alt="заглавная картинка" style="width: 50%; height: 150px;" /></a>
</div>

<?php
	session_start();
	if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout'])) {   
		session_destroy();   
		SetCookie("name","",time()-3600);
		echo "<h1 class=errmsg>Извините, время вашей сессии истекло</h1>
		<a href=index.php><h2 class=read_next>Зайдите заново</h2></a>'"; 
		exit;
	}
	$_SESSION['last_activity'] = time();
	
	if(!isset($_COOKIE['name']) && !isset($_SESSION["name"])){
		echo "<h1 class=errmsg>У Вас нет прав доступа для простмотра данной страницы.</h1>
		<a href=index.php><h2 class=read_next>Вернуться к авторизации</h2></a>'"; 
		exit;
	}
	
	if(@$_COOKIE['name'] == 'admin' && @$_SESSION["name"] == 'admin'){
		echo "<h1 class=errmsg>У Вас нет прав доступа для простмотра данной страницы. Выйдите из-под аккаунта админа и зайдите как обычнй пользователь</h1>	
		<a href=main.php><h2 class=read_next>Вернуться на главную</h2></a>'";	 
		exit;
	}	
?>
<div class="layout">	
<div class="col1">	
<h2 style="color: #2439ff;" align="middle">Найди свой товар прямо сейчас</h2>
<form action="search.php" method="GET">
<input type="text" placeholder="название товара или производителя" size="35" maxlength="33" style="margin-left: 10px;"><br><br>
<input type="submit" name="order" class="button" value="Поиск" width="70%" style="margin-left:200px; margin-bottom:20px;">
</form>
<ul id="navigator">
	<a href="search/physics.php"><li>Физика</a><br><br>
		<ul>
			<a href="search/mechanics.php"><li>Механика</li></a><br>
			<a href="search/thermodynamics.php"><li>Термодинамика</li></a><br>
			<a href="search/electricity.php"><li>Электричество</li></a><br>
			<a href="search/optics.php"><li>Оптика</li></a><br>
			<a href="search/nuclear.php"><li>Ядерная физика</li></a><br><br>
		</ul>
	</li>
	<a href="search/chemistry.php"><li>Химия</li></a><br><br>
	<a href="search/usual.php"><li>Повседневные товары</a><br><br>
		<ul>
			<a href="search/stationary.php"><li>Канцтовары</li></a><br>
			<a href="search/devices.php"><li>Бытовая техника</li></a><br>
		</ul>
	</li>
</ul><br>
</div>
<div class="col3">
<?php
	if(@$_COOKIE['name']=="admin" || @$_SESSION["name"]=="admin"){
		echo '<div id="menu3">
			<ul>
				<li style="font-size:100%;"><a href="main.php">Главная</a></li>
				<li style="font-size:100%;"style:"font-size:small;"><a href="process.php">Обработать заказы</a></li>
				<li style="font-size:100%;"><a href="addman.php"><span style:"font-size:10%;">Добавить данные</span></a></li><br>
				<li><form method="POST" action="index.php"><input type="submit" class="button" value="Выйти" name="logout"></form></li>
			</ul>
			</div>';
		}
		else {
			echo '<div style="font-size:120%;" id="menu3">
			<p style="color:#182fff; font-size: 110%; width: 220px; padding: 20px; margin-left: 9px;">Добро пожаловать, ';
			if(isset($_COOKIE['name'])){echo $_COOKIE['name'];} else {echo $_SESSION["name"];} echo '!</p>
			<ul>
				<li><a href="main.php">Главная</a></li>
				<li><a href="bin.php">Мои заказы</a></li>
				<li><a href="makeorder.php" >Сделать заказ</a></li><br>
				<li><form method="POST" action="index.php"><input type="submit" class="button" value="Выйти" name="logout"></form></li>
			</ul>
			</div>';
		}	
?>
</div>
<div class="col2">
<?php
	if (isset($_POST["deal"])) {
		echo '<h2 style="margin:10px; text-align:center;">К сожалению, функция интерактивного составления договора в данный момент недоступна. 
				Поэтому возьмите Ваш номер заказа <span style="color:#2439ff;;">'.$_POST["order_id"]."</span> и, не забыв паспорт, отправляйтесь в бухгалтерию Университета.</h2>";
	}
?>
</div>
</div>	
</html>