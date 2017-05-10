<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 09.05.17
 * Time: 16:28
 * EndTime: 17:10
 */
$ips = array();
$ip_start = '192.168.';
for ($i=0; $i<20; $i++){
    $x = rand(0,19);
    $y = rand(0,9);
    $ips[] = $ip_start . $x . '.' . $y;
}
$ips = array_unique($ips);
$clients = array('Opera', 'Mozilla Firefox','IE9','IE10','IE11','Chrome');
$os = array('widows7', 'widows8', 'widows10', 'linux');
$file = fopen('log_ip.csv', 'w');
foreach ($ips as $ip){
    $fields = array($ip, $clients[array_rand($clients)], $os[array_rand($os)]);
    fputcsv($file, $fields, ";");
}
fclose($file);
$file_urls = fopen('log_urls.csv', 'w');
$urls = array('url_1', 'url_2', 'url_3', 'url_4', 'url_5', 'url_6', 'url_7', 'url_8', 'url_9', 'url_10', 'url_11');
for($j=0; $j<100;$j++){
    $url_fields = array('2017-04-30', rand(10,24) . ':' . rand(10,60) . ':' . rand(10,60), $ips[array_rand($ips)], $urls[array_rand($urls)], $urls[array_rand($urls)]);
    fputcsv($file_urls, $url_fields, ";");
}
fclose($file_urls);
echo ('files ready');