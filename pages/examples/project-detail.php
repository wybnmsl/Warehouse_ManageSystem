<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

$data = $_GET;

$table = array();

function cut($temp){
  $ans = array();
  $cnt = 0;
  for($i=0;$i<strlen($temp);$i=$i+2){
    if($temp[$i] == 1){
      $ans[$cnt] = true;
    }
    else{
      $ans[$cnt] = false;
    }
    $cnt++;
  }
  return $ans;
};

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
    $temp['time choose'] = $arr[8];
    $temp['depository choose'] = $arr[9];
    $table[$arr[0]] = $temp;
  }

  $dbh = null;
//  echo json_encode($table);
  $information['time'] = $table[$data['value']]['time'];
  $information['name'] = $table[$data['value']]['name'];
  $information['description'] = explode(',',$table[$data['value']]['description']);
  $information['leader'] = $table[$data['value']]['leader'];
  $information['estimate'] = $table[$data['value']]['estimate'];
  $information['actual'] = $table[$data['value']]['actual'];
  $information['status'] = $table[$data['value']]['status'];
  $information['type'] = $table[$data['value']]['type'];
  $information['time choose'] = $table[$data['value']]['time choose'];
  $information['depository choose'] = $table[$data['value']]['depository choose'];

  echo json_encode($information);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
