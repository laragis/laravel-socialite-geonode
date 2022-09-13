# Adobe
```bash
composer require ttungbmt/laravel-socialite-geonode
```

## Installation & Basic Usage
Please see the [Base Installation Guide](https://socialiteproviders.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`
```php
'geonode' => [    
  'client_id' => env('GEONODE_CLIENT_ID'),  
  'client_secret' => env('GEONODE_CLIENT_SECRET'),  
  'redirect' => env('GEONODE_REDIRECT_URI'),
],
```

### Add provider event listener
Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.
```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \SocialiteProviders\GeoNode\GeoNodeExtendSocialite::class.'@handle',
    ],
];
```

### Usage
You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('geonode')->redirect();
```

### Returned User fields
These fields may differ with different scopes

- ``id``
- ``name``
- ``email``
