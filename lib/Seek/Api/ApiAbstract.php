<?php namespace Seek\Api;

use Seek\Client;
use Seek\HttpClient\Utilities\Response;

/**
 * Api abstract class.
 */
abstract class ApiAbstract implements ApiInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $path
     * @param array $parameters
     * @param array $headers
     * @return mixed
     */
    protected function get($path, array $parameters = [], array $headers = [])
    {
        if (count($parameters) > 0) {
            $path .= '?' . http_build_query($parameters);
        }
        $this->checkAuthenticationToken();
        return Response::getContent($this->client->getHttpClient()->get($path, $headers));
    }

    /**
     * @param $path
     * @param array $data
     * @param array $requestHeaders
     * @return mixed
     */
    protected function post($path, array $data = [], array $requestHeaders = [])
    {
        $this->checkAuthenticationToken();
        return Response::getContent(
            $this->client->getHttpClient()->post(
                $path,
                $this->adjustRequestHeaders($requestHeaders),
                json_encode($data)
            )
        );
    }

    /**
     * @param $path
     * @param array $data
     * @param array $requestHeaders
     * @return mixed
     */
    protected function put($path, array $data = [], array $requestHeaders = [])
    {
        $this->checkAuthenticationToken();
        return Response::getContent(
            $this->client->getHttpClient()->put(
                $path,
                $this->adjustRequestHeaders($requestHeaders),
                json_encode($data)
            )
        );
    }

    /**
     * @param $path
     * @param array $data
     * @param array $requestHeaders
     * @return mixed
     */
    protected function patch($path, array $data = [], array $requestHeaders = [])
    {
        $this->checkAuthenticationToken();
        return Response::getContent(
            $this->client->getHttpClient()->patch(
                $path,
                $this->adjustRequestHeaders($requestHeaders),
                json_encode($data)
            )
        );
    }

    /**
     * Get new token if required before making a call
     */
    protected function checkAuthenticationToken()
    {
        if (get_class($this) != 'Seek\Api\Authorisation') {
            $this->client->checkAuthenticationToken();
        }
    }

    /**
     * @param array $requestHeaders
     * @return array
     */
    private function adjustRequestHeaders(array $requestHeaders)
    {
        if (empty($requestHeaders['Content-Type'])) {
            $requestHeaders['Content-Type'] = 'application/json';
        }

        return $requestHeaders;
    }
}
