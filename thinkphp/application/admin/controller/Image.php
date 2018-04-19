<?php
/**
* 后台上传 文件
* @date: 2018年4月17日
* @author: chj
* @version: version
*/

namespace app\admin\controller;
use think\Controller;
use app\common\lib\ali\Oss;
use think\Request;
use app\common\lib\Util;
use think\Loader;



class Image extends Controller{
    
    /**
     * aliyun OSS存储 上传文件
     * @param Request $request
     * @return NULL
     */
    public function fileupload(){
        return APP_PATH . '/../vendor/qiniu/php-sdk/autoload.php';
       /*  $file=$_FILES['file'];
        $fileinfo=Oss::getInstance()->uploadFile($file);
        if ($fileinfo) return Util::show(config('code.success'),'ok',$fileinfo);
        return Util::show(config('code.error'),'error'); */
    }
}