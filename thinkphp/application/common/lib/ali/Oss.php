<?php
/**
 * 阿里云Oss对象存储 文件
 * @date: 2018年4月17日
 * @author: chj
 * @version: version
 */
namespace app\common\lib\ali;

use OSS\OssClient;
use OSS\Core\OssException;

class Oss
{
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

    /**
     * 上传指定的本地文件内容
     * @param array $file 上传文件
     * @param string $bucket 存储空间名称
     * @return null
     */
    public function uploadFile(array $file, $bucket = null)
    {
        if (! $bucket) {
            $bucket = config('aliyunOss.bucket');
        }
        $filename = config('aliyunOss.live_dir').'/'.$this->createFileName($file['name']);
        try {
            $info = $this->ossClient->uploadFile($bucket, $filename, $file['tmp_name']);
        } catch (OssException $e) {
            printf($e->getMessage() . "\n");
            return;
        }
        return ['url'=>$info['info']['url'],'filename'=>$filename];
    }

    /**
     * 创建文件名
     * @param unknown $filename            
     * @return string
     */
    private function createFileName($filename)
    {
        $tmp = explode(' ', microtime());
        $second = mb_substr($tmp[0], 2);
        $time = $tmp[1];
        $ext = $this->getExt($filename);
        return $time . $second . '.' . $ext;
    }

    /**
     * 获取文件后缀
     * @param unknown $filename            
     * @return string|mixed
     */
    private function getExt($filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (! $ext) {
            $ext = 'png';
        }
        return $ext;
    }
}