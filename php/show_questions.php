<?php
error_reporting(0);
/* Соединяемся с базой данных */
$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "root"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "usbw"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "fortest"; // название базы данных
$test_number = $_POST['s_test'];
$questions_in_div = 5;
 
/* Таблица MySQL, в которой хранятся вопросы */
$table_questions = "question";
$table_tests = "tests";

/* Создаем соединение */
mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());

$query_test_questions = "SELECT * FROM $table_questions WHERE tid = $test_number";
$query_tests = "SELECT title, tid, description FROM $table_tests";
$query_test_description = "SELECT tid, description, title FROM $table_tests WHERE tid = $test_number";
mysql_query("SET NAMES 'utf8'"); /* Указание кодировки для извлекаемых запросами данных */

/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
/* Переменной res присваиваются результаты выполненного запроса */
$res_test_questions = mysql_query($query_test_questions);
$res_query_tests = mysql_query($query_tests);
$test_description = mysql_query($query_test_description);

echo ("
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
	<link rel=\"stylesheet\" href=\"../css/mainstyle.css\">
    <title>Тест</title>
	<meta charset=\"UTF-8\">
</head>
<body>");

if (isset($test_number))   /* Назначить блочный элемент неанимированным в случае, если тест выбран, т.е. при первом запуске в т.ч. */
echo "<div class=box3>";
else echo "<div class=\"box3 animated fadeInDown\">";

if (isset($test_number)) {
$row = mysql_fetch_array($test_description);
echo "<h2 class=\"animated fadeInLeft\">".$row[title]."</h2>\n";
echo
"<form action=\"show_questions.php\" method=post target=info>
	<div align=center>Выбрать другой тест:
		<select name=s_test class=test_selection>\n";
			while ($row = mysql_fetch_array($res_query_tests))
			echo "<option value=".$row['tid'].">".$row['title']."</option>\n";
			echo "<input type=\"submit\" id=selection_test_input value=\"Выбрать\">
			</div>\n
</form>";
}

else {
echo "<h2>Тесты</h2>\n";
echo
"<form action=\"show_questions.php\" method=post target=info>
	<div align=center>Выбрать:
		<select name=s_test class=test_selection>\n";
			while ($row = mysql_fetch_array($res_query_tests))
			echo "<option value=".$row['tid'].">".$row['title']."</option>\n";
			echo "<input id=selection_test_input type=\"submit\" value=\"Выбрать\">
	</div>\n
</form>";
echo "<p>Вопросы без выбранных вариантов ответа считаются неправильным ответом.</p>";
}

echo "<ol class=test_list>";
$correct = 0;
$qn = 0;

/* Вывод описания теста */
$test_description = mysql_query($query_test_description);
while ($row = mysql_fetch_array($test_description)) {
echo "<p>".$row['description']."</p>";
$tnumber = $row['tid'];
}

$delay = 0;
/* Цикл вывода данных из базы вопросов выбранного теста */
while ($row = mysql_fetch_array($res_test_questions)) {
	$qn++;
	echo "<div class=\"animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\">";
	$delay = $delay + 0.5;
	
	echo "<form action=results.php name=to_results method=post target=info>\n";
    echo "<li class=questions>".$row['question']."</li>\n";
	
    echo "<input id='1q_label".$qn."' class=selected_variant type=radio value=1 name=\"q".$qn."\">
	<label class=designated_variant for='1q_label".$qn."'>
	".$row['variant1'].";
	<br>\n
	</label>";
	
    echo "<input id='2q_label".$qn."' class=selected_variant type=radio value=2 name=\"q".$qn."\">
	<label class=designated_variant for='2q_label".$qn."'>
	".$row['variant2'].";
	<br>\n
	</label>";
	
    echo "<input id='3q_label".$qn."' class=selected_variant type=radio value=3 name=\"q".$qn."\">
	<label class=designated_variant for='3q_label".$qn."'>
	".$row['variant3'].";
	<br>\n
	</label>";
	
    echo "<input id='4q_label".$qn."' class=selected_variant type=radio value=4 name=\"q".$qn."\">
	<label class=designated_variant for='4q_label".$qn."'>
	".$row['variant4'].".
	<br>\n
	</label>";	
	
	echo $qa;
	echo "<hr>";
	echo "</div>\n";
}

/* Вывести кнопку перехода к результатам теста, если какой-либо тест был выбран */
if ($qn <> 0) {
echo "<input class=hidden type=text name=tid value=".$tnumber.">";
echo '<input class="results_input animated bounceInUp" type=submit method=post value=Результаты></form>';
}

echo "</ol>";

/* Закрываем соединение */
mysql_close();

/* Частично реализовано с использованием сведений сайта www.html.by: http://www.html.by/threads/986-Urok-prakticheskogo-primenenija-PHP-MySQL */
/* $copy Romanov S.S. */

echo "</div>";
?>