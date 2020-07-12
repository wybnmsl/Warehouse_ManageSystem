<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

$data = $_GET;

try {
  $object = new PDO($dsn,$user,$pass);
  $time = $data['table'][0];
  $name = $data['table'][1];
  $description = $data['table'][2];
  $leader = $data['table'][3];
  $estimate = $data['table'][4];
  $actual = $data['table'][5];
  $status = $data['table'][6];
  $type = $data['table'][7];
  $timechoose = $data['table'][8];
  $depositorychoose = $data['table'][9];
  $sql ="DELETE FROM `gather`.`projecttable` WHERE (`time` = '{$time}')";
  $result = $object->query($sql);
  $sql ="INSERT INTO `gather`.`projecttable` VALUES ('{$time}', '{$name}', '{$description}','{$leader}', {$estimate},{$actual}, '{$status}','{$type}','{$timechoose}','{$depositorychoose}')";
  $result = $object->query($sql);
  $dbh = null;
  echo json_encode($result);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
