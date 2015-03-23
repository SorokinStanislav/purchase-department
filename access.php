<?php
	header("Content-type: text/html; charset=windows-1251");
	if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout'])) {   
		session_destroy();   
		echo '<h1>Извините, время вашей сессии истекло</h1>';
		header('Refresh: 5; URL=index.php');
		exit;
	}
	$_SESSION['last_activity'] = time();
	
	if(!isset($_COOKIE['name']) || !isset($_SESSION["name"])){
		echo "<h1>У Вас нет прав доступа для простмотра данной страницы.</h1>";
		header('Refresh: 5; URL=index.php');
		exit;
	}
	if($_COOKIE['name'] == 'admin' || $_SESSION["name"] == 'admin'){
		echo "<h1>Вы находитесь в аккаунте администратора. Для совершения заказа, пожалуйста, войдите в свой личный профиль.</h1>";	
		header('Refresh: 5; URL=main.php'); 	 
		exit;
	}
?>