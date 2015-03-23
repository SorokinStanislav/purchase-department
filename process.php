<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Добавление производителя</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script type="text/javascript">
		function MessageYes(button) {	 
			if (window.confirm("Подтвердить заказ? В этом случае заказчик сможет составить договр купли-продажи.")) {
				button.type="submit";
			}
		}
		function MessageNo(button) {	 
			if (window.confirm("Вы действительно хотите отклонить заказ? Так как сайт еще не доработан, отправьте на E-mail заказчика причину отказа.")) {
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
	
	if(isset($_POST["yes"])) {
		$order_id = $_POST["order_id"];
		$link = mysqli_connect('localhost','root','','purchasing_department') or die("Ошибка соединения с БД " . mysqli_error($link));	
		$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'"); 
		$query = "UPDATE bin SET Status='Принято' WHERE Order_id='$order_id'";
		$result = $link->query($query);
	}
	if (isset($_POST["no"])) {
		$order_id = $_POST["order_id"];
		$prod_id = $_POST["prod_id"];
		$num = $_POST["number"];
		$link = mysqli_connect('localhost','root','','purchasing_department') or die("Ошибка соединения с БД " . mysqli_error($link));
		$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
		$query1 = "UPDATE bin SET Status='Отказано' WHERE Order_id='$order_id'";
		$result1 = $link->query($query1);
		$query2 = "UPDATE products SET Number=Number+'$num' WHERE Prod_id='$prod_id'";
		$result2 = $link->query($query2);
	}
?>

<div class="layout">	
<div class="col1">	
<p> <ul>
	<li>При нажатии "ok" в поле "Принять" вы даете возможность заказчику оставить договр купли-продажи с производителем.</li><br>
	<li>При нажатии "ok" в поле "Отказать" изделие изымается из корзины заказчика, и он уведомляется в том, что 
		ему отказано в заказе. Однако пользователь вновь сможет попробовать заказать данный товар. Поэтому присылайте
		обоснование вашего отказа на почту заказчику.</li>
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
<?php
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("Ошибка соединения с БД " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'"); 
	$query3 =  "SELECT DISTINCT Y.Order_id, Y.Prod_id, Y.Number, Y.Status, Y.Login, X.Product, X.Price 
				FROM products X, bin Y  
				WHERE Y.Status='Обрабатывается' AND X.Prod_id=Y.Prod_id
				ORDER BY Y.Order_id ASC";
	$result3 = $link->query($query3);
	if($result3->num_rows==0){
		echo '<h1 style="text-align:center">На данный момент нет поступивших заказов</h1><br>
			<a href="main.php"><h2 class="read_next">Вернуться на главную страницу</h2></a>'; 		
	}
		else {
			echo '
				<table class="admin_table" style="text-align:center; margin-right: 5px;">
					<tr class="first">
						<th>№</th>
						<th>Название</th>
						<th>Заказчик</th>
						<th>Количество</th>
						<th>Стоимость</th>
						<th>Принять</th>
						<th>Отказать</th>
					</tr>';
			while($myrow = $result3->fetch_assoc()) {
				$cost=$myrow["Number"]*$myrow["Price"];
				echo "<form name=process action=process.php method=POST>
				<tr class=second>
					<td><input type=hidden name=order_id value=".$myrow["Order_id"].">".$myrow["Order_id"]."</td>
					<td><input type=hidden name=product value=".$myrow["Product"].">".$myrow["Product"]."</td>
						<input type=hidden name=prod_id value=".$myrow["Prod_id"].">
					<td><input type=hidden name=login value=".$myrow["Login"].">".$myrow["Login"]."</td>
					<td><input type=hidden name=number value=".$myrow["Number"].">".$myrow["Number"]."</td>
					<td><input type=hidden name=cost value=".$cost.">".$cost."</td>
					<td><input type=button id=button4 class=button name=yes value=ok onClick=MessageYes(this)></td>
					<td><input type=button id=button5 class=button name=no value=ok onClick=MessageNo(this)></td>
				</tr>
				</form>";
			}
			echo '</table>';
		}
?>		
</div>
</div>
</div>
</html>