<?php namespace ToeFungi\Token\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;

use ToeFungi\Token\TokenService;
use ToeFungi\Token\Lcobucci\LcobucciToken;

class TokenServiceProvider extends ServiceProvider
{
    /**
     * @var Token $token
     */
    protected $token;

    /**
     * @var Sha256 $signer
     */
    protected $signer;

    /**
     * @var Keychain $keychain
     */
    protected $keychain;

    /**
     * @var ValidationData $data
     */
    protected $data;

    /**
     * @param Token $token
     * @param Sha256 $signer
     * @param Keychain $keychain
     * @param ValidationData $data
     */
    public function boot(Token $token, Sha256 $signer, Keychain $keychain, ValidationData $data)
    {
        $this->data = $data;
        $this->token = $token;
        $this->signer = $signer;
        $this->keychain = $keychain;

        $this->app->singleton(TokenService::class, function () {
            $tokenAud = getenv('TOKEN_AUD') ?: '';
            $tokenIss = getenv('TOKEN_ISS') ?: '';

            $this->data->setIssuer($tokenIss);
            $this->data->setAudience($tokenAud);

            return new LcobucciToken($this->data, $this->signer, $this->keychain, $this->token);
        });
    }
}
