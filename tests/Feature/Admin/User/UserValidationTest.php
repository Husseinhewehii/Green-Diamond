<?php

namespace Tests\Feature\Admin\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class UserValidationTest extends TestCase
{
    use RefreshDatabase, UserTestingTrait;

    public function testUserDeleteValidateNotAllowedSuperAdminUserEnglish()
    {
        $response = $this->delete('/api/admin/users/'.$this->superAdmin->id);
        assertDataHasError($response, "you cannot delete a user of type superadmin");
    }

    public function testUserDeleteValidateNotAllowedSuperAdminUserArabic()
    {
        App::setLocale('ar');
        $response = $this->delete('/api/admin/users/'.$this->superAdmin->id);
        assertDataHasError($response, convert_arabic_to_unicode("لا يمكنك حذف مستخدم من نوع superadmin"));
    }

    public function testUserStoreValidateRequiredItemsEnglish()
    {
        $data = [
            "first_name" => "",
            "last_name" => "",
            "email" => "",
            "phone" => "",
            "type" => "",
            "active" => "",
            "password" => "",
        ];
        $errors = [
            "(first name) field is required",
            "(last name) field is required",
            "(email) field is required",
            "(phone) field is required",
            "(type) field is required",
            "(active) field is required",
            "(password) field is required",
        ];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, $errors);
    }

    public function testUserStoreValidateRequiredItemsArabic()
    {
        App::setLocale('ar');
        $data = [
            "first_name" => "",
            "last_name" => "",
            "email" => "",
            "phone" => "",
            "type" => "",
            "active" => "",
            "password" => "",
        ];
        $errors = [
            convert_arabic_to_unicode("(first name) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(last name) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(email) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(phone) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(type) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(active) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(password) هذا الحقل مطلوب"),
        ];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, $errors);
    }

    public function testUserStoreValidateMinimumFirstNameEnglish()
    {
        $data = [
            "first_name" => "as",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(first name) (3) characters is the minimum limit for this field");
    }

    public function testUserStoreValidateMinimumFirstNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "first_name" => "as",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(first name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserStoreValidateMinimumLastNameEnglish()
    {
        $data = [
            "last_name" => "as",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(last name) (3) characters is the minimum limit for this field");
    }

    public function testUserStoreValidateMinimumLastNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "last_name" => "as",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(last name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserStoreValidateMaximumFirstNameEnglish()
    {
        $data = [
            "first_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(first name) (40) characters is the maximum limit for this field");
    }

    public function testUserStoreValidateMaximumFirstNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "first_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(first name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserStoreValidateMaximumLastNameEnglish()
    {
        $data = [
            "last_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(last name) (40) characters is the maximum limit for this field");
    }

    public function testUserStoreValidateMaximumLastNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "last_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(last name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserStoreValidateStringFirstNameEnglish()
    {
        $data = [
            "first_name" => 123123,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(first name) field format is incorrect");
    }

    public function testUserStoreValidateStringFirstNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "first_name" => 123123,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(first name) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserStoreValidateStringLastNameEnglish()
    {
        $data = [
            "last_name" => 123123,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(last name) field format is incorrect");
    }

    public function testUserStoreValidateStringLastNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "last_name" => 123123,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(last name) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserStoreValidateEmailRegexEnglish()
    {
        $data = [
            "email" => "emailasd.okqwm,m",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(email) field format is incorrect");
    }

    public function testUserStoreValidateEmailRegexArabic()
    {
        App::setLocale("ar");
        $data = [
            "email" => "emailasd.okqwm,m",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(email) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserStoreValidateEmailUniqueEnglish()
    {
        $data = ["email" => "super@admin.com"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(email) this field already exists");
    }

    public function testUserStoreValidateEmailUniqueArabic()
    {
        App::setLocale("ar");
        $data = ["email" => "super@admin.com"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(email)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    }
    public function testUserStoreValidatePhoneUniqueEnglish()
    {
        $data = ["phone" => $this->superAdmin->phone];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(phone) this field already exists");
    }

    public function testUserStoreValidatePhoneUniqueArabic()
    {
        App::setLocale("ar");
        $data = ["phone" => $this->superAdmin->phone];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(phone)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    }

    public function testUserStoreValidatePhoneNumericEnglish()
    {
        $data = [
            "phone" => "sad2asd12123",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(phone) field must be numeric");
    }

    public function testUserStoreValidatePhoneNumericArabic()
    {
        App::setLocale("ar");
        $data = [
            "phone" => "213213^",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(phone) هذا الحقل يجب ان يكون رقمي"));
    }

    public function testUserStoreValidateTypeAdminEnglish()
    {
        $data = [
            "type" => 0,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(type) (2) are the valid values for this field");
    }

    public function testUserStoreValidateTypeAdminArabic()
    {
        App::setLocale("ar");
        $data = [
            "type" => 1,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(type)", "(2)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testUserStoreValidateActiveBooleanEnglish()
    {
        $data = [
            "active" => 4,
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testUserStoreValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = [
            "active" => "123",
        ];

        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testUserStoreValidatePasswordRegexEnglish()
    {
        $data = ["password" => "123123"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(password) field format is incorrect");
        $data = ["password" => "asdasdsad"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(password) field format is incorrect");
    }

    public function testUserStoreValidatePasswordRegexArabic()
    {
        App::setLocale("ar");
        $data = ["password" => "123123"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(password) تنسيق هذا الحقل غير سليم"));
        $data = ["password" => "asdasdsad"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(password) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserStoreValidateRoleIdsArrayEnglish()
    {
        $data = ["role_ids" => "123123"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(Role IDs) field format is incorrect");
    }

    public function testUserStoreValidateRoleIdsArrayArabic()
    {
        App::setLocale("ar");
        $data = ["role_ids" => "123123"];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Role IDs)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testUserStoreValidateRoleIdsIncorrectEnglish()
    {
        $data = ["role_ids" => [59595955,292929,29292299090]];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, "(Role IDs) values of this field are incorrect");
    }

    public function testUserStoreValidateRoleIdsIncorrectArabic()
    {
        App::setLocale("ar");
        $data = ["role_ids" => [59595955,292929,29292299090]];
        $response = $this->post('/api/admin/users', $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Role IDs)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }


    //update user
    public function testUserUpdateValidateMinimumFirstNameEnglish()
    {
        $data = [
            "first_name" => "as",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(first name) (3) characters is the minimum limit for this field");
    }

    public function testUserUpdateValidateMinimumFirstNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "first_name" => "as",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(first name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserUpdateValidateMinimumLastNameEnglish()
    {
        $data = [
            "last_name" => "as",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(last name) (3) characters is the minimum limit for this field");
    }

    public function testUserUpdateValidateMinimumLastNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "last_name" => "as",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(last name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserUpdateValidateMaximumFirstNameEnglish()
    {
        $data = [
            "first_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(first name) (40) characters is the maximum limit for this field");
    }

    public function testUserUpdateValidateMaximumFirstNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "first_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(first name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserUpdateValidateMaximumLastNameEnglish()
    {
        $data = [
            "last_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(last name) (40) characters is the maximum limit for this field");
    }

    public function testUserUpdateValidateMaximumLastNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "last_name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(last name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testUserUpdateValidateStringFirstNameEnglish()
    {
        $data = [
            "first_name" => 123123,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(first name) field format is incorrect");
    }

    public function testUserUpdateValidateStringFirstNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "first_name" => 123123,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(first name) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserUpdateValidateStringLastNameEnglish()
    {
        $data = [
            "last_name" => 123123,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(last name) field format is incorrect");
    }

    public function testUserUpdateValidateStringLastNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "last_name" => 123123,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(last name) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserUpdateValidateEmailRegexEnglish()
    {
        $data = [
            "email" => "emailasd.okqwm,m",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(email) field format is incorrect");
    }

    public function testUserUpdateValidateEmailRegexArabic()
    {
        App::setLocale("ar");
        $data = [
            "email" => "emailasd.okqwm,m",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(email) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserUpdateValidateEmailUniqueEnglish()
    {
        $data = ["email" => "super@admin.com"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(email) this field already exists");
    }

    public function testUserUpdateValidateEmailUniqueArabic()
    {
        App::setLocale("ar");
        $data = ["email" => "super@admin.com"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(email)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    }

    public function testUserUpdateValidatePhoneUniqueEnglish()
    {
        $this->withoutExceptionHandling();
        $data = ["phone" => $this->superAdmin->phone];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(phone) this field already exists");
    }

    public function testUserUpdateValidatePhoneUniqueArabic()
    {
        App::setLocale("ar");
        $data = ["phone" => $this->superAdmin->phone];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(phone)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    }

    public function testUserUpdateValidatePhoneNumericEnglish()
    {
        $data = [
            "phone" => "sad2asd12123",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(phone) field must be numeric");
    }

    public function testUserUpdateValidatePhoneNumericArabic()
    {
        App::setLocale("ar");
        $data = [
            "phone" => "213213^",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(phone) هذا الحقل يجب ان يكون رقمي"));
    }

    public function testUserUpdateValidateTypeAdminEnglish()
    {
        $data = [
            "type" => 0,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(type) (2) are the valid values for this field");
    }

    public function testUserUpdateValidateTypeAdminArabic()
    {
        App::setLocale("ar");
        $data = [
            "type" => 1,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(type)", "(2)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testUserUpdateValidateActiveBooleanEnglish()
    {
        $data = [
            "active" => 4,
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testUserUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = [
            "active" => "123",
        ];

        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testUserUpdateValidatePasswordRegexEnglish()
    {
        $data = ["password" => "123123"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(password) field format is incorrect");
        $data = ["password" => "asdasdsad"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(password) field format is incorrect");
    }

    public function testUserUpdateValidatePasswordRegexArabic()
    {
        App::setLocale("ar");
        $data = ["password" => "123123"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(password) تنسيق هذا الحقل غير سليم"));
        $data = ["password" => "asdasdsad"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(password) تنسيق هذا الحقل غير سليم"));
    }

    public function testUserUpdateValidateRoleIdsArrayEnglish()
    {
        $data = ["role_ids" => "123123"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(Role IDs) field format is incorrect");
    }

    public function testUserUpdateValidateRoleIdsArrayArabic()
    {
        App::setLocale("ar");
        $data = ["role_ids" => "123123"];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Role IDs)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testUserUpdateValidateRoleIdsIncorrectEnglish()
    {
        $data = ["role_ids" => [59595955,292929,29292299090]];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, "(Role IDs) values of this field are incorrect");
    }

    public function testUserUpdateValidateRoleIdsIncorrectArabic()
    {
        App::setLocale("ar");
        $data = ["role_ids" => [59595955,292929,29292299090]];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Role IDs)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }
}
