<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 09.05.17
 * Time: 21:16
 */
$user = 'root';
$pass = '13021962';
$dbh = new PDO('mysql:host=localhost;dbname=kohana_test', $user, $pass);
$row = 1;
if (($handle = fopen("log_ip.csv", "r")) !== FALSE) {
    $b_id = $dbh->prepare("SELECT id FROM browsers WHERE descr=:descr");
    $o_id = $dbh->prepare("SELECT id FROM operation_systems WHERE descr=:os_descr");
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $row++;
        $b_id->execute(array('descr'=>$data[1]));
        $result_1 = $b_id->fetchColumn();
        $o_id->execute(array('os_descr'=>$data[2]));
        $result_2 = $o_id->fetchColumn();
        $sql = "INSERT INTO user_systems (ip_address,browser_id,operation_system_id) VALUES('".$data[0]."', ".$result_1.", ". $result_2.")";
        $dbh->query($sql);
    }
    fclose($handle);
}
$row = 1;
if (($handle = fopen("log_urls.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $row++;
        $sql_id = $dbh->prepare("SELECT id FROM user_systems WHERE ip_address=:ip_address");
        $sql_id->execute(array('ip_address'=>$data[2]));
        $result = $sql_id->fetchColumn();
        $sql = "INSERT INTO user_entrances (user_system_id,entrance_datatime,prev_url,entrance_url) VALUES(".$result.", '"
            .$data[0]." ".$data[1]."','".$data[3]."','".$data[4]."')";
        $dbh->query($sql);
    }
    fclose($handle);
}
$res_sql = "SELECT us.ip_address AS ip_address, br.descr AS browser, os.descr AS operation_system,
(SELECT ue.prev_url FROM user_entrances ue WHERE ue.user_system_id=us.id ORDER BY ue.entrance_datatime ASC LIMIT 1) AS first_prev_url,
(SELECT ue.entrance_url FROM user_entrances ue WHERE ue.user_system_id=us.id ORDER BY ue.entrance_datatime DESC LIMIT 1) AS last_entrance_url,
(SELECT COUNT(DISTINCT ue.entrance_url) FROM user_entrances ue WHERE ue.user_system_id=us.id) AS count_urls,
  (SELECT MIN(ue.entrance_datatime) FROM user_entrances ue WHERE ue.user_system_id=us.id) AS start_dt,
 (SELECT MAX(ue.entrance_datatime) FROM user_entrances ue WHERE ue.user_system_id=us.id) AS end_dt,
 ( SELECT UNIX_TIMESTAMP(end_dt)) AS end_s,
 ( SELECT UNIX_TIMESTAMP(start_dt)) AS start_s,
  (SELECT SEC_TO_TIME(end_s - start_s)) AS interv
 FROM user_systems us JOIN browsers br ON br.id=us.browser_id JOIN operation_systems os ON os.id=us.operation_system_id";
$res = $dbh->query($res_sql);
$table_data = $res->fetchAll();
$dbh = null;
?>
<table>
    <tr>
        <th>
            IP-адрес
        </th>
        <th>
            Браузер
        </th>
        <th>
            ОС
        </th>
        <th>
            URL с которого пользователь зашел первый раз
        </th>
        <th>
            URL на который пользователь зашел последний раз
        </th>
        <th>
            Количество просмотренных уникальных URL-адресов
        </th>
        <th>
            Время, прошедшее с первого до последнего входа.
        </th>
    </tr>
    <?php foreach($table_data as $row): ?>
    <tr>
        <td>
            <?=$row['ip_address']; ?>
        </td>
        <td>
            <?=$row['browser']; ?>
        </td>
        <td>
            <?=$row['operation_system']; ?>
        </td>
        <td>
            <?=$row['first_prev_url']; ?>
        </td>
        <td>
            <?=$row['last_entrance_url']; ?>
        </td>
        <td>
            <?=$row['count_urls']; ?>
        </td>
        <td>
            <?=$row['interv']; ?>
        </td>
        <?php endforeach; ?>
    </tr>
</table>
