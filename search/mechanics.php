<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>��������</title>
	<link type="text/css" rel="stylesheet" href="../index.css" />	
	<link type="text/css" rel="stylesheet" href="../buttons.css" />
	<link type="text/css" rel="stylesheet" href="../menu.css" />
</head>
<body>

<div style="background-image: url(../images/headerbackground.png); text-align:center;" id="header">
<a href="../main.php"><img src="../images/label.png" alt="��������� ��������" style="width: 50%; height: 150px;" /></a>
</div>

<?php
	session_start();
		if(!isset($_COOKIE['name']) && !isset($_SESSION["name"])){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������.</h1>
		<a href=index.php><h2 class=read_next>��������� � �����������</h2></a>'"; 
		exit;
	}
	
	if(@$_COOKIE['name'] == 'admin' && @$_SESSION["name"] == 'admin'){
		echo "<h1 class=errmsg>� ��� ��� ���� ������� ��� ��������� ������ ��������. ������� ��-��� �������� ������ � ������� ��� ������� ������������</h1>	
		<a href=../main.php><h2 class=read_next>��������� �� �������</h2></a>'";	 
		exit;
	}	
	
	if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout'])) {   
		session_destroy();   
		SetCookie("name","",time()-3600);
		echo "<h1 class=errmsg>��������, ����� ����� ������ �������</h1>
		<a href=index.php><h2 class=read_next>������� ������</h2></a>'"; 
		exit;
	}
	$_SESSION['last_activity'] = time();
	
?>

<div class="layout">	
<div class="col1">	
<h2 style="color: #2439ff;" align="middle">����� ���� ����� ����� ������</h2>
<form action="search.php" method="GET">
<input type="text" placeholder="�������� ������ ��� �������������" size="35" maxlength="33" style="margin-left: 10px;"><br><br>
<input type="submit" name="order" class="button" value="�����" width="70%" style="margin-left:200px; margin-bottom:20px;">
</form>
<ul id="navigator">
	<a href="physics.php"><li>������</a><br><br>
		<ul>
			<a href="mechanics.php"><li>��������</li></a><br>
			<a href="thermodynamics.php"><li>�������������</li></a><br>
			<a href="electricity.php"><li>�������������</li></a><br>
			<a href="optics.php"><li>������</li></a><br>
			<a href="nuclear.php"><li>������� ������</li></a><br><br>
		</ul>
	</li>
	<a href="chemistry.php"><li>�����</li></a><br><br>
	<a href="usual.php"><li>������������ ������</a><br><br>
		<ul>
			<a href="stationary.php"><li>����������</li></a><br>
			<a href="devices.php"><li>������� �������</li></a><br>
		</ul>
	</li>
</ul><br>
</div>
<div class="col3">
<?php
	if(@$_COOKIE['name']=="admin" || @$_SESSION["name"]=="admin"){
		echo '<div id="menu3">
			<ul>
				<li style="font-size:100%;"><a href="../main.php">�������</a></li>
				<li style="font-size:100%;"style:"font-size:small;"><a href="../process.php">���������� ������</a></li>
				<li style="font-size:100%;"><a href="../addman.php"><span style:"font-size:10%;">�������� ������</span></a></li><br>
				<li><form method="POST" action="index.php"><input type="submit" class="button" value="�����" name="../logout"></form></li>
			</ul>
			</div>';
		}
		else {
			echo '<div style="font-size:120%;" id="menu3">
			<p style="color:#182fff; font-size: 110%; width: 220px; padding: 20px; margin-left: 9px;">����� ����������, ';
			if(isset($_COOKIE['name'])){echo $_COOKIE['name'];} else {echo $_SESSION["name"];} echo '!</p>
			<ul>
				<li><a href="../main.php">�������</a></li>
				<li><a href="../bin.php">��� ������</a></li>
				<li><form method="POST" action="../index.php"><input style="margin-top:20px;" type="submit" class="button" value="�����" name="logout"></form></li>
			</ul>
			</div>';
		}	
?>
</div>
<div class="col2">
<h1 style="text-align: center; color:#cc1616">��� ������ ��������� "��������"</h1>
<?php 
	if (isset($_SESSION["name"])) $login = $_SESSION["name"];
	else $login = $_COOKIE["name"];
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("������ ���������� � �� " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
	$query = "SELECT * FROM products WHERE Number>0 AND Category='��������' AND NOT EXISTS (SELECT * FROM bin WHERE bin.Login='$login' AND products.Prod_id = bin.Prod_id) ORDER BY products.Product" or die("������ ��� ���������� �������.." . mysqli_error($link));
	$result = $link->query($query);
	if($result->num_rows==0){
		echo '<h1 style="text-align:center"> � ��������� �� ������ ������ � ������ ��������� ��� ��������� �������. ����������� �� ���� �����.</h1><br>
			<a href="../main.php"><h2 class="read_next">��������� �� ������� ��������</h2></a>'; 
		
	}
		else {
			while($myrow = $result->fetch_assoc()) {
				echo '<div class=newsblock>
					<form action=../bin.php method=POST>
						<table class=product_table width=650px border=1>
							<tr>
								<th class=second colspan=2><input type=hidden name=product value='.$myrow["Product"].">".$myrow["Product"]."</th>
							</tr>
							<input type=hidden name=prod_id value=".$myrow["Prod_id"].">
							<tr>
								<td rowspan=4><input type=hidden name=image value=$myrow[Image_address]><img align=left src=../$myrow[Image_address]></td>
								<td class=first><input type=hidden value=$myrow[Firm]>�������������: ".$myrow["Firm"]."</td>
							</tr>
							<tr>
								<td class=second><input type=hidden name=description value=$myrow[Description]>��������: ".$myrow["Description"]."</td>
							</tr>
							<tr>
								<td class=first><input type=hidden name=price value=$myrow[Price]>����: ".$myrow["Price"]."</td>
							</tr>
							<tr>
								<td class=second>����������: <select name=number size=1>
									<option>1</option>";
									for($i=2; $i<=$myrow["Number"]; $i++) {
										echo "<option value=$i>".$i."</option>";
									}
							echo "</select></td>
							</tr>
							<tr>
								<td class=first style=text-align: right; colspan=2><input style=margin:15px; type=submit name=order class=button value='��������'</td>
							</tr>
						</table></form>
					</div></br>";
			}	
		}
?>
</div>
</div>
</body>
</html>
