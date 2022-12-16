<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;

/**
 * @group Admin Authentication Module
 */
class AuthController extends Controller
{
    use AuthenticationTrait;
}
