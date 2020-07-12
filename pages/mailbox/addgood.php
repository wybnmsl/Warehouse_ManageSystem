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

$ans = array();

try {
  $object = new PDO($dsn,$user,$pass);
  $sql="select * from returnordertable WHERE (time = {$data['id']})";
  $result = $object->query($sql);
  $arr=$result->fetch();{
    $temp=array();
    $temp['time'] = $arr[0];
    $temp['orderamount'] = $arr[1];
    $temp['orderid'] = $arr[2];
    //$temp['orderflag'] = $arr[3];
    $temp['returnreason'] = $arr[3];
    $temp['goodamount'] = $arr[4];
    $temp['orderer'] = $arr[5];
    $temp['address'] = $arr[6];
    $temp['flag'] = $arr[7];
    $table[$arr[0]] = $temp;
  }
  $goodamount = explode(',',$table[$data['id']]['goodamount'],$table[$data['id']]['orderamount']);
  $orderid = explode(',',$table[$data['id']]['orderid'],$table[$data['id']]['orderamount']);

  $ans['orderid'] = $orderid;
  $ans['goodamount'] = $goodamount;

  $sql="UPDATE returnordertable SET flag = true WHERE time = '{$data['id']}'"; //写入数据库
  $object->query($sql);

  $flag = true;

  for($i=0;$i<$table[$data['id']]['orderamount'];$i++){
    $sql="select * from origintable WHERE id = '{$orderid[$i]}'";
    $result = $object->query($sql);
    while($arr=$result->fetch()) {
      $temp = array();
      $temp['id'] = $arr[0];
      $temp['depository'] = $arr[1];
      $temp['shelf'] = $arr[2];
      $temp['amount'] = $arr[3];
      $temp['flag'] = $arr[4];

      $temp['amount'] = $temp['amount'] + $goodamount[$i];

      $ans[$i] = $temp['amount'];
      $temp['amount'] = intval($temp['amount']);
      $sql="UPDATE origintable SET amount = {$temp['amount']} WHERE id = '{$orderid[$i]}'"; //写入数据库
      $object->query($sql);
    }


    }

  echo json_encode($ans);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
