<?php
echo ("
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
	<link rel=\"stylesheet\" href=\"../css/mainstyle.css\">
    <title>Тест</title>
	<meta charset=\"UTF-8\">
</head>
<body>
<div class=box3>
");

$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "root"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "usbw"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "fortest"; // название базы данных
$table_questions = "question";
$table_tests = "tests";

if(isset($_POST['tid']))
$tid = $_POST['tid'];
$final_score = 0;

mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
mysql_select_db($dbName) or die (mysql_error());

$query_test_questions = "SELECT * FROM $table_questions WHERE tid = $tid";
$query_tests = "SELECT title, tid, description, min_for_5, min_for_4, min_for_3, min_for_2, min_for_1 FROM $table_tests WHERE tid = $tid";
mysql_query("SET NAMES 'utf8'"); /* Указание кодировки для извлекаемых запросами данных */

 /* SQL-запросы */
$res_test_questions = mysql_query($query_test_questions);
$res_test = mysql_query($query_tests);

$qn = 0;
$qa = '';

/* Вывод названия (поле title) теста */
$row = mysql_fetch_array($res_test);
echo "<h1>".$row['title']."</h1>\n";
echo "<h1>Результаты прохождения теста</h1>";
echo "<ol class=test_list>";

/* Получение последовательности правильных вариантов на ответы */
/* Заполнение массива с баллами за правильные/неправильные ответы */
while ($row = mysql_fetch_array($res_test_questions)) {
	$qn++;
	echo "<form action=results.php name=to_results method=post target=info>\n";
	if ($row['correct'] == 'variant1') {$qa .= 1; $right_answers[$qn] = 1;}
	if ($row['correct'] == 'variant2') {$qa .= 2; $right_answers[$qn] = 2;}
	if ($row['correct'] == 'variant3') {$qa .= 3; $right_answers[$qn] = 3;}
	if ($row['correct'] == 'variant4') {$qa .= 4; $right_answers[$qn] = 4;}
	$yes_value[$qn] = $row['yes_value'];
	$no_value[$qn] = $row['no_value'];
}

echo 
$user_answers = '';
$delay = 0;
$sum = 0;
for ($i=1; $i <= $qn; $i++)
if(isset($_POST['q'.$i])) { /* Если переменная идентифицирована, т.е. не NULL */
	$user_answers .= $_POST['q'.$i];
	$delay += 0.1;
	if ($qa[$i-1] == $_POST['q'.$i]) {$sum += $yes_value[$i]; echo "<div class=\"animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\">(+".$yes_value[$i].") балл(ов,а) за верный вариант ответа на вопрос № ".$i.";</div>\n";}
	if ($qa[$i-1] <> $_POST['q'.$i]) {$sum += $no_value[$i]; echo "<div class=\"animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\">(".$no_value[$i].") балл(ов,а) за неверный вариант ответа на вопрос № ".$i.";</div>\n";}
	} 
	else {
	$user_answers .= 0;
	$delay += 0.1;
	echo "<div class=\"animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\">Не выбран вариант ответа на ".$i." вопрос!</div>\n";
	}
	
$delay += 0.2;
echo "\n<div class=\"questions animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\"><hr>Итоговое кол-во баллов (правильных ответов): ".$sum.".</div>";

$res_test_questions = mysql_query($query_tests);
$res_test = mysql_query($query_tests);
$row = mysql_fetch_array($res_test);

if ($sum >= $row['min_for_2']) $final_score = 2;
if ($sum >= $row['min_for_3']) $final_score = 3;
if ($sum >= $row['min_for_4']) $final_score = 4;
if ($sum >= $row['min_for_5']) $final_score = 5;

$delay += 0.2;
echo "<div class=\"questions animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\">Ваша оценка: ".$final_score.".<hr></div>";

$i = 0;
$qn = 0;

$res_test_questions = mysql_query($query_test_questions);
while ($row = mysql_fetch_array($res_test_questions)) {
	$qn++;
	$i++;
	if ($user_answers[$i-1] <> '0')
	{
	echo "<div class=\"animated fadeInUp\" style=\"-webkit-animation-delay: ".$delay."s; -o-animation-delay: ".$delay."s; -moz-animation-delay: ".$delay."s; animation-delay: ".$delay."s;\">";
	$delay = $delay + 0.5;	
	
    echo "<span class=questions>".$qn.". ".$row['question']."</span>\n";
	echo "<ol class=variants type=a>";
		
		if ($user_answers[$i-1] == 1) {
		if ($user_answers[$i-1] == $right_answers[$i]) echo "<li class=right_variant>".$row['variant1'].";</li>\n";	
		else echo "<li class=wrong_variant>".$row['variant1'].";</li>\n";
		}
		else echo "<li>".$row['variant1'].";</li>\n";

		if ($user_answers[$i-1] == 2) {
		if ($user_answers[$i-1] == $right_answers[$i]) echo "<li class=right_variant>".$row['variant2'].";</li>\n";	
		else echo "<li class=wrong_variant>".$row['variant2'].";</li>\n";
		}
		else echo "<li>".$row['variant2'].";</li>\n";
		
		if ($user_answers[$i-1] == 3) {
		if ($user_answers[$i-1] == $right_answers[$i]) echo "<li class=right_variant>".$row['variant3'].";</li>\n";	
		else echo "<li class=wrong_variant>".$row['variant3'].";</li>\n";
		}
		else echo "<li>".$row['variant3'].";</li>\n";
		
		if ($user_answers[$i-1] == 4) {
		if ($user_answers[$i-1] == $right_answers[$i]) echo "<li class=right_variant>".$row['variant4'].".</li>\n";	
		else echo "<li class=wrong_variant>".$row['variant4'].".</li>\n";
		}
		else echo "<li>".$row['variant4'].".</li>\n";
		
	echo "</ol>";
	echo "<hr>";
	echo "</div>\n";
	}
}

$i = 1;

/* Закрываем соединение */
mysql_close();

/* Выражается благодарность сайту www.html.by: http://www.html.by/threads/986-Urok-prakticheskogo-primenenija-PHP-MySQL */
/* $copy Romanov S.S. */
	
?>