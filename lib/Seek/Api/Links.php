<?php namespace Seek\Api;

/**
 * Links end point
 */
class Links extends ApiAbstract
{
    /**
     * @return array
     */
    public function retrieve()
    {
        return $this->get('/');
    }
}
