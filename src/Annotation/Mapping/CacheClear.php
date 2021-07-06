<?php declare(strict_types=1);
/**
 * like Cache::clear()
 */

/**
 * Class CacheClear
 * author:costalong
 * Email:longqiuhong@163.com
 */
namespace Costalong\Swoft\Cache\Annotation\Mapping;
use Costalong\Swoft\Cache\Cache;
use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class CacheClear
 * @package Costalong\Swoft\Cache\Annotation\Mapping
 * @Annotation
 * @Target("METHOD")
 * @Attributes({
 *     @Attribute("key", type="string"),
 *     @Attribute("position", type="string"),
 * })
 *
 */
final class CacheClear
{
    /**
     * @var string
     */
    private $key = '';
    /**
     * @var string
     */
    private $position = Cache::ASP_AFTER;

    /**
     * Entity constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->key = $values['value'];
        } elseif (isset($values['key'])) {
            $this->key = $values['key'];
        }
        if (isset($values['position'])) {
            $this->position = $values['position'];
        }
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }
}
