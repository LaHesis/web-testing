<?php
 
/* Соединяемся с базой данных */
$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "root"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "usbw"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "fortest"; // название базы данных
 
/* Таблица MySQL, в которой хранятся данные */
$table = "test_table";
 
/* Создаем соединение */
mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
 
/* Если была нажата кнопка редактирования, вносим изменения */
if(@$submit_edit) {
$query = "UPDATE '$dbName'.'$table' SET 'name'='$test_name', 'email'='$test_mail', 'theme'='$test_theme', 'message'='$test_mess' WHERE '$table'.'id'='$update'";
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
mysql_query($query) or die (mysql_error());
}
 
/* Заносим в переменную $res всю базу данных */
$query = "SELECT * FROM $table";
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
/* Узнаем количество записей в базе данных */
$row = mysql_num_rows($res);
 
/* Выводим данные из таблицы */
echo ("
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
 
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <title>Редактирование и обновление данных</title>
<style type=\"text/css\">
body { font: 12px Georgia; color: #666; }
h3 { font-size: 16px; text-align: center; }
table { width: 400px; border-collapse: collapse; margin: 5px auto; background: #E6E6E6; }
td { padding: 3px; vertical-align: middle; }
input { width: 250px; border: solid 1px #CCC; color: #FF6666; }
textarea { width: 250px; height: 100px; border: solid 1px #CCC; color: #FF6666; }
.buttons { width: auto; border: double 1px #666; background: #D6D6D6; color: #000; }
#num { width: 20px; text-align: right; margin-right: 5px; float: right; }
</style>
</head>
<body>
<h3>Редактирование и обновление данных в таблице MySQL</h3>
");
 
/* Цикл вывода данных из базы конкретных полей */
while ($row = mysql_fetch_array($res)) {
    echo "<form action=\"update_data.php\" method=\"post\" name=\"edit_form\">\n";
    echo "<input name=\"update\" value=\"".$row["id"]."\" />\n";
    echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "<tr>\n";
    echo "<td colspan=\"2\" style=\"border-bottom:solid 1px #CCCCCC;\"><b><i><div id=\"num\">#".$row["id"]."</div>".$row['data']."</b></i></td>\n";
    echo "</tr><tr>\n";
    echo "<td>Имя пользователя:</td><td><input type=\"text\" value=\"".$row['name']."\" name=\"test_name\" /></td>\n";
    echo "</tr><tr>\n";
    echo "<td>E-Mail пользователя:</td><td><input type=\"text\" value=\"".$row['email']."\" name=\"test_mail\" /></td>\n";
    echo "</tr><tr>\n";
    echo "<td>Тема сообщения:</td><td><input type=\"text\" value=\"".$row['theme']."\" name=\"test_theme\" /></td>\n";
    echo "</tr><tr>\n";
    echo "<td>Сообщение:</td><td><textarea name=\"test_mess\">".$row['message']."</textarea></td>\n";
    echo "</tr><tr>\n";
    echo "<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"submit_edit\" class=\"buttons\" value=\"Сохранить изменения\" /></td>\n";
    echo "</tr></table></form>\n\n";
}
 
/* Закрываем соединение */
mysql_close();
 
/* Выводим ссылку возврата */
echo ("<div style=\"text-align: center; margin-top: 10px;\"><a href=../index_php_mysql.html>Вернуться назад</a></div>");

/* Источник: http://www.html.by/threads/986-Urok-prakticheskogo-primenenija-PHP-MySQL */

 
?>