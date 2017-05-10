<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 09.05.17
 * Time: 10:10
 * End_time: 11:13
 */
header('Content-type: text/html; charset=utf-8');
if (!empty($_POST['arr_1']) && !empty($_POST['arr_2'])) {
    $arr_1 = preg_split('/[^0-9]+/' ,$_POST['arr_1']);
    $arr_2 = preg_split('/[^0-9]+/' ,$_POST['arr_2']);
    if(count($arr_1) == 0 || count($arr_1) == 0){
        echo 'Одно из множеств не содержит ни одного элемента!';
    } else {
        $revers_1 = array_reverse($arr_1);
        shuffle($arr_1);
        $shuffle_1 = $arr_1;
        $interect = array_intersect($arr_1, $arr_2);
        $diff = array_merge(array_diff($arr_1,$arr_2), array_diff($arr_2,$arr_1));
        $product = array_product($arr_2);
        echo 'количество элементов в множестве 1 - ' . count($arr_1) . '<br/>';
        echo 'количество элементов в множестве 2 - ' . count($arr_2) . '<br/>';
        sort($arr_1);
        sort($arr_2);
        echo ('два отсортированных в выбранном порядке множества<br/>');
        echo ('Первое:  ' . implode(', ', $arr_1) . '<br/>');
        echo ('Второе:  ' . implode(', ', $arr_2) . '<br/>');
        echo ('максимальные и минимальные значение обоих множеств<br/>');
        echo ('min_1 - ' . $arr_1[0] . '; max_1 - ' . array_pop($arr_1) . '; min_2 - ' . $arr_2[0] . '; max_2 - ' . array_pop($arr_2) . '<br/>');
        echo ('пересечение множеств<br/>');
        echo (count($interect) > 0 ? implode(', ', $interect) . '<br/>' : 'Пересечение отсутствует <br/>');
        echo ('разницу множеств<br/>');
        echo (implode(', ', $diff) . '<br/>');
        echo ('первое множество в обратном порядке<br/>');
        echo (implode(', ', $revers_1) . '<br/>');
        echo ('произведение элементов второго множества<br/>');
        echo ($product . '<br/>');
        echo ('значения первого множества, перемешанные в случайном порядке<br/>');
        echo ( implode(', ', $shuffle_1) . '<br/>');
    }
} else {
    echo 'Вы ничего не написали!';
}

?>
<br />
<a href="/form.php"> попробовать еще разок </a>