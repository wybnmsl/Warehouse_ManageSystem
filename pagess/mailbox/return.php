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
  $sql="select * from returnorderTable";
  $result = $object->query($sql);
  while($arr=$result->fetch()){
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

  $sql="select * from originTable";
  $result = $object->query($sql);
  while($arr=$result->fetch()){
    $temp=array();
    $temp['id'] = $arr[0];
    $temp['depository'] = $arr[1];
    $temp['shelf'] = $arr[2];
    $temp['amount'] = $arr[3];
    $temp['flag'] = $arr[4];
    $origintable [$arr[0]] = $temp;
  }

  $dbh = null;
//  echo json_encode($table);
  $information['address'] = $table[$data['value']]['address'];
  $information['orderer'] = $table[$data['value']]['orderer'];
  $information['orderamount'] = $table[$data['value']]['orderamount'];
  $information['returnreason'] = $table[$data['value']]['returnreason'];
  $information['flag'] = $table[$data['value']]['flag'];
  $orderid = explode(',',$table[$data['value']]['orderid'],$table[$data['value']]['orderamount']);
  $goodamount = explode(',',$table[$data['value']]['goodamount'],$table[$data['value']]['orderamount']);
  //$orderflag = cut($table[$data['value']]['orderflag']);
  $orderiddepository = null;
  $orderidshelf = null;
  for($i=0;$i<$table[$data['value']]['orderamount'];$i++){
    $orderiddepository[$i] = $origintable[$orderid[$i]]['depository'];
    $orderidshelf[$i] = $origintable[$orderid[$i]]['shelf'];
  }

  $ans['information'] =  $information;
  $ans['orderid'] =  $orderid;
  $ans['orderiddepository'] =  $orderiddepository;
  $ans['orderidshelf'] =  $orderidshelf;
  $ans['goodamount'] =  $goodamount;
  //$ans['orderflag'] =  $orderflag;

  echo json_encode($ans);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
