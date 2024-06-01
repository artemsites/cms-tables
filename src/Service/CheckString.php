<?php

namespace App\Service;

class CheckString
{
    public function isLink($str): bool
    {
        return (substr($str, 0, 8) === 'https://' || substr($str, 0, 7) === 'http://');
    }
}