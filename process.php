<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>���������� �������������</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script type="text/javascript">
		function MessageYes(button) {	 
			if (window.confirm("����������� �����? � ���� ������ �������� ������ ��������� ������ �����-�������.")) {
				button.type="submit";
			}
		}
		function MessageNo(button) {	 
			if (window.confirm("�� ������������� ������ ��������� �����? ��� ��� ���� ��� �� ���������, ��������� �� E-mail ��������� ������� ������.")) {
				button.type="submit";
			}
		}
	</script>			
</head>
<body>

<div style="background-image: url(images/headerbackground.png); text-align:center;" id="header">
<a href="main.php"><img src="images/label.png" alt="��������� ��������" style="width: 50%; height: 150px;" /></a>
</div>

<?php
	session_start();
	if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout'])) {   
		session_destroy();   
		SetCookie("name","",time()-3600);
		echo "<h1 class=errmsg>��������, ����� ����� ������ �������</h1>
		<a href=index.php><h2 class=read_next>������� ������</h2></a>'"; 
		exit;
	}
	
	if(!isset($_COOKIE['name']) && !isset($_SESSION["name"])){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������.</h1>
		<a href=index.php><h2 class=read_next>��������� � �����������</h2></a>'"; 
		exit;
	}
	
	if($_COOKIE['name'] != 'admin' && $_SESSION["name"] != 'admin'){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������.</h1>
		<a href=main.php><h2 class=read_next>��������� �� �������</h2></a>'"; 	 
		exit;
	}
	
	if(isset($_POST["yes"])) {
		$order_id = $_POST["order_id"];
		$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));	
		$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'"); 
		$query = "UPDATE bin SET Status='�������' WHERE Order_id='$order_id'";
		$result = $link->query($query);
	}
	if (isset($_POST["no"])) {
		$order_id = $_POST["order_id"];
		$prod_id = $_POST["prod_id"];
		$num = $_POST["number"];
		$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));
		$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
		$query1 = "UPDATE bin SET Status='��������' WHERE Order_id='$order_id'";
		$result1 = $link->query($query1);
		$query2 = "UPDATE products SET Number=Number+'$num' WHERE Prod_id='$prod_id'";
		$result2 = $link->query($query2);
	}
?>

<div class="layout">	
<div class="col1">	
<p> <ul>
	<li>��� ������� "ok" � ���� "�������" �� ����� ����������� ��������� �������� ������ �����-������� � ��������������.</li><br>
	<li>��� ������� "ok" � ���� "��������" ������� ��������� �� ������� ���������, � �� ������������ � ���, ��� 
		��� �������� � ������. ������ ������������ ����� ������ ����������� �������� ������ �����. ������� ����������
		����������� ������ ������ �� ����� ���������.</li>
	</ul></p>					
</div>
<div class="col3">
	<div id="menu3">	
			<ul>
				<li style="font-size:100%;"><a href="main.php">�������</a></li>
				<li style="font-size:100%;"style:"font-size:small;"><a href="process.php">���������� ������</a></li>
				<li style="font-size:100%;"><a href="addman.php"><span style:"font-size:10%;">�������� ������</span></a></li><br>
				<li><form method="POST" action="index.php"><input type="submit" class="button" value="�����" name="logout"></form></li>
			</ul>
	</div>
</div>
<div class="col2">
<div class="newsblock">
<?php
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'"); 
	$query3 =  "SELECT DISTINCT Y.Order_id, Y.Prod_id, Y.Number, Y.Status, Y.Login, X.Product, X.Price 
				FROM products X, bin Y  
				WHERE Y.Status='��������������' AND X.Prod_id=Y.Prod_id
				ORDER BY Y.Order_id ASC";
	$result3 = $link->query($query3);
	if($result3->num_rows==0){
		echo '<h1 style="text-align:center">�� ������ ������ ��� ����������� �������</h1><br>
			<a href="main.php"><h2 class="read_next">��������� �� ������� ��������</h2></a>'; 		
	}
		else {
			echo '
				<table class="admin_table" style="text-align:center; margin-right: 5px;">
					<tr class="first">
						<th>�</th>
						<th>��������</th>
						<th>��������</th>
						<th>����������</th>
						<th>���������</th>
						<th>�������</th>
						<th>��������</th>
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