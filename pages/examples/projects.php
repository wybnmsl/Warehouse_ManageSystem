<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

$table = array();
try {
  $object = new PDO($dsn,$user,$pass);
  $sql="select * from projecttable";
  $result = $object->query($sql);
  while($arr=$result->fetch()){
    $temp=array();
    $temp['time'] = $arr[0];
    $temp['name'] = $arr[1];
    $temp['description'] = $arr[2];
    $temp['leader'] = $arr[3];
    $temp['estimate'] = $arr[4];
    $temp['actual'] = $arr[5];
    $temp['status'] = $arr[6];
    $temp['type'] = $arr[7];
    $table[$arr[0]] = $temp;
  }
  $dbh = null;
  echo json_encode($table);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
