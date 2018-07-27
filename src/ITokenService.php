<?php namespace ToeFungi\Token;

interface ITokenService
{
    /**
     * Generate a JWT token with specified payload
     *
     * @param array $claims
     * @param array $headers
     * @return String
     */
    public function generateToken(array $claims = [], array $headers = []): String;

    /**
     * Validate a JWT token
     *
     * @param string|null $bearerToken
     * @return bool
     */
    public function validateToken(string $bearerToken = null): Bool;

    /**
     * Get a claim set on the token
     *
     * @param string $key
     * @return String
     */
    public function getClaim(string $key): String;

    /**
     * Get all claims from the token
     *
     * @return array
     */
    public function getClaims(): array;
}