<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Добавление данных</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script type="text/javascript">
		function showUser(str) {
			if (str=="") {
				document.getElementById("ajaxtable").innerHTML="";
				return;
			} 
			if (window.XMLHttpRequest) {// код для IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {// код для IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("ajaxtable").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","getproduct.php?u="+str,true);
			xmlhttp.send();
		}
		
		function showMsg(str) {
			if (str != "") {
				document.getElementById('msg').style.display = "none";
			}
			else document.getElementById('msg').style.display = "inline";
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
		echo "<h1 class=errmsg>У Вас нет прав доступа для просмотра данной страницы.</h1>
		<a href=index.php><h2 class=read_next>Вернуться к авторизации</h2></a>'"; 
		exit;
	}
	
	if($_COOKIE['name'] != 'admin' && $_SESSION["name"] != 'admin'){
		echo "<h1 class=errmsg>У Вас нет прав доступа для просмотра данной страницы.</h1>
		<a href=main.php><h2 class=read_next>Вернуться на главную</h2></a>'"; 	 
		exit;
	}
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("Ошибка соединения с БД " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'"); 
	if(isset($_POST['addman'])){
		$firm = $_POST['firm'];
		$representer = $_POST['representer'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$query = "SELECT Firm FROM manufacturers WHERE Firm='$firm'" or die("Ошибка при выполнении запроса.." . mysqli_error($link));
		$result = $link->query($query);
		if($result->num_rows!=0){
				echo "<h2 class=errmsg>Такой поставщик уже есть в базе данных</h2>";
		}
		else {
			$query = "INSERT INTO manufacturers VALUES ('$firm','$representer','$address','$phone')" or die("Ошибка при выполнении запроса к БД " . mysqli_error($link));
			$result = $link->query($query);
			echo "<h2 class=errmsg>Операция прошла успешно</h2>";
		}
	}
?>

<div class="layout">	
<div class="col1">	
<p> <ul>
	<li>В настоящий момент формы добавления не
		обрабатывают ошибок, поэтому старайтесь все 
		тщательно проверять перед отправкой</li><br>
	<li>В поле "Адрес рисунка" записывайте: images/<название_изделия>.jpg. Приносим свои извинения,
		скоро станет доступной функция загрузки фотографий на сервер.</li>
	</ul></p>			
</div>
<div class="col3">
	<div id="menu3">	
			<ul>
				<li style="font-size:100%;"><a href="main.php">Главная</a></li>
				<li style="font-size:100%;"style:"font-size:small;"><a href="process.php">Обработать заказы</a></li>
				<li style="font-size:100%;"><a href="addman.php"><span style:"font-size:10%;">Добавить данные</span></a></li><br>
				<li><form method="POST" action="index.php"><input type="submit" class="button" value="Выйти" name="logout"></form></li>
			</ul>
	</div>
</div>
<div class="col2">
<div class="newsblock">
<h2 style="text-align: center;">Добавьте в базу нового производителя</h2>
<form name="addman" method="POST" action="addman.php">
	<table style="line-height: 40px;">
		<tr> 
			<th>Имя производителя</th>
			<td><input type="text" name="firm" size="30" maxlength="28" required></td>
		</tr>
		<tr>
			<th>Представитель</th>
			<td><input type="text" name="representer" size="30" maxlength="28" required></td>
		</tr>
		<tr>
			<th>Адрес</th>
			<td><input type="text" name="address" size="60" maxlength="58"></td>
		</tr>
		<tr>
			<th>Телефон</th>
			<td><input type="text" name="phone" size="20" maxlength="18"></td>
		</tr>
		<tr>
			<td></td><td><input class="button" type="submit" value="Добавить" name="addman" style="position: relative; left: 170px; top: 10px;"></td>
		</tr>
	</table>
</form> <br>
</div>
<div class="newsblock">
	<h2 style="text-align: center;">Добавьте новый продукт конкретному производителю</h2>
	
			<p><select name="myselect" size="1" onchange="showUser(this.value); showMsg(this.value)">	
				<option value="" selected>Выберите производителя</option>
<?php
	$query = "SELECT Firm FROM manufacturers";
	$result = $link->query($query);
	while($myrow = $result->fetch_assoc()) {
		echo "<option value=".$myrow["Firm"].">".$myrow["Firm"]."</option>";
		}
?>				
			</select></p>
			<div id="ajaxtable"></div>
<?php 
	if (isset($_POST['addprod'])){
				$product = $_POST['product'];
				$price = $_POST['price'];
				$num = $_POST['num'];
				$imadr = $_POST['imadr'];
				$category = $_POST["category"];
				$desc = $_POST["description"];
				$query = "SELECT * FROM products WHERE Product='$product' AND Firm='".$_COOKIE['firm']."'";
				$result = $link->query($query);
				if($result->num_rows!=0){
					echo "<h2 id=msg class=errmsg>Такой продукт уже есть</h2>";
				}
				else {
					$query = ("INSERT INTO products VALUES('','$product','".$_COOKIE['firm']."','$desc','$price','$num','$category','$imadr')");
					$result = $link->query($query);
					if ($result='TRUE'){
						echo '<h2 id="msg" class="errmsg">Товар был успешно добавлен</h2>';    
					}
					SetCookie("firm","",time()-3600);
				}
	}	
?>
			
</div>
</div>
</div>

		
<div id="bottom"></div>
</body>
</html>