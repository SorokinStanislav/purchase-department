<?php 
	header("Content-type: text/html; charset=windows-1251");
	$u = $_GET['u'];
	SetCookie("firm",$u,time()+3600);
	$link = mysqli_connect('localhost','root','','purchasing_department') or die("Ошибка соединения с БД " . mysqli_error($link));	
	$link->query("SET character_set_results = 'cp1251', character_set_client = 'cp1251', character_set_connection = 'cp1251', character_set_database = 'cp1251', character_set_server = 'cp1251'");
		echo '<form id="addproduct" name="addproduct" method="POST" action="addman.php">
					<table id="hidden" style="line-height: 40px;" >
					<tr>
						<th>Название</th>
						<td><input type="text" name="product" size="30" maxlength="28"></td>
					</tr>
					<tr>
						<th>Описание</th>
						<td><textarea form=addproduct name=description rows=6 cols=40 maxlength=200>Описание не более 200 символов</textarea></td>
					</tr>
					<tr>
						<th>Категория</th>
						<td><select name="category" size="1" >	
							<option selected>Выберите Категорию</option>
							<option  >Механика</option>
							<option  >Термодинакмика</option>
							<option  d>Электричество</option>
							<option >Оптика</option>
							<option >Ядерная физика</option>
							<option >Химия</option>
							<option >Канцелярские товары</option>
							<option >Бытовая техника</option>
							</select>
							</td>
					</tr>
					<tr>
						<th>Цена</th>
						<td><input type="text" name="price" size="20" maxlength="18"></td>
					</tr>
					<tr>
						<th>Количество</th>
						<td><input type="text" name="num" size="20" maxlength="18"></td>
					</tr>
					<tr>
						<th>Адрес рисунка</th>
						<td><input type="text" name="imadr" size="40" maxlength="38"></td>
					</tr>
					<tr>
						<td></td><td><input class="button" type="submit" value="Добавить" name="addprod" style="position: relative; left: 170px; top: 10px;"></td>
				</table></form><br>';			
?>			
	
	
	