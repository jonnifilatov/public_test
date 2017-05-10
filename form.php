<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 09.05.17
 * Time: 10:10
 */
header('Content-type: text/html; charset=utf-8');
?>
<html>
    <head>
        <title>Введите</title>
    </head>
    <body>
        <h2>Введите два множества целых чисел, разделённых любыми символами</h2>
        <form method="POST" action="/form_post.php">
            <textarea name="arr_1"></textarea><br/>
            <textarea name="arr_2"></textarea><br/>
            <input type="submit" value="Нажми меня" />
        </form>
    </body>
</html>