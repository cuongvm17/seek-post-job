<?php namespace Seek\Token\Store;

/**
 * Store interface
 */
interface StoreInterface
{
    /**
     * Set token
     *
     * @param string $token
     * @param int $expiry
     * @return bool
     */
    public function set($token, $expiry);

    /**
     * @return string|null
     */
    public function get();

    /**
     * Expire token
     * @return bool
     */
    public function expire();
}
