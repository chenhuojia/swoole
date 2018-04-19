<?php
namespace app\common\lib;
class Util{
    
    public static function show($status=200,$message='',$data=[]){
        $data=[
            'status'=>$status,
            'message'=>$message,
            'data'=>$data,
        ];
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}