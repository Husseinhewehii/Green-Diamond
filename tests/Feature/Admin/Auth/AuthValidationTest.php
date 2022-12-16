<?php

namespace Tests\Feature\Admin\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AuthValidationTest extends TestCase
{
    use RefreshDatabase, AuthTestingTrait;

    public function testAuthLoginValidateRequiredEmailEnglish()
    {
        $payLoad = ["email" => ""];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, "(email) field is required");
    }

    public function testAuthLoginValidateRequiredEmailArabic()
    {
        App::setLocale('ar');
        $payLoad = ["email" => ""];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, convert_arabic_to_unicode("(email) هذا الحقل مطلوب"));
    }

    public function testAuthLoginValidateRequiredPasswordEnglish()
    {
        $payLoad = ["password" => ""];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, "(password) field is required");
    }

    public function testAuthLoginValidateRequiredPasswordArabic()
    {
        App::setLocale('ar');
        $payLoad = ["password" => ""];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, convert_arabic_to_unicode("(password) هذا الحقل مطلوب"));
    }

    public function testAuthLoginValidateWrongEmailEnglish()
    {
        $payLoad = ["email" => "asdsa@asdsad.com"];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, "email or password is incorrect");
    }

    public function testAuthLoginValidateWrongEmailArabic()
    {
        App::setLocale('ar');
        $payLoad = ["email" => "asdsa@asdsad.com"];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, convert_arabic_to_unicode("البريد الالكتروني او كلمة المرور غير صحيحة"));
    }

    public function testAuthLoginValidateWrongCredentialsEnglish()
    {
        $payLoad = ["email" => "super@admin.com", "password" => "123asdY%"];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, "email or password is incorrect");
    }

    public function testAuthLoginValidateWrongCredentialsArabic()
    {
        App::setLocale('ar');
        $payLoad = ["email" => "super@admin.com", "password" => "123asdY%"];
        $response = $this->post($this->loginUrl, $this->loginPayload($payLoad));
        assertDataHasError($response, convert_arabic_to_unicode("البريد الالكتروني او كلمة المرور غير صحيحة"));
    }
}
