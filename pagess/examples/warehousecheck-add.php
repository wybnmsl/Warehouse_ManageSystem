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
  $depository = $data['table'][2];
  $shelf1 =  $data['table'][3];
  $shelf2 =  $data['table'][4];
  $shelf3 =  $data['table'][5];
  $shelf4 =  $data['table'][6];
  $shelf5 =  $data['table'][7];
  $shelf6 =  $data['table'][8];
  $shelf7 =  $data['table'][9];
  $shelf8 =  $data['table'][10];
  $shelf9 =  $data['table'][11];
  $shelf10 =  $data['table'][12];
  $shelf11 =  $data['table'][13];
  $shelf12 =  $data['table'][14];
  $sql ="INSERT INTO `gather`.`dctable` VALUES ('{$time}', '{$name}', '{$depository}',{$shelf1},{$shelf2},{$shelf3},{$shelf4},{$shelf5},{$shelf6},{$shelf7},{$shelf8},{$shelf8},{$shelf10},{$shelf11},{$shelf12})";
  $result = $object->query($sql);
  $dbh = null;
  echo json_encode($result);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
