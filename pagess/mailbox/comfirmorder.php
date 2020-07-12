<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";


$data = $_GET;

$ans['success'] = $data['id'];

try {
  $object = new PDO($dsn,$user,$pass);
  $sql="UPDATE ordertable SET flag = '1' WHERE (time = {$data['id']})";
  $result = $object->query($sql);
  $dbh = null;
} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}

echo json_encode($result);

?>
