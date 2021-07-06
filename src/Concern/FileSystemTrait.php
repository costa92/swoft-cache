<?php
/**
 * Class FileSystemTrait
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\Cache\Concern;

use Swoft\Stdlib\Helper\Dir;

/**
 * Trait FileSystemTrait
 * @package Costalong\Swoft\Cache\Concern
 */
trait FileSystemTrait
{
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

        return (string)file_get_contents($file);
    }

    /**
     * @param string $file
     * @param string $data
     *
     * @return bool
     */
    protected function doWrite(string $file, string $data): bool
    {
        $cacheDir = dirname($file);
        if (!is_dir($cacheDir)) {
            Dir::make($cacheDir);
        }

        return file_put_contents($file, $data) !== false;
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

}
