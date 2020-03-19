<?php
ini_set("display_errors", "off");
header("Content-type: text/html; charset=utf-8");
$url='http://39.108.6.204/twj/test/gaoBingFa/2.php';
$num=10;
// $connomains = array(
// 'http://localhost/concurrent/client_1.php',
// );
$mh = curl_multi_init();
//$connomains as $i => $url
for ($i=0; $i<=$num; $i++) {
    $conn[$i]=curl_init($url);
    curl_setopt($conn[$i],CURLOPT_RETURNTRANSFER,1);
    curl_multi_add_handle ($mh,$conn[$i]);
}
do { $n=curl_multi_exec($mh,$active); } while ($active);
for ($i=0; $i<=$num; $i++) {
    $res[$i]=curl_multi_getcontent($conn[$i]);
    curl_close($conn[$i]);
}
echo "<pre>";
print_r($res);
echo "</pre>";

