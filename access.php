<?php
	header("Content-type: text/html; charset=windows-1251");
	if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout'])) {   
		session_destroy();   
		echo '<h1>��������, ����� ����� ������ �������</h1>';
		header('Refresh: 5; URL=index.php');
		exit;
	}
	$_SESSION['last_activity'] = time();
	
	if(!isset($_COOKIE['name']) || !isset($_SESSION["name"])){
		echo "<h1>� ��� ��� ���� ������� ��� ���������� ������ ��������.</h1>";
		header('Refresh: 5; URL=index.php');
		exit;
	}
	if($_COOKIE['name'] == 'admin' || $_SESSION["name"] == 'admin'){
		echo "<h1>�� ���������� � �������� ��������������. ��� ���������� ������, ����������, ������� � ���� ������ �������.</h1>";	
		header('Refresh: 5; URL=main.php'); 	 
		exit;
	}
?>