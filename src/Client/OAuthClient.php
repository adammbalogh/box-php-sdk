<?php namespace AdammBalogh\Box\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\ResponseInterface;
use AdammBalogh\KeyValueStore\KeyValueStore;
use GuzzleHttp\Exception\ClientException;
use AdammBalogh\Box\Exception\ExitException;
use AdammBalogh\Box\Exception\OAuthException;
use AdammBalogh\KeyValueStore\Exception\KeyNotFoundException;

/**
 * @see http://developers.box.com/oauth
 */
class OAuthClient extends GuzzleClient
{
    const AUTHORIZE_URI = 'https://app.box.com/api/oauth2/authorize';
    const TOKEN_URI = 'https://app.box.com/api/oauth2/token';
    const REVOKE_TOKEN_URI = 'https://www.box.com/api/oauth2/revoke';

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
    private $redirectUri;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $refreshToken;

    /**
     * @var KeyValueStore
     */
    private $kvs;

    /**
     * @param KeyValueStore $kvs
     * @param string  $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     */
    public function __construct(KeyValueStore $kvs, $clientId, $clientSecret, $redirectUri)
    {
        $this->kvs = $kvs;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;

        parent::__construct();
    }

    /**
     * @return string access token
     *
     * @throws ExitException
     * @throws ClientException
     * @throws OAuthException
     */
    public function authorize()
    {
        try {
            $this->setPropertiesBasedOnSuccessResponse([
                'access_token' => $this->kvs->get('access_token'),
                'refresh_token' => $this->kvs->get('refresh_token')
            ]);
        } catch (KeyNotFoundException $e) {
            $this->refreshToken();
        }

        if ($this->hasErrorQueryField()) {

            $this->throwOAuthException();

        } elseif (!$this->hasAccessToken() && !$this->hasCodeQueryField()) {

            $this->getCode();

        } elseif (!$this->hasAccessToken() && $this->hasCodeQueryField()) {

            $this->getToken();

        }

        return $this->accessToken;
    }

    /**
     * @throws OAuthException
     * @throws \Exception
     */
    public function revokeTokens()
    {
        try {
            $this->setPropertiesBasedOnSuccessResponse([
                'access_token' => $this->kvs->get('access_token'),
                'refresh_token' => $this->kvs->get('refresh_token')
            ]);
        } catch (KeyNotFoundException $e) {
            throw new \Exception('Cannot retrieve Access Token');
        }

        /* @var ResponseInterface $response */
        $response = $this->post(self::REVOKE_TOKEN_URI, [
            'body' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'token' => $this->accessToken
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            try {
                $this->kvs->delete('access_token');
                $this->kvs->delete('refresh_token');

                $this->accessToken = $this->refreshToken = null;
            } catch (KeyNotFoundException $e) {
            }
            return;
        }

        $response = $response->json();
        throw new OAuthException("{$response['error']}:{$response['error_description']}");
    }

    /**
     * @return bool
     */
    public function hasAccessToken()
    {
        return !is_null($this->accessToken);
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return bool
     */
    public function isAccessTokenExpired()
    {
        try {
            $this->kvs->get('access_token');
        } catch (KeyNotFoundException $e) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isRefreshTokenExpired()
    {
        try {
            $this->kvs->get('refresh_token');
        } catch (KeyNotFoundException $e) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     *
     * @throws KeyNotFoundException
     */
    public function getAccessTokenTtl()
    {
        return $this->kvs->getTtl('access_token');
    }

    /**
     * Authorize - First step
     *
     * @throws ExitException
     */
    protected function getCode()
    {
        $queryData = [
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri
        ];

        header('Location: ' . self::AUTHORIZE_URI . '?' . http_build_query($queryData));
        throw new ExitException();
    }

    /**
     * Authorize - Second step
     *
     * @throws ClientException e.g. on a Bad Request. The authorization code is only valid for 30 seconds.
     * @throws OAuthException
     */
    protected function getToken()
    {
        /* @var ResponseInterface $response */
        $response = $this->post(self::TOKEN_URI, [
            'body' => [
                'grant_type' => 'authorization_code',
                'code' => $this->getCodeQueryField(),
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $this->setPropertiesBasedOnSuccessResponse($response->json());

            return;
        }

        $response = $response->json();
        throw new OAuthException("{$response['error']}:{$response['error_description']}");
    }

    /**
     * @throws ClientException e.g. on a Bad Request. The refresh token is valid for 60 days.
     * @throws OAuthException
     */
    protected function refreshToken()
    {
        if ($this->isAccessTokenExpired() && !$this->isRefreshTokenExpired()) {
            /* @var ResponseInterface $response */
            $response = $this->post(self::TOKEN_URI, [
                'body' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->kvs->get('refresh_token'),
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $this->setPropertiesBasedOnSuccessResponse($response->json());
                return;
            }

            $response = $response->json();
            throw new OAuthException("{$response['error']}:{$response['error_description']}");
        }
    }

    /**
     * @param array $response
     */
    protected function setPropertiesBasedOnSuccessResponse(array $response)
    {
        $this->accessToken = $response['access_token'];
        $this->refreshToken = $response['refresh_token'];

        if (array_key_exists('expires_in', $response)) {
            $this->kvs->set('access_token', $this->accessToken);
            $this->kvs->set('refresh_token', $this->refreshToken);

            $this->kvs->expire('access_token', (int)$response['expires_in']);
            $this->kvs->expire('refresh_token', 5184000); # 60 days
        }
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     *
     * @return bool
     */
    protected function hasCodeQueryField()
    {
        return array_key_exists('code', $_GET);
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     *
     * @return string|null
     */
    protected function getCodeQueryField()
    {
        return array_key_exists('code', $_GET) ? $_GET['code'] : null;
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     *
     * @return bool
     */
    protected function hasErrorQueryField()
    {
        return array_key_exists('error', $_GET);
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     *
     * @throws OAuthException
     */
    protected function throwOAuthException()
    {
        throw new OAuthException("{$_GET['error']}:{$_GET['error_description']}");
    }
}
