<?php namespace Seek\Token\Store;

use Predis\Client as PredisClient;

/**
 * Predis token store class
 */
class Predis implements StoreInterface
{
    /**
     * @var PredisClient
     */
    protected $predisClient;

    /**
     * @var string
     */
    protected $keyName;

    /**
     * @param PredisClient $predisClient
     * @param string $keyName
     */
    public function __construct(PredisClient $predisClient, $keyName = 'tokenKeyName')
    {
        $this->predisClient = $predisClient;
        $this->keyName = $keyName;
    }

    /**
     * Set token
     *
     * @param string $token
     * @param int $expiry
     * @return bool
     */
    public function set($token, $expiry = 3600)
    {
        return (bool)$this->predisClient->setex($this->keyName, $expiry, $token);
    }

    /**
     * @return string|null
     */
    public function get()
    {
        return $this->predisClient->get($this->keyName);
    }

    /**
     * Expire token
     * @return bool
     */
    public function expire()
    {
        return (bool)$this->predisClient->del([$this->keyName]);
    }
}
