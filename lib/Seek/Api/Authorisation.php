<?php namespace Seek\Api;

/**
 * Authorisation end point
 */
class Authorisation extends ApiAbstract
{
    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $grantType
     * @return array
     */
    public function retrieveAccessToken($clientId, $clientSecret, $grantType)
    {
        return $this->post(
            '/auth/oauth2/token?' . http_build_query(
                [
                    'client_id'     => $clientId,
                    'client_secret' => $clientSecret,
                    'grant_type'    => $grantType,
                ]
            )
        );
    }
}
