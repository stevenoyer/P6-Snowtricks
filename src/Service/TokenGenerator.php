<?php

namespace App\Service;

date_default_timezone_set('Europe/Paris');

class TokenGenerator
{

    /**
     * Generate a token by e-mail at the current time and return a string encoded in sha1
     */
    public function generate(string $email): string
    {
        return sha1($email . time());
    }

    /**
     * Calculating the expiry time of a token
     */
    public function getExpiration(int $hour = 3): string
    {
        $exp = time() + ($hour * 3600);
        return (string) $exp;
    }
}
