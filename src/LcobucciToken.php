<?php namespace ToeFungi\Token;

use Exception;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class LcobucciToken implements TokenService
{
    protected $auth, $data, $signer, $keychain, $token;

    public function __construct(ValidationData $data, Sha256 $signer, Keychain $keychain, Token $token)
    {
        $this->data = $data;
        $this->signer = $signer;
        $this->keychain = $keychain;
        $this->token = $token;
    }

    public function generateToken(array $args = null): String
    {
        $token = (new Builder())
            ->setIssuer(getenv('TOKEN_ISS'))
            ->setAudience(getenv('TOKEN_AUD'))
            ->setIssuedAt(time())
            ->setExpiration(time() + (int) getenv('TOKEN_LIFESPAN'));

        if (!is_null($args)) {
            foreach ($args as $key => $value) {
                $token->set($key, $value);
            }
        }

        return $token->sign($this->signer, $this->keychain->getPrivateKey(getenv('TOKEN_PRIV_KEY')))->getToken();
    }

    public function validateToken(string $bearerToken = null): Bool
    {
        if (is_null($bearerToken)) {
            return false;
        }

        try {
            $this->token = (new Parser())->parse($bearerToken);
        } catch (Exception $exception) {
            return false;
        }

        if(!$this->token->verify($this->signer, $this->keychain->getPublicKey(getenv('TOKEN_PUB_KEY'))))
            return false;

        if(!$this->token->validate($this->data))
            return false;

        return true;
    }

    public function getClaim(string $key): String
    {
        return $this->token->getClaim($key);
    }
}
