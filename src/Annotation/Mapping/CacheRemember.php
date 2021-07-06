<?php
/**
 * Class CacheRemember
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Costalong\Swoft\Cache\Annotation\Mapping;

/**
 * Class CacheRemember
 *
 * @Annotation
 * @Target("METHOD")
 * @Attributes({
 *     @Attribute("key", type="string"),
 *     @Attribute("ttl", type="int"),
 *     @Attribute("putListener", type="string"),
 *     @Attribute("clearListener", type="string"),
 * })
 *
 * @since 2.0
 */

final class CacheRemember
{
    /**
     * @var string
     */
    private $key = '';
    /**
     * @var int
     */
    private $ttl = -1;
    /**
     * @var string
     */
    private $putListener = '';
    /**
     * @var string
     */
    private $clearListener = '';
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
        if (isset($values['ttl'])) {
            $this->ttl = (int)$values['ttl'];
        }
        if (isset($values['putListener'])) {
            $this->putListener = $values['putListener'];
        }
        if (isset($values['clearListener'])) {
            $this->clearListener = $values['clearListener'];
        }
    }

    /**
     * @return string
     */
    public function getPutListener(): string
    {
        return $this->putListener;
    }

    /**
     * @return string
     */
    public function getClearListener(): string
    {
        return $this->clearListener;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }
}
