<?php

namespace Tests\Feature\Admin\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class EmployeeValidationTest extends TestCase
{
    use RefreshDatabase, EmployeeTestingTrait;

    public function testEmployeeStoreValidateRequiredItemsEnglish()
    {
        $data = [
            "name" => "",
            // "email" => "",
            // "phone" => "",
            "position" => "",
            "photo" => "",
            "type" => "",
            "active" => "",
            "description" => "",
        ];
        $errors = [
            "(name) field is required",
            // "(email) field is required",
            // "(phone) field is required",
            "(photo) field is required",
            "(position) field is required",
            "(type) field is required",
            "(active) field is required",
            "(description) field is required",
        ];
        $response = $this->post('/api/admin/employees', $this->employeePayload($data));
        assertDataHasError($response, $errors);
    }

    public function testEmployeeStoreValidateRequiredItemsArabic()
    {
        App::setLocale('ar');
        $data = [
            "name" => "",
            // "email" => "",
            // "phone" => "",
            "photo" => "",
            "position" => "",
            "type" => "",
            "active" => "",
            "description" => "",
        ];
        $errors = [
            convert_arabic_to_unicode("(name) هذا الحقل مطلوب"),
            // convert_arabic_to_unicode("(email) هذا الحقل مطلوب"),
            // convert_arabic_to_unicode("(phone) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(photo) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(position) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(type) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(active) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(description) هذا الحقل مطلوب"),
        ];
        $response = $this->post('/api/admin/employees', $this->employeePayload($data));
        assertDataHasError($response, $errors);
    }

    //EmployeeStore
    public function testEmployeeStoreValidateMinimumNameEnglish()
    {
        $data = [
            "name" => "as",
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, "(name) (3) characters is the minimum limit for this field");
    }

    public function testEmployeeStoreValidateMinimumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "as",
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testEmployeeStoreValidateMaximumNameEnglish()
    {
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, "(name) (40) characters is the maximum limit for this field");
    }

    public function testEmployeeStoreValidateMaximumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testEmployeeStoreValidateStringNameEnglish()
    {
        $data = [
            "name" => 123123,
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, "(name) field format is incorrect");
    }

    public function testEmployeeStoreValidateStringNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => 123123,
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode("(name) تنسيق هذا الحقل غير سليم"));
    }

    public function testEmployeeStoreValidateActiveBooleanEnglish()
    {
        $response = $this->post('/api/admin/employees', $this->employeePayLoad([ "active" => 4]));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testEmployeeStoreValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $response = $this->post('/api/admin/employees', $this->employeePayLoad(["active" => "123"]));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    // public function testEmployeeStoreValidateEmailRegexEnglish()
    // {
    //     $data = [
    //         "email" => "emailasd.okqwm,m",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, "(email) field format is incorrect");
    // }

    // public function testEmployeeStoreValidateEmailRegexArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "email" => "emailasd.okqwm,m",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(email) تنسيق هذا الحقل غير سليم"));
    // }

    // public function testEmployeeStoreValidateEmailUniqueUsersTableEnglish()
    // {
    //     $data = ["email" => "super@admin.com"];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, "(email) this field already exists");
    // }

    // public function testEmployeeStoreValidateEmailUniqueUsersTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["email" => "super@admin.com"];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(email)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeStoreValidateEmailUniqueEmployeesTableEnglish()
    // {
    //     $data = ["email" => $this->firstEmployee->email];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, "(email) this field already exists");
    // }

    // public function testEmployeeStoreValidateEmailUniqueEmployeesTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["email" => $this->firstEmployee->email];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(email)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeStoreValidatePhoneUniqueUsersTableEnglish()
    // {
    //     $data = ["phone" => $this->superAdmin->phone];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, "(phone) this field already exists");
    // }

    // public function testEmployeeStoreValidatePhoneUniqueUsersTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["phone" => $this->superAdmin->phone];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(phone)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeStoreValidatePhoneUniqueEmployeesTableEnglish()
    // {
    //     $data = ["phone" => $this->firstEmployee->phone];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, "(phone) this field already exists");
    // }

    // public function testEmployeeStoreValidatePhoneUniqueEmployeesTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["phone" => $this->firstEmployee->phone];
    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(phone)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeStoreValidatePhoneNumericEnglish()
    // {
    //     $data = [
    //         "phone" => "sad2asd12123",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, "(phone) field must be numeric");
    // }

    // public function testEmployeeStoreValidatePhoneNumericArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "phone" => "213213^",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(phone) هذا الحقل يجب ان يكون رقمي"));
    // }

    public function testEmployeeStoreValidateTypeEmployeeOrManagerEnglish()
    {
        $data = [
            "type" => 0,
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayload($data));
        assertDataHasError($response, "(type) (1,2) are the valid values for this field");
    }

    public function testEmployeeStoreValidateTypeEmployeeOrManagerArabic()
    {
        App::setLocale("ar");
        $data = [
            "type" => 5,
        ];

        $response = $this->post('/api/admin/employees', $this->employeePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(type)", "(1,2)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    // public function testEmployeeStoreValidateMinimumDescriptionEnglish()
    // {
    //     $data = [
    //         "description" => "as",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     assertDataHasError($response, "(description) (5) characters is the minimum limit for this field");
    // }

    // public function testEmployeeStoreValidateMinimumDescriptionArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "description" => "as",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(description)", "(5)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    // }

    // public function testEmployeeStoreValidateMaximumDescriptionEnglish()
    // {
    //     $data = [
    //         "description" => "asdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasda",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     assertDataHasError($response, "(description) (500) characters is the maximum limit for this field");
    // }

    // public function testEmployeeStoreValidateMaximumDescriptionArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "description" => "asdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasda",
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(description)", "(500)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    // }

    // public function testEmployeeStoreValidateStringDescriptionEnglish()
    // {
    //     $data = [
    //         "description" => 123123,
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     assertDataHasError($response, "(description) field format is incorrect");
    // }

    // public function testEmployeeStoreValidateStringDescriptionArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "description" => 123123,
    //     ];

    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(description) تنسيق هذا الحقل غير سليم"));
    // }

    public function testEmployeeStoreValidatePhotoSizeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    }

    public function testEmployeeStoreValidatePhotoSizeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testEmployeeStoreValidatePhotoTypeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testEmployeeStoreValidatePhotoTypeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

        $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }

    //EmployeeUpdate
    public function testEmployeeUpdateValidateMinimumNameEnglish()
    {
        $data = [
            "name" => "as",
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, "(name) (3) characters is the minimum limit for this field");
    }

    public function testEmployeeUpdateValidateMinimumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "as",
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testEmployeeUpdateValidateMaximumNameEnglish()
    {
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, "(name) (40) characters is the maximum limit for this field");
    }

    public function testEmployeeUpdateValidateMaximumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testEmployeeUpdateValidateStringNameEnglish()
    {
        $data = [
            "name" => 123123,
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, "(name) field format is incorrect");
    }

    public function testEmployeeUpdateValidateStringNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => 123123,
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode("(name) تنسيق هذا الحقل غير سليم"));
    }

    public function testEmployeeUpdateValidateActiveBooleanEnglish()
    {
        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad([ "active" => 4]));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testEmployeeUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad(["active" => "123"]));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    // public function testEmployeeUpdateValidateEmailRegexEnglish()
    // {
    //     $data = [
    //         "email" => "emailasd.okqwm,m",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, "(email) field format is incorrect");
    // }

    // public function testEmployeeUpdateValidateEmailRegexArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "email" => "emailasd.okqwm,m",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(email) تنسيق هذا الحقل غير سليم"));
    // }

    // public function testEmployeeUpdateValidateEmailUniqueUsersTableEnglish()
    // {
    //     $data = ["email" => "super@admin.com"];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, "(email) this field already exists");
    // }

    // public function testEmployeeUpdateValidateEmailUniqueUsersTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["email" => "super@admin.com"];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(email)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeUpdateValidateEmailUniqueEmployeesTableEnglish()
    // {
    //     $data = ["email" => $this->superAdmin->email];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, "(email) this field already exists");
    // }

    // public function testEmployeeUpdateValidateEmailUniqueEmployeesTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["email" => $this->superAdmin->email];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(email)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeUpdateValidatePhoneUniqueUsersTableEnglish()
    // {
    //     $data = ["phone" => $this->superAdmin->phone];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, "(phone) this field already exists");
    // }

    // public function testEmployeeUpdateValidatePhoneUniqueUsersTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["phone" => $this->superAdmin->phone];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(phone)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeUpdateValidatePhoneUniqueEmployeesTableEnglish()
    // {
    //     $data = ["phone" => $this->superAdmin->phone];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, "(phone) this field already exists");
    // }

    // public function testEmployeeUpdateValidatePhoneUniqueEmployeesTableArabic()
    // {
    //     App::setLocale("ar");
    //     $data = ["phone" => $this->superAdmin->phone];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, sprintf("%s %s", "(phone)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    // }

    // public function testEmployeeUpdateValidatePhoneNumericEnglish()
    // {
    //     $data = [
    //         "phone" => "sad2asd12123",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, "(phone) field must be numeric");
    // }

    // public function testEmployeeUpdateValidatePhoneNumericArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "phone" => "213213^",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(phone) هذا الحقل يجب ان يكون رقمي"));
    // }

    public function testEmployeeUpdateValidateTypeEmployeeOrManagerEnglish()
    {
        $data = [
            "type" => 0,
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
        assertDataHasError($response, "(type) (1,2) are the valid values for this field");
    }

    public function testEmployeeUpdateValidateTypeEmployeeOrManagerArabic()
    {
        App::setLocale("ar");
        $data = [
            "type" => 5,
        ];

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(type)", "(1,2)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    // public function testEmployeeUpdateValidateMinimumDescriptionEnglish()
    // {
    //     $data = [
    //         "description" => "as",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
    //     assertDataHasError($response, "(description) (5) characters is the minimum limit for this field");
    // }

    // public function testEmployeeUpdateValidateMinimumDescriptionArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "description" => "as",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(description)", "(5)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    // }

    // public function testEmployeeUpdateValidateMaximumDescriptionEnglish()
    // {
    //     $data = [
    //         "description" => "asdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasda",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
    //     assertDataHasError($response, "(description) (500) characters is the maximum limit for this field");
    // }

    // public function testEmployeeUpdateValidateMaximumDescriptionArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "description" => "asdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasdaasdasdasda",
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(description)", "(500)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    // }

    // public function testEmployeeUpdateValidateStringDescriptionEnglish()
    // {
    //     $data = [
    //         "description" => 123123,
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
    //     assertDataHasError($response, "(description) field format is incorrect");
    // }

    // public function testEmployeeUpdateValidateStringDescriptionArabic()
    // {
    //     App::setLocale("ar");
    //     $data = [
    //         "description" => 123123,
    //     ];

    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(description) تنسيق هذا الحقل غير سليم"));
    // }

    public function testEmployeeUpdateValidatePhotoSizeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    }

    public function testEmployeeUpdateValidatePhotoSizeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testEmployeeUpdateValidatePhotoTypeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testEmployeeUpdateValidatePhotoTypeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }
}
