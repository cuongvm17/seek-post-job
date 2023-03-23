<?php namespace Seek;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Seek\Api\EndPointInterface;
use Seek\HttpClient\Plugins\Authentication;
use Seek\HttpClient\Plugins\ExceptionHandler;
use Seek\Token\Store\File as TokenFileStore;
use Seek\Token\Store\StoreInterface as TokenStoreInterface;

/**
 * PHP seek.com.au ad posting API client library.
 *
 * @method Api\Authorisation authorisation()
 * @method Api\Links links()
 * @method Api\Advertisement advertisement()
 *
 * Website: https://github.com/alagafonov/php-seek-job-ad-posting-api
 */
class Client
{
    /**
     * @var string
     */
    protected $apiUrl = 'https://adposting.cloud.seek.com.au';

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var TokenStoreInterface
     */
    private $tokenStore;

    /**
     * @var Plugin[]
     */
    private $plugins = [];

    /**
     * @var PluginClient
     */
    private $pluginClient;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var bool
     */
    private $createNewHttpClient = true;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $grantType;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $grantType
     * @param TokenStoreInterface|null $tokenStore
     * @param HttpClient|null $httpClient
     */
    public function __construct(
        $clientId,
        $clientSecret,
        $grantType = 'client_credentials',
        TokenStoreInterface $tokenStore = null,
        HttpClient $httpClient = null
    ) {
        $this->setAuthenticationDetails($clientId, $clientSecret, $grantType);
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->setTokenStore($tokenStore ?: new TokenFileStore());
        $this->messageFactory = MessageFactoryDiscovery::find();
        $this->addPlugin(new Plugin\AddHostPlugin(UriFactoryDiscovery::find()->createUri($this->apiUrl)));
        $this->addPlugin(new ExceptionHandler());
    }

    /**
     * @param $name
     * @return Api\Authorisation|Api\Links|Api\Advertisement
     * @throws UnknownMethodException
     */
    public function api($name)
    {
        switch ($name) {
            case 'authorisation':
                $api = new Api\Authorisation($this);
                break;
            case 'links':
                $api = new Api\Links($this);
                break;
            case 'advertisement':
                $api = new Api\Advertisement($this);
                break;
            default:
                throw new UnknownMethodException('Undefined end point instance called: "' . $name . '"');
        }
        return $api;
    }

    /**
     * @param $name
     * @param $args
     * @return Api\Advertisement
     * @throws UnknownMethodException
     */
    public function __call($name, $args)
    {
        return $this->api($name);
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->removePlugin(Authentication::class);
        $this->addPlugin(new Authentication($accessToken));
    }

    /**
     * Performs token expiry check and re-authentication
     */
    public function checkAuthenticationToken()
    {
        $tokenStore = $this->getTokenStore();
        $accessToken = $tokenStore->get();
        if ($accessToken === null) {
            // Need to acquire new token.
            $response = $this->authorisation()->retrieveAccessToken(
                $this->clientId,
                $this->clientSecret,
                $this->grantType
            );
            $tokenStore->set(
                $response['access_token'],
                $response['expires_in'] > 300 ? $response['expires_in'] - 300 : $response['expires_in']
            );
            $this->setAccessToken($response['access_token']);
        } else {
            if (!$this->hasPlugin(Authentication::class)) {
                $this->setAccessToken($accessToken);
            }
        }
    }

    /**
     * @param Plugin $plugin
     */
    public function addPlugin(Plugin $plugin)
    {
        $this->plugins[get_class($plugin)] = $plugin;
        $this->createNewHttpClient = true;
    }

    /**
     * @param $name
     */
    public function removePlugin($name)
    {
        unset($this->plugins[$name]);
        $this->createNewHttpClient = true;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasPlugin($name)
    {
        return isset($this->plugins[$name]);
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
    {
        if ($this->createNewHttpClient) {
            $this->createNewHttpClient = false;
            $this->pluginClient = new HttpMethodsClient(
                new PluginClient($this->httpClient, $this->plugins),
                $this->messageFactory
            );
        }
        return $this->pluginClient;
    }

    /**
     * @param HttpClient $httpClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->createNewHttpClient = true;
        $this->httpClient = $httpClient;
    }

    /**
     * @return TokenStoreInterface
     */
    public function getTokenStore()
    {
        return $this->tokenStore;
    }

    /**
     * @param TokenStoreInterface $tokenStore
     */
    public function setTokenStore(TokenStoreInterface $tokenStore)
    {
        $this->tokenStore = $tokenStore;
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $grantType
     */
    protected function setAuthenticationDetails($clientId, $clientSecret, $grantType)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->grantType = $grantType;
    }
}
