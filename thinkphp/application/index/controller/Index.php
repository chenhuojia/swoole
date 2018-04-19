<?php
namespace app\index\controller;


use think\Request;
use app\common\lib\ali\Sms;

class Index
{
    public function index()
    {
        return ;
    }

    public function index2()
    {
        return time().'dsdsd';
    }
    
    public function hello(Request $request ,$name = 'ThinkPHP5')
    {
        
        print_r($_POST);
        return 'hello,' . $name;
    }
    
    public function sms(){
        try {
            $sms=new Sms();
            $status=$sms->sendSms('13622742951',time());
        }catch (\Exception $e){
            return $e; 
        }
        dump($status);
    }
}
