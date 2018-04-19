<?php

class MysqlClient{
    
    public $mysql;
    public $db;
    public $config=[
        'host'=>'127.0.0.1',
        'port'=>'3306',
        'user'=>'root',
        'password'=>'123456',
        'database'=>'test',
        'charset'=>'utf8',
        'timeout'=>2,
    ];
    
    public function __construct(){
        $this->mysql=new swoole_mysql();
    }
    
    public function connent(){
        $this->mysql->connect($this->config,function($db,$result){
            $this->db=$db;
            if ($result===false) {
                var_dump($this->db->connect_error);
                die;
            }
            $sql='insert into test set name='."'快快快'".',create_time='.time();
            $db->query($sql,function($link,$result){
                if ($result==false){
                    var_dump($link->error);
                }elseif($result==true){
                    var_dump($result);
                }else{
                    var_dump($result);
                }
            });  
           $db->close();
        });
        return true;
    }
    
    
    public function update(){
        
    }
    
    public function insert(){
      $sql='insert into test set name='."'快快快'".',create_time='.time();
      $this->db->query($sql,function($link,$result){
          if ($result==false){
              var_dump($link->error);
          }elseif($result==true){
              var_dump($result);
          }else{
              var_dump($result);
          }
      });
    }
    
    
    public function delete(){
        
    }
     
}
$obj=new MysqlClient();
$obj->connent();