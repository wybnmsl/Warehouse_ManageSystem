<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='gather';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='wang2200158';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";


$data = $_GET;

$ans[0] = 'success';
$cnnt=1;

try {
  $object = new PDO($dsn,$user,$pass);
  for($i=0;$i<$data['cnt'];$i++){
    $clothid = $data['excel'][$i]['新到产品ID'];
    $clothamount = $data['excel'][$i]['新到产品数量'];
    $sql = "select * from origintable WHERE (id = '{$clothid}')";
    $result = $object->query($sql);
    $temp = $result->fetch();
    if($temp == false){
     // $ans++;
      for($j=1;$j<=4;$j++){
        $depository;
        if($j==1){
          $depository = 'A';
        }
        if($j==2){
          $depository = 'B';
        }
        if($j==3){
          $depository = 'C';
        }
        if($j==4){
          $depository = 'D';
        }
        for($k=1;$k<=12;$k++){
          $sql = "select * from origintable WHERE (depository= '{$depository}' AND shelf = '{$k}')";
          $result = $object->query($sql);
          $flag = true;
           if($result->fetch() == false){
             $sql ="INSERT INTO `origintable` VALUES ('{$clothid}', '{$depository}', '{$k}','{$clothamount}','{$flag}')";
             $result = $object->query($sql);
           }
        }
      }
    }
    else{
      $sql = "select amount from origintable WHERE (id = '{$clothid}')";
      $result = $object->query($sql);
      $now=$result->fetch();
      $nowamount = $now['amount'];
      $ans[$cnnt++]=$nowamount;
      $clothamount=$nowamount+$clothamount;
      $amount = intval($clothamount);
      $sql="UPDATE origintable SET amount = {$amount} WHERE (id = '{$clothid}')";
      $result = $object->query($sql);
      $ans[$cnnt++]=$result->fetch();
    }
  }

//  $sql="UPDATE ordertable SET flag = '1' WHERE (time = {$data['id']})";
 // $sql ="INSERT INTO `gather`.`ordertable` VALUES ('{$time}', '{$cnt}', '{$clothid}','{$clothflag}', '{$clothamount}','{$username}', '{$useraddress}',{$flag})";
 // $result = $object->query($sql);
  $dbh = null;
} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}


echo json_encode($ans);

?>
