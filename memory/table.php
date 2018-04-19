<?php
class Table{
    
    const SIZE=1024;
    
    public function __construct(){
        
        $table=new swoole_table(self::SIZE);
        
        $this->create($table);
        $this->set($table);
        $data=$this->get($table);
        print_r($data);
    }
    
    
    public function  create($table){
        $table->column('id',swoole_table::TYPE_INT,4);
        $table->column('name',swoole_table::TYPE_STRING,64);
        $table->column('num',swoole_table::TYPE_FLOAT);
        $table->create();
    }
    
    public function set($table){
        $table->set('chjdwl',['id'=>1,'name'=>'chjdwl','num'=>12]);
    }
    
    public function get($table){
        return $table->get('chjdwl');
    }
    
    public function incr(object $table,string $key, string $column, mixed $incrby = 1){
        return $table->incr($key,$column,$incrby);
    }
    
    public function decr(object $table,string $key, string $column, mixed $decrby = 1){
        return $table->incr($key,$column,$decrby);
    }
    
    public function del($table,$key){
        return $table->del($key);
    }
    
    public function exist($table,$key){
        return $table->exist($key);
    }
}

(new Table());