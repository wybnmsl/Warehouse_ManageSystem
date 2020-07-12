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
  $sql="select * from returnorderTable";
  $result = $object->query($sql);
  while($arr=$result->fetch()){
    $temp=array();
    $temp['time'] = $arr[0];
    $temp['orderamount'] = $arr[1];
    $temp['orderid'] = $arr[2];
    $temp['returnreason'] = $arr[3];
    $temp['goodamount'] = $arr[4];
    $temp['orderer'] = $arr[5];
    $temp['address'] = $arr[6];
    $temp['flag'] = $arr[7];
    $table[$arr[0]] = $temp;
  }
  $dbh = null;
  echo json_encode($table);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
