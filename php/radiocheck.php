<?php
echo ("
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
	<link rel=\"stylesheet\" href=\"../css/mainstyle.css\">
    <title>Тест</title>
	<meta charset=\"ansi\">
</head>
<body>
<div class=box3>
");

if(isset($_POST['radioselector'])) { 
    echo "Значение отмеченной радио-кнопки: ".$_POST['radioselector']; 
} else { 
    echo "Ни одна радио-кнопка не отмечена !"; 
    echo "<form action='ip.php' method='post'> 
    <input type='Radio' name='radioselector' checked id='R1' value='value1'> 
    <label for='R1'>Радио-кнопка 1</label><br> 
    <input type='Radio' name='radioselector' id='R2' value='value1'> 
    <label for='R2'>Радио-кнопка 2</label><br> 
    <input type='Submit' value='Отправить'> 
    </form>"; 
} 
?> 