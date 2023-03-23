<?php namespace Seek\Token\Store;

/**
 * File token store class
 */
class File implements StoreInterface
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @param string
     */
    public function __construct($filePath = '/tmp/api-token')
    {
        $this->filePath = $filePath;
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
        return (bool)file_put_contents(
            $this->filePath,
            json_encode(
                [
                    'token'  => $token,
                    'expiry' => time() + $expiry,
                ]
            )
        );
    }

    /**
     * @return string
     */
    public function get()
    {
        if (file_exists($this->filePath)) {
            $content = file_get_contents($this->filePath);
            if ($content) {
                $data = json_decode($content, true);
                if ((int)$data['expiry'] > time()) {
                    return $data['token'];
                }
            }
        }
        return null;
    }

    /**
     * Expire token
     * @return bool
     */
    public function expire()
    {
        return (bool)file_put_contents($this->filePath, '');
    }
}
