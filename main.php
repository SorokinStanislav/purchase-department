<!DOCTYPE html>
<?php 
	session_start();
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
		if(isset($_POST['enter'])){
			$login=$_POST['log'];
			$password=md5($_POST['pass']);
			$query = "SELECT Login, Password FROM users WHERE Login='$login'" or die("������ ��� ���������� �������.." . mysqli_error($link)); 
			$result = $link->query($query);
			$user_data = mysqli_fetch_array($result);
/*					print"<PRE>";
					print_r($user_data);
					print"</PRE>";*/
			if($user_data["Password"]==$password){
				$_SESSION["name"]=$login;
				$_SESSION["timeout"]=12000;
				$_SESSION['last_activity'] = time();
				SetCookie("name",$login,time()+3600);
				include 'cookie.php';
			}
		}					
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>�������</title>
	<link type="text/css" rel="stylesheet" href="index.css" />
	<link type="text/css" rel="stylesheet" href="buttons.css" />
	<link type="text/css" rel="stylesheet" href="menu.css" />
	<script>
		
	</script>
</head>
<body>

<div style="background-image: url(images/headerbackground.png); text-align:center;" id="header">
<a href="main.php"><img src="images/label.png" alt="��������� ��������" style="width: 50%; height: 150px;" /></a>
</div>
<?php
	if(isset($_POST['enter'])){
		if($user_data["Password"]!=$password){
			echo "<h1 class=errmsg>�� ����� ������������ ����� ��� ������!</h1><br>
			<a href=index.php><h2 class=read_next>����������� �����</h2></a>'"; 
			exit;
		}
	}	
	
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
?>
<div class="layout">	
<div class="col1">
<?php 
	if(@$_COOKIE['name']!="admin" && @$_SESSION["name"]!="admin"){
		echo '<h2 style="color: #2439ff;" align="middle">����� ���� ����� ����� ������</h2>
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
			</ul><br>';
	}
	else echo '<div style="font-size: 110%; margin: 10px;"><p style="text-align: center;">5 ��������� �������� �������������:
	<ul>
		<li style="margin:10px;">'.@$_COOKIE["active1"].'</li>
		<li style="margin:10px;">'.@$_COOKIE["active2"].'</li>
		<li style="margin:10px;">'.@$_COOKIE["active3"].'</li>
		<li style="margin:10px;">'.@$_COOKIE["active4"].'</li>
		<li style="margin:10px;">'.@$_COOKIE["active5"].'</li>
	</ul></div>';
?>
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
	<h1 style="text-align: center; color:#cc1616">��������� ������� �� ������ ���������</h1>
	<!--<div class="newsblock">
	<form action="bin.php" method="POST">
		<table class="product_table" width="650px" border="1">
			<tr>
				<th class="second" colspan="2"><input type="hidden" value="">��������</th>
			</tr>
			<tr>
				<td rowspan="4"><input type="hidden" value=""><img align="left" src="images/physics/mechanics/generator.jpg"></td>
				<td class="first"><input type="hidden" value="">�������������: </td>
			</tr>
			<tr>
				<td class="second"><input type="hidden" value="">��������: </td>
			</tr>
			<tr>
				<td class="first"><input type="hidden" value="">����: </td>
			</tr>
			<tr>
				<td class="second">����������: <input style="width: 50px;" type="number" name="number" size="1" value="1" min="1" max="200"></td>
			</tr>
			<tr>
				<td class="first" style="text-align: right;" colspan="2"><input style="margin:15px;" type="submit" name="order" class="button" value="��������"</td>
			</tr>
		</table>
	</div></br>-->
				
	<div class="newsblock">
		<a href="lamp.php"><h2>05.12.2014. ������� � ������� ���</h2></a>
		<p>������ � ���! ���������� � ����� �� �������� �������� ������. ������, �������
			� ������� �������� � ��������� ������������ ������ ����! ������ ����������,
			������� ��������� � �������.</p>
		<a href="lamp.php"><p class="read_next">������ �����</p></a>
	</div><br/>
	<div class="newsblock">
		<a href="microscope.php"><h2>25.11.2014. ����� ��������� ULTRA-14 ��� � �������!</h2></a>
		<p>��� ����������! ��� ����� ��� ������� � ������ ����� ��������� ����� ���� �������. � ��� �� ��������.
		�������, ����� ��� ������� �� ������ ������, �� ��� ������ ���-�� �����������, � �������������� ��������
		��� ���� � �������� ������. �� ��������, ��� ���� ������. �������������� ������� ������ �����������:
		������� ��������, ������� � ��������.</p>
		<a href="microscope.php"><p class="read_next">������ �����</p></a>
	</div><br/>
	<div class="newsblock">
		<a href="scheme.php"><h2>09.11.2014. �������� ������� ��� ��������� �����������</h2></a>
		<p>� ������� �������� �������� ����� ��� ������������ �����, ��������� �� ����������, ����������, ������, ������,
		������������� � ������ ���������. ����� ������ ���������� ��� ���������, ������� ���������� ������ ��� �������������
		� �����������. ��� ��������� �����, � ������� ������� �� � ���� ��������
		������� �� ������ ������ �������� �� 10 �����, �� � ������� ��������� �������� ���������. ������ ����� ��� �� ������ �������� ��������,
		����� ��� �������� ���������� ��� ��������� �������� �����, ������� ���������� ������� � ��� � �������.</p>
		<a href="scheme.php"><p class="read_next">������ �����</p></a>
	</div><br/>
</div>
</div>
</body>
</html>