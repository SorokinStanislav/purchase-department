<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>���������� ������</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script type="text/javascript">
		function showUser(str) {
			if (str=="") {
				document.getElementById("ajaxtable").innerHTML="";
				return;
			} 
			if (window.XMLHttpRequest) {// ��� ��� IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {// ��� ��� IE6, IE5
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
	
	if($_COOKIE['name'] != 'admin' && $_SESSION["name"] != 'admin'){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������.</h1>
		<a href=main.php><h2 class=read_next>��������� �� �������</h2></a>'"; 	 
		exit;
	}
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'"); 
	if(isset($_POST['addman'])){
		$firm = $_POST['firm'];
		$representer = $_POST['representer'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$query = "SELECT Firm FROM manufacturers WHERE Firm='$firm'" or die("������ ��� ���������� �������.." . mysqli_error($link));
		$result = $link->query($query);
		if($result->num_rows!=0){
				echo "<h2 class=errmsg>����� ��������� ��� ���� � ���� ������</h2>";
		}
		else {
			$query = "INSERT INTO manufacturers VALUES ('$firm','$representer','$address','$phone')" or die("������ ��� ���������� ������� � �� " . mysqli_error($link));
			$result = $link->query($query);
			echo "<h2 class=errmsg>�������� ������ �������</h2>";
		}
	}
?>

<div class="layout">	
<div class="col1">	
<p> <ul>
	<li>� ��������� ������ ����� ���������� ��
		������������ ������, ������� ���������� ��� 
		��������� ��������� ����� ���������</li><br>
	<li>� ���� "����� �������" �����������: images/<��������_�������>.jpg. �������� ���� ���������,
		����� ������ ��������� ������� �������� ���������� �� ������.</li>
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
<h2 style="text-align: center;">�������� � ���� ������ �������������</h2>
<form name="addman" method="POST" action="addman.php">
	<table style="line-height: 40px;">
		<tr> 
			<th>��� �������������</th>
			<td><input type="text" name="firm" size="30" maxlength="28" required></td>
		</tr>
		<tr>
			<th>�������������</th>
			<td><input type="text" name="representer" size="30" maxlength="28" required></td>
		</tr>
		<tr>
			<th>�����</th>
			<td><input type="text" name="address" size="60" maxlength="58"></td>
		</tr>
		<tr>
			<th>�������</th>
			<td><input type="text" name="phone" size="20" maxlength="18"></td>
		</tr>
		<tr>
			<td></td><td><input class="button" type="submit" value="��������" name="addman" style="position: relative; left: 170px; top: 10px;"></td>
		</tr>
	</table>
</form> <br>
</div>
<div class="newsblock">
	<h2 style="text-align: center;">�������� ����� ������� ����������� �������������</h2>
	
			<p><select name="myselect" size="1" onchange="showUser(this.value); showMsg(this.value)">	
				<option value="" selected>�������� �������������</option>
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
					echo "<h2 id=msg class=errmsg>����� ������� ��� ����</h2>";
				}
				else {
					$query = ("INSERT INTO products VALUES('','$product','".$_COOKIE['firm']."','$desc','$price','$num','$category','$imadr')");
					$result = $link->query($query);
					if ($result='TRUE'){
						echo '<h2 id="msg" class="errmsg">����� ��� ������� ��������</h2>';    
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