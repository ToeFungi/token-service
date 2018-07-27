<?php namespace ToeFungi\Token\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;

use ToeFungi\Token\TokenService;
use ToeFungi\Token\LcobucciToken;

class TokenServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TokenService::class, function () {
            $token = new Token();
            $signer = new Sha256();
            $keychain = new Keychain();
            $data = new ValidationData();

            $tokenAud = getenv('TOKEN_AUD') ?: '';
            $tokenIss = getenv('TOKEN_ISS') ?: '';

            $data->setIssuer($tokenIss);
            $data->setAudience($tokenAud);

            return new LcobucciToken($data, $signer, $keychain, $token);
        });
    }
}
