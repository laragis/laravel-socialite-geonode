<?php
namespace TungTT\LaravelSocialiteGeoNode;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'GEONODE';

    /**
     * The GeoNode instance host.
     *
     * @var string
     */
    protected string $host;

    /**
     * Get the GeoNode instance host.
     *
     * @return $this
     */
    public function getHost()
    {
        return $this->host ?? env('GEONODE_URL');
    }

    /**
     * Set the GeoNode instance host.
     *
     * @param  string|null  $host
     * @return $this
     */
    public function setHost($host)
    {
        if (! empty($host)) {
            $this->host = rtrim($host, '/');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getHost().'/o/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return $this->getHost().'/o/token/';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post($this->getHost().'/api/o/v4/tokeninfo', [
            RequestOptions::FORM_PARAMS => ['token' => $token],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'    => $user['user_id'],
            'nickname' => $user['username'],
            'name'  => $user['username'],
            'email' => $user['email'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}
