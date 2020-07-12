<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";


$data = $_GET;

function getamount($string){
  $cnt = 1;
  for($i = 0;$i < strlen($string);$i++){
    if($string[$i] == ','){
      $cnt++;
    }
  }
  return $cnt;
}

function getordrrflag($cnt){
  $orderflag = null;
  for($i = 1;$i < $cnt;$i++){
    $orderflag= $orderflag."0".",";
  }
  return $orderflag;
}

$ans;

try {
  $object = new PDO($dsn,$user,$pass);
  $cnt = $data['cnt'];
  for($i=1;$i<$cnt;$i++){
    $time = $data['data'][$i][1];
    $orderamout =getamount($data['data'][$i][4]);
    $clothid = $data['data'][$i][3];
    $orderflag= getordrrflag($orderamout);
    $goodamount = $data['data'][$i][4];
    $orderer = $data['data'][$i][5];
    $address = $data['data'][$i][5];
    $flag = "false";
    $ordername = $data['data'][$i][2];

//    $sql ="INSERT INTO `gather`.`ordertable` VALUES ('{$time}', '{$cnt}', '{$clothid}','{$clothflag}', '{$clothamount}','{$username}', '{$useraddress}',{$flag})";
 //   $result = $object->query($sql);

    $ans[$i]['time'] = $time;
    $ans[$i]['orderamout'] = $orderamout;
    $ans[$i]['clothid'] = $clothid;
    $ans[$i]['orderflag'] = $orderflag;
    $ans[$i]['goodamount'] = $goodamount;
    $ans[$i]['address'] = $address;
    $ans[$i]['flag'] = $flag;
    $ans[$i]['ordername'] = $ordername;

  }


  $dbh = null;
} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


echo json_encode($ans);

?>
