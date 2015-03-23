<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>�������</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script type="text/javascript">
		function Message1(button) {	 
			if (window.confirm("�� ������������� ������ ���������� �� ������������ ����� ������?")) {
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
	$_SESSION['last_activity'] = time();
	
	if(!isset($_COOKIE['name']) && !isset($_SESSION["name"])){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������.</h1>
		<a href=index.php><h2 class=read_next>��������� � �����������</h2></a>'"; 
		exit;
	}
	
	if(@$_COOKIE['name'] == 'admin' && @$_SESSION["name"] == 'admin'){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������. ������� ��-��� �������� ������ � ������� ��� ������� ������������</h1>	
		<a href=main.php><h2 class=read_next>��������� �� �������</h2></a>'";	 
		exit;
	}	
			if (isset($_POST["order"])) {
				$prod_id = $_POST["prod_id"];
				$image = $_POST["image"];
				$num = $_POST["number"];
				$cost = $_POST["price"] * $num;
				if (isset($_SESSION["name"])) $login = $_SESSION["name"];
				else $login = $_COOKIE["name"];
				$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));
				$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
				// ����������� ������
				$link->query("BLOCK TABLES bin WRITE, products WRITE");
				$query = "SELECT * FROM products WHERE (Number-'$num')>0 AND Prod_id = '$prod_id'";
				$result = $link->query($query);
				if($result->num_rows==0){
					echo "<h2 class=errmsg> � ���������, �� ������ ��� ��� ".$num." ������ ������� ��������. ���������� �������� �����</h2>";
				}
				else {
					$query1 = "INSERT INTO bin VALUES ('','$login','$prod_id','$num','��������������')" or die("������ ��� ���������� ������� � �� " . mysqli_error($link));	
					$result1 = $link->query($query1);					
					$query2 = "UPDATE products SET Number=Number-'$num' WHERE Prod_id='$prod_id'";
					$result2 = $link->query($query2);
				}
				sleep(10);
				$link->query("UNLOCK TABLES");
				// ����� ����������
			}
			
			if(isset($_POST["cancel"])) {
				$order_id = $_POST["order_id"];
				$prod_id = $_POST["prod_id"];
				$num = $_POST["number"];
				$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));
				$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
				$query1 = "DELETE FROM bin WHERE Order_id='$order_id'";
				$result1 = $link->query($query1);
				$query2 = "UPDATE products SET Number=Number+'$num' WHERE Prod_id='$prod_id'";
				$result2 = $link->query($query2);
			}
			if(isset($_POST["delete"])) {
				$order_id = $_POST["order_id"];
				$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));
				$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
				$query = "DELETE FROM bin WHERE Order_id='$order_id'";
				$result = $link->query($query);
			}
?>

<div class="layout">	
<div class="col1">	
<h2 style="color: #2439ff;" align="middle">����� ���� ����� ����� ������</h2>
<form action="search/search.php" method="GET">
<input type="text" placeholder="�������� ������ ��� �������������" size="35" maxlength="33" name="query" style="margin-left: 10px;"><br><br>
<input type="submit" name="search" class="button" value="�����" width="70%" style="margin-left:200px; margin-bottom:20px;">
</form>
<ul id="navigator">
	<a href="search/physics.php"><li>������</a><br><br>
		<ul>
			<a href="search/mechanics.php"><li>��������</li></a><br>
			<a href="search/thermodynamics.php"><li>�������������</li></a><br>
			<a href="search/electricity.php"><li>�������������</li></a><br>
			<a href="search/optics.php"><li>������</li></a><br>
			<a href="search/nuclear.php"><li>������� ������</li></a><br><br>
		</ul>
	</li>
	<a href="search/chemistry.php"><li>�����</li></a><br><br>
	<a href="search/usual.php"><li>������������ ������</a><br><br>
		<ul>
			<a href="search/stationary.php"><li>����������</li></a><br>
			<a href="search/devices.php"><li>������� �������</li></a><br>
		</ul>
	</li>
</ul><br>
</div>
<div class="col3">
<?php
	if(@$_COOKIE['name']=="admin" || @$_SESSION["name"]=="admin"){
		echo '<div id="menu3">
			<ul>
				<li style="font-size:100%;"><a href="main.php">�������</a></li>
				<li style="font-size:100%;"style:"font-size:small;"><a href="process.php">���������� ������</a></li>
				<li style="font-size:100%;"><a href="addman.php"><span style:"font-size:10%;">�������� ������</span></a></li><br>
				<li><form method="POST" action="index.php"><input type="submit" class="button" value="�����" name="logout"></form></li>
			</ul>
			</div>';
		}
		else {
			echo '<div style="font-size:120%;" id="menu3">
			<p style="color:#182fff; font-size: 110%; width: 220px; padding: 20px; margin-left: 9px;">����� ����������, ';
			if(isset($_COOKIE['name'])){echo $_COOKIE['name'];} else {echo $_SESSION["name"];} echo '!</p>
			<ul>
				<li><a href="main.php">�������</a></li>
				<li><a href="bin.php">��� ������</a></li>
				<li><form method="POST" action="index.php"><input style="margin-top:20px;" type="submit" class="button" value="�����" name="logout"></form></li>
			</ul>
			</div>';
		}	
?>
</div>
<div class="col2">
<h1 style="text-align: center; color:#cc1616">���� ������</h1>
<?php
	if (isset($_SESSION["name"])) $login = $_SESSION["name"];
	else $login = $_COOKIE["name"];
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
	$query3 =  "SELECT DISTINCT X.Product, Y.Order_id, Y.Prod_id, X.Firm, X.Description, X.Image_address, Y.Number, X.Price, Y.Status 
				FROM products X, bin Y 
				WHERE Y.Login='$login' AND X.Prod_id=Y.Prod_id 
				ORDER BY Order_id DESC";
	$result3 = $link->query($query3);
	if($result3->num_rows==0){
		echo '<h1 style="text-align:center">���� ������� �� ������ ������ �����.</h1><br>
			<a href="main.php"><h2 class="read_next">��������� �� ������� ��������</h2></a>'; 		
	}
		else {
			$sum = 0 ; 
			while($myrow = $result3->fetch_assoc()) {
				$cost=$myrow["Number"]*$myrow["Price"];
				echo "		
					<div class=newsblock>
					<form id=cancel action=bin.php method=POST>
					<form id=delete action=bin.php method=POST>	
					<form id=deal action=contract.php method=POST>	
					<table class=product_table width=650px border=1>
						<tr>
							<th class=second colspan=2><input type=hidden name=product value=".$myrow["Product"].">".$myrow["Product"]."</th>
													   <input type=hidden name=order_id value=".$myrow["Order_id"].">
													   <input type=hidden name=prod_id value=".$myrow["Prod_id"].">
						</tr>
						<tr>
							<td rowspan=4><input type=hidden name=image value=".$myrow["Image_address"]."><img align=left src=$myrow[Image_address]></td>
							<td class=first><input type=hidden value=".$myrow["Firm"].">�������������: ".$myrow["Firm"]."</td>
						</tr>
						<tr>
							<td class=second><input type=hidden name=description value=".$myrow["Description"].">��������: ".$myrow["Description"]."</td>
						</tr>
						<tr>
							<td class=first><input type=hidden name=number value=".$myrow["Number"].">����������: ".$myrow["Number"]."</td>
						</tr>
						<tr>
							<td class=second><input type=hidden name=cost value=".$cost.">C��������: ".$cost."</td>
						</tr>
						<tr>
	
							<td class=first style=text-align: left;><input id=status type=hidden value=".$myrow["Status"]."><span style=font-size:110%;> ������ ������: ".$myrow["Status"]."</span></td>";
							if ($myrow["Status"]=="��������������") echo "<td class=first style=text-align:center;><input id=button1 class=button type=button name=cancel value=���������� style=margin:15px; onClick=Message1(this)>";
							if ($myrow["Status"]=="��������") echo "<td class=first style=text-align:center;><input id=button2 class=button type=submit name=delete value=������� style=margin:15px;>";
							if ($myrow["Status"]=="�������") echo "<td class=first style=text-align:center;><input id=button3 class=button type=submit name=deal value=������ form=deal style=margin:15px;></td>";
						echo "</tr>
					</table></form></form>
					<form id=deal method=POST action=contract.php> 
						<input type=hidden name=order_id value=".$myrow["Order_id"].">	
					</form>
				</div></br>";
			$sum+=$cost;	
			}
		echo "<h2 style='color:#182fff; text-align: right; margin-left:280px; margin-right: 10px;'>����� ������� �� �����: ".$sum."</h2>";
		}
?>
</div>
</div>
</body>
</html>
