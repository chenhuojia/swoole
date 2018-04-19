<?php
class IO{
    
    public function __construct(){
        
    }
    
    /**
     * 异步读取文件 file_get_contents()
     * ***/
    public function readFile($file){
        swoole_async_readfile(__DIR__.DIRECTORY_SEPARATOR.$file, function($filename, $content) {
            echo "$filename: $content";
        });
    }
    
    /**
     * 异步写入文件
     * @return unknown
     * ***/
    public function writeFile(){
        $file_content=date("Y-m-d H:i:s").PHP_EOL;
        $filename='test.log';
        swoole_async_writefile($filename, $file_content, function($filename) {
            echo "wirte ok.\n";
        }, FILE_APPEND);
       return $filename;
    }
}
$io=new IO();
$file=$io->writeFile();
//echo $file;
$io->readFile($file);