<?php
namespace TungTT\LaravelSocialite\GeoNode;

use SocialiteProviders\Manager\SocialiteWasCalled;

class GeoNodeExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('geonode', Provider::class);
    }
}
