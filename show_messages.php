<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 25.10.17
 * Time: 14:43
 * Выводим данные из файла guest_book.xml для отрисовки дерева сообщений
 */
$xml = simplexml_load_file('guest_book.xml');
$result = array();
foreach($xml->message as $el){
    if(isset($el->id)){
        $id = (string)$el->id;
        $result[] = [
            'id' => (string)$el->id,
            'parent_id' => (string)$el->parent_id,
            'time' => date('d.m.Y H:i:s',(string)$el->time),
            'body' => (string)$el->body,
            'author' => (string)$el->author,
        ];
    }
}
echo json_encode(array('message_list' => $result));