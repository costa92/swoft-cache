<?php
/**
 * Class CoFileSystemTrait
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Concern;


use Swoft\Co;

/**
 * Trait CoFileSystemTrait
 * @package Costalong\Swoft\Cache\Concern
 */
trait CoFileSystemTrait
{
    /**
     * @return bool
     */
    public static function isSupported(): bool
    {
        return extension_loaded('swoole');
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function doRead(string $file): string
    {
        if (!file_exists($file)) {
            return '';
        }

        return Co::readFile($file);
    }

    /**
     * @param string $file
     * @param string $string
     *
     * @return bool
     */
    protected function doWrite(string $file, string $string): bool
    {
        return Co::writeFile($file, $string) !== false;
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected function doDelete(string $file): bool
    {
        return unlink($file);
    }

    public function incr($key){

    }
}
