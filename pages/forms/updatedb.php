<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";


$data = $_GET;


function getname(){
  $str = null;
  for($i = 1; $i <=8 ;$i++){
    $x = rand(1,4);
    if($x == 2){
      $a = rand(48,57);
      $str = $str.chr($a);
    }
    else{
      $b = rand(65,90);
      $str = $str.chr($b);
    }
  }
  return $str;
}


try {
  $object = new PDO($dsn,$user,$pass);
  $cnt = $data['cnt'];
  $username = $data['temparray'][0];
  $useraddress = $data['temparray'][1];
  $time = $data['temparray'][2];
  $clothid = "";
  $clothflag = "";
  $clothamount = "";
  for($i=1;$i<$cnt;$i++){
    $clothid = $clothid.(string)$data['temparray'][3][$i].",";
    $clothflag= $clothflag."0".",";
    $clothamount = $clothamount.(string)$data['temparray'][4][$i].",";
  }
  $clothid = $clothid.(string)$data['temparray'][3][$cnt];
  $clothflag= $clothflag."0";
  $clothamount = $clothamount.(string)$data['temparray'][4][$cnt];
  $flag = "false";
  $ordername = getname();
//  $sql="UPDATE ordertable SET flag = '1' WHERE (time = {$data['id']})";
  $sql ="INSERT INTO `gather`.`ordertable` VALUES ('{$time}', '{$cnt}', '{$clothid}','{$clothflag}', '{$clothamount}','{$username}', '{$useraddress}',{$flag},'{$ordername}')";
  $result = $object->query($sql);
  $Message = $object->errorCode();
  $dbh = null;
} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}

$Message = 'success';
echo json_encode($Message);

?>
