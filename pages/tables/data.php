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
    $sql="select * from originTable";
    $result = $object->query($sql);
    while($arr=$result->fetch()){
      $temp=array();
      $temp['id'] = $arr[0];
      $temp['depository'] = $arr[1];
      $temp['shelf'] = $arr[2];
      $temp['amount'] = $arr[3];
      $temp['flag'] = $arr[4];
      $table[$arr[0]] = $temp;
    }
    $dbh = null;
    echo json_encode($table);
  } catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
  }

return $table;

?>
