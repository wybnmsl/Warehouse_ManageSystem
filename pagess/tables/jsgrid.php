<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";
$data = $_GET;


$table = array();
$map = array();
$mapid = array();

for($i=1;$i<=4;$i++) {
  $des = null;
  if ($i == 1) {
    $des = 'A';
  } else if ($i == 2) {
    $des = 'B';
  } else if ($i == 3) {
    $des = 'C';
  } else if ($i == 4) {
    $des = 'D';
  }
  for ($j = 1; $j <= 12; $j++) {
    $map[$des][$j] = 0;
    $mapid = null;
  }
}


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
  $sql="select * from orderTable";
  $result = $object->query($sql);
  $cnt = 1;
  while($arr=$result->fetch()){
    $temp=array();
    $temp['time'] = $arr[0];
    $temp['orderamount'] = $arr[1];
    $temp['orderid'] = $arr[2];
    $temp['orderflag'] = $arr[3];
    $temp['goodamount'] = $arr[4];
    $temp['orderer'] = $arr[5];
    $temp['address'] = $arr[6];
    $temp['flag'] = $arr[7];
    if($temp['flag'] == true){
      continue;
    }
    $temp['ordername'] = $arr[8];
    $table[$cnt] = $temp;
    $cnt++;
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
    $mapid[$arr[1]][intval($arr[2])] = $arr[0];
    $origintable [$arr[0]] = $temp;
  }

  $dbh = null;
//  echo json_encode($table);

  $cnnt = 1;
  $queuesize = 0;

  for($i = 1;$i < $cnt;$i++){
    $information['address'] = $table[$i]['address'];
    $information['orderer'] = $table[$i]['orderer'];
    $information['orderamount'] = $table[$i]['orderamount'];
    $orderid = explode(',',$table[$i]['orderid'],$table[$i]['orderamount']);
    $goodamount = explode(',',$table[$i]['goodamount'],$table[$i]['orderamount']);
    $orderflag = cut($table[$i]['orderflag']);
    $orderiddepository = null;
    $orderidshelf = null;
    for($j=0;$j<$table[$i]['orderamount'];$j++){
      $orderiddepository[$j] = $origintable[$orderid[$j]]['depository'];
      $orderidshelf[$j] = $origintable[$orderid[$j]]['shelf'];
      $depository = $origintable[$orderid[$j]]['depository'];
      $shelf = intval($origintable[$orderid[$j]]['shelf']);
      $map[$depository][$shelf] =  $goodamount[$j] + 1;
      $queuesize++;
    }
    $ans[$cnnt]['information'] =  $information;
    $ans[$cnnt]['orderid'] =  $orderid;
    $ans[$cnnt]['orderiddepository'] =  $orderiddepository;
    $ans[$cnnt]['orderidshelf'] =  $orderidshelf;
    $ans[$cnnt]['goodamount'] =  $goodamount;
    $ans[$cnnt]['orderflag'] =  $orderflag;
    $cnnt++;
  }
  $ans['cnt'] = $cnnt-1;

 // dfs($map,$queuesize);
  $ans['map'] = $map;
  $ans['mapid'] = $mapid;

  echo json_encode($ans);
 // echo json_encode($map);

} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


?>
