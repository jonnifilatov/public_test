<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 24.10.17
 * Time: 22:23
 * Создаём файл нужного формата с корневым элементом, если его ещё нет.
 * Принимаем данные из аякса и, в зависимости от значения идентификатора, либо добавляем запись, либо правим ранее добавленную.
 * Возвращаем на клиент данные в удобной для отрисовки изменений форме.
 */
if(!file_exists('guest_book.xml')){
    $str = '<?xml version="1.0" encoding="utf-8"?><messages></messages>';

    $dom = new SimpleXMLElement($str);

    $dom->asXML('guest_book.xml');
}
$data_row = $_POST['data_row'];
if($data_row['id'] == ''){
    //add answer
    $xml = simplexml_load_file('guest_book.xml');
    $message_count = $xml->count();
    $data_row['id'] = 1 + $message_count;
    $data_row['time'] = time();
    $message = $xml->addChild('message');
    $message->addChild('author', $data_row['author']);
    $message->addChild('body', $data_row['body']);
    $message->addChild('time', $data_row['time']);
    $message->addChild('parent_id', $data_row['parent_id']);
    $message->addChild('id', $data_row['id']);
    $xml->asXML('guest_book.xml');
    $data_row['time'] = date('d.m.Y H:i:s',$data_row['time']);
    echo json_encode(array('added_message'=>$data_row));
}else{
    //edit message
    $xml = simplexml_load_file('guest_book.xml');
    foreach($xml->message as $el){
        if((string)$el->id == $data_row['id']){
            $el->body = $data_row['body'];
        }
    }
    $xml->asXML('guest_book.xml');

    echo json_encode(array('changed_message' => $data_row));
}
