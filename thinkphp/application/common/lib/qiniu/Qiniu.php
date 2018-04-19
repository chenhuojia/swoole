<?php
namespace app\common\lib\qiniu;
require_once driname(APP_PATH) . '/vendor/qiniu/php-sdk/autoload.php';
class Qiniu{
    /**
     * 实例化对象
     * @var unknown
     */
    private static $instance = null;
    
    /**
     * Oss 对象
     * @var unknown
     */
    private $ossClient;
    
    /**
     * 单一入口
     * @return \app\common\lib\ali\Oss
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * 私有构造函数
     */
    private function __construct()
    {
        try {
            $this->ossClient = new OssClient(config('aliyunOss.accessKeyId'), config('aliyunOss.accessKeySecret'), config('aliyunOss.endpoint'));
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }
}