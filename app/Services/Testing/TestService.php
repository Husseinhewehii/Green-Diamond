<?php

namespace App\Services\Testing;

use App\Models\Tag;

class TestService
{
    public function greet($name)
    {
        dump('hxsi');
        return "Hello $name from mock";
    }

}
