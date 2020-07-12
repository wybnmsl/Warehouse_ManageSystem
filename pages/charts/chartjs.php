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
  $temp = array();
  $temp['A'] = array();
  $temp['B'] = array();
  $temp['C'] = array();
  $temp['D'] = array();

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
      $temp[$des][$j] = null;
    }
  }

  while($arr=$result->fetch()){
    $temp[$arr[1]][$arr[2]] = $arr[3];
  }
  $table['origin'] = $temp;


  $sql="select * from dcTable";
  $result = $object->query($sql);
  $stra = array();
  $stra['time'] = '00000000000000';
  $stra['detail'] = [0,0,0,0,0,0,0,0,0,0,0,0];
  $strb = array();
  $strb['time'] = '00000000000000';
  $strb['detail'] = [0,0,0,0,0,0,0,0,0,0,0,0];
  $strc = array();
  $strc['time'] = '00000000000000';
  $strc['detail'] = [0,0,0,0,0,0,0,0,0,0,0,0];
  $strd = array();
  $strd['time'] = '00000000000000';
  $strd['detail'] = [0,0,0,0,0,0,0,0,0,0,0,0];
  while($arr=$result->fetch()){
    if($arr[2] == 'A'){
      if($arr[0]>$stra['time']){
        $stra['time'] = $arr[0];
        $stra['name'] = $arr[1];
        for($i = 0;$i < 12;$i++){
          $stra['detail'][$i] = $arr[3+$i];
        }
      }

    }
    else if($arr[2] == 'B'){
      if($arr[0]>$strb['time']){
        $strb['time'] = $arr[0];
        $strb['name'] = $arr[1];
        for($i = 0;$i < 12;$i++){
          $strb['detail'][$i] = $arr[3+$i];
        }
      }

    }
    else if($arr[2] == 'C'){
      if($arr[0]>$strc['time']){
        $strc['time'] = $arr[0];
        $strc['name'] = $arr[1];
        for($i = 0;$i < 12;$i++){
          $strc['detail'][$i] = $arr[3+$i];
        }
      }

    }
    else if($arr[2] == 'D'){
      if($arr[0]>$strd['time']){
        $strd['time'] = $arr[0];
        $strd['name'] = $arr[1];
        for($i = 0;$i < 12;$i++){
          $strd['detail'][$i] = $arr[3+$i];
        }
      }

    }
  }//end of while

  $dbh = null;

  for($i=1;$i<=4;$i++){
    $des = null;
    $str = null;
    if($i==1){
      $des = 'A';
      $str = $stra;
    }
    else if($i==2){
      $des = 'B';
      $str = $strb;
    }
    else if($i==3){
      $des = 'C';
      $str = $strc;
    }
    else if($i==4){
      $des = 'D';
      $str = $strd;
    }
    for($j=1;$j<=12;$j++){
      if($temp[$des][$j]!=null){
        $temp[$des][$j] = $temp[$des][$j] + $str['detail'][$j-1];
      }
    }
    $table['now'] = $temp;
    $table[$des]['time'] = $str['time'];
    $table[$des]['name'] = $str['name'];


  }


  echo json_encode($table);
} catch (PDOException $e) {
  die ("Error!: " . $e->getMessage() . "<br/>");
}

?>
