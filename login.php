<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

$data = $_GET;
$ans = null;

$object = new PDO($dsn,$user,$pass,array(PDO::ATTR_PERSISTENT => true));//建立长连接
$sql="select * from uesrTable";
$result = $object->query($sql);
$userlist = array();
while($arr=$result->fetch()) {
  $userlist[$arr[0]] = $arr[1];
}

$dbh = null;

if($userlist[$data['email']] == $data['password']){
  $ans['judge'] = true;
  echo json_encode($ans);
}
else{
  $ans['judge'] = false;
  echo json_encode($ans);
}

?>
