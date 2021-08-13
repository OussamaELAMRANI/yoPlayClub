<?php

namespace App\Services;

class AppService
{
    public function __invoke(int $i)
    {
        return max($i);
    }
}
