<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HttpController extends Controller
{
   
    public function testHttp2()
    {
        return response()->json();
    }

    public function testHttp4()
    {
        return response()->json();
    }
}
