# Fungi Token Service
Protect endpoints using JWT tokens for authentication

#### Register Service Provider
Register the service provider in the `bootstrap/app.php`
```php
$app->register(App\Providers\TokenServiceProvider::class);
```

#### Register Middleware
Register the middleware authentication layer in the `bootstrap/app.php`
```php
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
]);
```

#### Protected Endpoints
Example of an endpoint that is protected. Ensure it uses the `auth` middleware layer
```php
$app->get('/protected', [
    'middleware' => 'auth',
    'uses' => 'TokenController@protectedEndpoint'
]);
```
#### Environment Variables
Remember to set all of the below
```bash
TOKEN_ISS='http://youdomain.co.za'
TOKEN_AUDIENCE='http://yourdomain.co.za'
TOKEN_LIFESPAN=3600
TOKEN_PRIV_KEY=(RSA Key)
TOKEN_PUB_KEY=(RSA Key)
```
