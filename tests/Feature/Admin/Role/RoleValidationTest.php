<?php

namespace Tests\Feature\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class RoleValidationTest extends TestCase
{
    use RefreshDatabase, RoleTestingTrait;

    public function testRoleDeleteValidateNotAllowedSuperAdminRoleEnglish()
    {
        $response = $this->delete('/api/admin/roles/'.$this->firstRole->id);
        assertDataHasError($response, "you cannot delete a role of superadmin");
    }

    public function testRoleDeleteValidateNotAllowedSuperAdminRoleArabic()
    {
        App::setLocale('ar');
        $response = $this->delete('/api/admin/roles/'.$this->firstRole->id);
        assertDataHasError($response, convert_arabic_to_unicode("لا يمكنك حذف وظيفة superadmin"));
    }

    //RoleStore
    public function testRoleStoreValidateNameRequiredEnglish()
    {
        $response = $this->post('/api/admin/roles', $this->rolePayLoad(["name" => ""]));
        assertDataHasError($response, "(name) field is required");
    }

    public function testRoleStoreValidateNameRequiredArabic()
    {
        App::setLocale('ar');
        $response = $this->post('/api/admin/roles', $this->rolePayLoad(["name" => ""]));
        assertDataHasError($response, convert_arabic_to_unicode("(name) هذا الحقل مطلوب"));
    }

    public function testRoleStoreValidateMinimumNameEnglish()
    {
        $data = [
            "name" => "as",
        ];

        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, "(name) (3) characters is the minimum limit for this field");
    }

    public function testRoleStoreValidateMinimumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "as",
        ];

        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testRoleStoreValidateMaximumNameEnglish()
    {
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, "(name) (40) characters is the maximum limit for this field");
    }

    public function testRoleStoreValidateMaximumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testRoleStoreValidateStringNameEnglish()
    {
        $data = [
            "name" => 123123,
        ];

        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, "(name) field format is incorrect");
    }

    public function testRoleStoreValidateStringNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => 123123,
        ];

        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode("(name) تنسيق هذا الحقل غير سليم"));
    }

    public function testRoleStoreValidateNameUniqueEnglish()
    {
        $data = ["name" => $this->lastRole->name];
        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, "(name) this field already exists");
    }

    public function testRoleStoreValidateNameUniqueArabic()
    {
        App::setLocale("ar");
        $data = ["name" => $this->lastRole->name];
        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, sprintf("%s %s", "(name)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    }

    public function testRoleStoreValidateActiveRequiredEnglish()
    {
        $response = $this->post('/api/admin/roles', $this->rolePayLoad(["active" => ""]));
        assertDataHasError($response, "(active) field is required");
    }

    public function testRoleStoreValidateActiveRequiredArabic()
    {
        App::setLocale('ar');
        $response = $this->post('/api/admin/roles', $this->rolePayLoad(["active" => ""]));
        assertDataHasError($response, convert_arabic_to_unicode("(active) هذا الحقل مطلوب"));
    }

    public function testRoleStoreValidateActiveBooleanEnglish()
    {
        $response = $this->post('/api/admin/roles', $this->rolePayLoad([ "active" => 4]));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testRoleStoreValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $response = $this->post('/api/admin/roles', $this->rolePayLoad(["active" => "123"]));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testRoleStoreValidatePermissionIdsArrayEnglish()
    {
        $data = ["permission_ids" => "123123"];
        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, "(Permission IDs) field format is incorrect");
    }

    public function testRoleStoreValidatePermissionIdsArrayArabic()
    {
        App::setLocale("ar");
        $data = ["permission_ids" => "123123"];
        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, sprintf("%s %s", "(Permission IDs)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testRoleStoreValidatePermissionIdsIncorrectEnglish()
    {
        $data = ["permission_ids" => [59595955,292929,29292299090]];
        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, "(Permission IDs) values of this field are incorrect");
    }

    public function testRoleStoreValidatePermissionIdsIncorrectArabic()
    {
        App::setLocale("ar");
        $data = ["permission_ids" => [59595955,292929,29292299090]];
        $response = $this->post('/api/admin/roles', $this->rolePayLoad($data));
        assertDataHasError($response, sprintf("%s %s", "(Permission IDs)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }

    //RoleUpdate
    public function testRoleUpdateValidateMinimumNameEnglish()
    {
        $data = [
            "name" => "as",
        ];

        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(name) (3) characters is the minimum limit for this field");
    }

    public function testRoleUpdateValidateMinimumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "as",
        ];

        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(3)", "الحد الأدنى لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testRoleUpdateValidateMaximumNameEnglish()
    {
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(name) (40) characters is the maximum limit for this field");
    }

    public function testRoleUpdateValidateMaximumNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => "asmwdasmwdasmwdasmwdasmwdasmwdasmwdasmwdw",
        ];

        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(name)", "(40)", "الحد الافصي لعدد الأحرف المسموح به لهذا الحقل هو")));
    }

    public function testRoleUpdateValidateStringNameEnglish()
    {
        $data = [
            "name" => 123123,
        ];

        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(name) field format is incorrect");
    }

    public function testRoleUpdateValidateStringNameArabic()
    {
        App::setLocale("ar");
        $data = [
            "name" => 123123,
        ];

        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode("(name) تنسيق هذا الحقل غير سليم"));
    }

    public function testRoleUpdateValidateActiveBooleanEnglish()
    {
        $data = ["active" => 4];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testRoleUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = ["active" => "123as"];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testRoleUpdateValidateNameUniqueEnglish()
    {
        $data = ["name" => $this->firstRole->name];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(name) this field already exists");
    }

    public function testRoleUpdateValidateNameUniqueArabic()
    {
        App::setLocale("ar");
        $data = ["name" => $this->firstRole->name];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, sprintf("%s %s", "(name)", convert_arabic_to_unicode("هذا الحقل موجود بالفعل")));
    }

    public function testRoleUpdateValidatePermissionIdsArrayEnglish()
    {
        $data = ["permission_ids" => "123123"];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(Permission IDs) field format is incorrect");
    }

    public function testRoleUpdateValidatePermissionIdsArrayArabic()
    {
        App::setLocale("ar");
        $data = ["permission_ids" => "123123"];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, sprintf("%s %s", "(Permission IDs)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testRoleUpdateValidatePermissionIdsIncorrectEnglish()
    {
        $data = ["permission_ids" => [59595955,292929,29292299090]];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, "(Permission IDs) values of this field are incorrect");
    }

    public function testRoleUpdateValidatePermissionIdsIncorrectArabic()
    {
        App::setLocale("ar");
        $data = ["permission_ids" => [59595955,292929,29292299090]];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        assertDataHasError($response, sprintf("%s %s", "(Permission IDs)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }
}
