<?php 

namespace App\Service;

date_default_timezone_set('Europe/Paris');

class TokenGenerator
{

    public function generate(string $email): string
    {
        return sha1($email . time());
    }

    public function getExpiration(int $hour = 3): string
    {
        $exp = time() + ($hour * 3600);
        return (string) $exp;
    }
}
