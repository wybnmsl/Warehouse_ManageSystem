<?php
/**
 *  单例模式
 **/

$data = $_GET;

class Db
{
  //保存全局实例
  private static $instance;
  //数据库连接句柄
  private $db;
  //数据库连接参数
  const HOSTNAME = "localhost";
  const USERNAME = "root";
  const PASSWORD = "wang2200158";
  const DBNAME = "gather";
  //私有化构造函数，防止外界实例化对象
  private function __construct()
  {
    $this->db = mysqli_connect(self::HOSTNAME,self::USERNAME,
      self::PASSWORD,self::DBNAME);
  }
  //私有化克隆函数，防止外界克隆对象
  private function __clone()
  {
  }
  //单例访问统一入口
  public static function getInstance()
  {
    if(!(self::$instance instanceof self))
    {
      self::$instance = new self();
    }
    return self::$instance;
  }
  //数据库查询操作
  public function getinfo($email)
  {
    $sql="select * from uesrTable WHERE username = '{$email}'";
    $res = mysqli_query($this->db,$sql);
    while($row = mysqli_fetch_array($res)) {
      echo $row['password'] ;
    }
    mysqli_free_result($res);
  }
}

$mysql = Db::getInstance();
$mysql->getinfo($data['email']);
?>
