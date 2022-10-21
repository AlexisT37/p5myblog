<?php

require_once('dotenv.php');

use Dotenv\DotEnv;



class JWT
{
    public function generate(array $header, array $payload, string $secret, int $validity = 86400): string
    {
        (new DotEnv("../.env"))->load();

        $SECRET = getenv('SECRET');

        if ($validity > 0) {
            $now = new Datetime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }


        $base64header = base64_encode(json_encode($header));
        $base64payload = base64_encode(json_encode($payload));

        //+, / and = are not supported
        //remove wrong char
        $base64header = str_replace(["+", "/", "="], ["-", "_", ""], $base64header);
        $base64payload = str_replace(["+", "/", "="], ["-", "_", ""], $base64payload);

        //signature
        $secret = base64_encode($SECRET);

        //+, / and = are not supported
        //make token
        $signature = hash_hmac('sha256', $base64header . '.' . $base64payload, $secret, true);
        $base64signature = base64_encode($signature);
        $signature = str_replace(["+", "/", "="], ["-", "_", ""], $base64signature);

        $jwt = $base64header . '.' . $base64payload . '.' . $signature;
        return $jwt;
    }

    public function check(string $token, string $secret): bool
    {
        //get header and payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        //genereate token that will be matched against this
        //time 0 because already have iat and exp
        $verifToken = $this->generate($header, $payload, $secret, 0);
        $validToken = ($token === $verifToken);
        return $validToken;
    }

    public function getHeader(string $token): array
    {
        //explode the token
        $array = explode('.', $token);
        //decode the header
        $header = json_decode(base64_decode($array[0]), true);
        return $header;
    }

    public function getPayload(string $token): array
    {
        //explode the token
        $array = explode('.', $token);
        //decode the header
        $payload = json_decode(base64_decode($array[1]), true);
        return $payload;
    }

    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);
        $now = new DateTime();
        return $payload['exp'] < $now->getTimestamp();
    }

    public function isValid(string $token): bool
    {
        //the regular expression checks for specifc characters, the dots are present in the jwt, the + separates for the regex
        return preg_match('/^[a-zA-Z0-9\-\_\=]+.[a-zA-Z0-9\-\_\=]+.[a-zA-Z0-9\-\_\=]+$/', $token) === 1;
    }

    public function isAdmin(string $token): bool
    {
        $adminJWTCheckPayload = $this->getPayload($token);
        $adminJWTRoles = $adminJWTCheckPayload['roles'];
        $adminJWTSlot = $adminJWTRoles[0];
        $adminInJWT = !(strpos($adminJWTSlot, 'ROLE_ADMIN') === false);
        return ($adminInJWT === true);
    }
}
