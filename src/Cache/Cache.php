<?php

namespace Tongues\Cache;


use Tongues\Interfaces\Cache\ArrayAccessCache;

class Cache implements ArrayAccessCache
{
    /**
     * @var \WP_Object_Cache
     */
    protected $wpCache;

    /**
     * @var string
     */
    protected $group;

    /**
     * Cache constructor.
     * @param \WP_Object_Cache $wpCache
     * @param string $group
     */
    public function __construct(\WP_Object_Cache $wpCache, $group = 'tongues')
    {
        $this->wpCache = $wpCache;
        $this->group = $group;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        $this->wpCache->get($offset, $this->group, false, $found);

        return $found !== false;
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->wpCache->get($offset, $this->group);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->wpCache->set($offset, $value, $this->group, 0);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->wpCache->delete($offset, $this->group);
    }
}