<?php namespace ToeFungi\Token;

interface TokenService
{
    /**
     * Generate a JWT token with specified payload
     *
     * @param array $args
     * @return String
     */
    public function generateToken(array $args = []): String;

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
}