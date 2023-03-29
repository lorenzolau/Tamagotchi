<?php
class JWT
{
   
    public function generate( array $payload, string $secret, int $validity = 86400): string
    {
        if($validity > 0){
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }

        // On encode en base64
       
        $base64Payload = base64_encode(json_encode($payload));

        // On "nettoie" les valeurs encodées
        // On retire les +, / et =
       
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // On génère la signature
        $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // On crée le token
        $jwt = $base64Payload . '.' . $signature;

        return $jwt;
    }

 
    public function check(string $token, string $secret): bool
    {
        // On récupère le header et le payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // On génère un token de vérification
        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }


    public function getHeader(string $token)
    {
        // Démontage token
        $array = explode('.', $token);

        // On décode le header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    public function getPayload(string $token)
    {
        // Démontage token
        $array = explode('.', $token);

        // On décode le payload
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
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }
}