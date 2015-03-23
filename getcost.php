<?php
	session_start();
	header("Content-type: text/html; charset=windows-1251");
	$u = $_GET['u'];
	echo $u.'<br>';
	$cost = $u * $_SESSION['price'];
	echo $cost;
?>