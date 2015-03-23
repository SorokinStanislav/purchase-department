<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
	$link = mysqli_connect('localhost','root','','data') or die("Ошибка соединения с БД " . mysqli_error($link));
	$query = "SELECT * FROM table";
	$result = $link->query($query);
	print_r($result);
?>
</html>