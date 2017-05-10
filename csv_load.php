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
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $row++;
        $b_id = $dbh->prepare("SELECT id FROM browsers WHERE descr=:descr");
        $b_id->execute(array('descr'=>$data[1]))->fetchColumn();
        $o_id = $dbh->prepare("SELECT id FROM operation_systems WHERE descr=:os_descr");
        $o_id->execute(array('os_descr'=>$data[2]))->fetchColumn();
        $sql = "INSERT INTO user_systems (ip_address,browser_id,operation_system_id) VALUES('".$data[0]."', ".$b_id.", ". $o_id.")";
        $dbh->query($sql);
    }
    fclose($handle);
}
$row = 1;
if (($handle = fopen("log_urls.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $row++;
        $sql_id = $dbh->prepare("SELECT id FROM user_systems WHERE ip_address=:ip_address");
        $sql_id->execute(array('ip_address'=>$data[2]))->fetchColumn();

        $sql = "INSERT INTO user_entrances (user_system_id,entrance_datatime,prev_url,entrance_url) VALUES(".$id.", '"
            .$data[0]." ".$data[1]."','".$data[3]."','".$data[4]."')";
        $dbh->query($sql);
    }
    fclose($handle);
}
$res_sql = "SELECT us.ip_address AS ip_address, br.descr AS browser, os.descr AS operation_system,
() AS
 FROM user_systems us JOIN browsers br ON br.id=us.browser_id JOIN operation_systems os ON os.id=us.operation_system_id";
$dbh = null;