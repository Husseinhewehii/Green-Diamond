<?php

namespace Database\Seeders;

use App\Models\StaticContent;
use Illuminate\Database\Seeder;

class StaticContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layoutStaticContent = [
            "navbarlinkhome" => [
                "en" => "navbarlinkhome",
                "ar" => "navbarlinkhome"
            ],
            "navbarlinkpartiners" => [
                "en" => "navbarlinkpartiners",
                "ar" => "navbarlinkpartiners"
            ],
            "navbarlinkabout" => [
                "en" => "navbarlinkabout",
                "ar" => "navbarlinkabout"
            ],
            "navbarlinkblogs" => [
                "en" => "navbarlinkblogs",
                "ar" => "navbarlinkblogs"
            ],
            "navbarlinknews" => [
                "en" => "navbarlinknews",
                "ar" => "navbarlinknews"
            ],
            "navbarlinkmanagment" => [
                "en" => "navbarlinkmanagment",
                "ar" => "navbarlinkmanagment"
            ],
            "navbarlinkcontact" => [
                "en" => "navbarlinkcontact",
                "ar" => "navbarlinkcontact"
            ],
            "navbarlinkcategory" => [
                "en" => "navbarlinkcategory",
                "ar" => "navbarlinkcategory"
            ],
            "navbarlinktype" => [
                "en" => "navbarlinktype",
                "ar" => "navbarlinktype"
            ],
            "navbarlinkconsulted" => [
                "en" => "navbarlinkconsulted",
                "ar" => "navbarlinkconsulted"
            ],
            "footerdesc" => [
                "en" => "footerdesc",
                "ar" => "footerdesc"
            ],
            "footermainpages" => [
                "en" => "footermainpages",
                "ar" => "footermainpages"
            ],
            "footerlatestblogs" => [
                "en" => "footerlatestblogs",
                "ar" => "footerlatestblogs"
            ],
            "footercopyright" => [
                "en" => "footercopyright",
                "ar" => "footercopyright"
            ],
            "footeryear" => [
                "en" => "footeryear",
                "ar" => "footeryear"
            ],
            "footerallrightsreserved" => [
                "en" => "footerallrightsreserved",
                "ar" => "footerallrightsreserved"
            ],
            "footerpowredby" => [
                "en" => "footerpowredby",
                "ar" => "footerpowredby"
            ],
            "footerterms" => [
                "en" => "footerterms",
                "ar" => "footerterms"
            ],
            "footerpolicy" => [
                "en" => "footerpolicy",
                "ar" => "footerpolicy"
            ],
            "readmore" => [
                "en" => "readmore",
                "ar" => "readmore"
            ],
            "viewall" => [
                "en" => "viewall",
                "ar" => "viewall"
            ],
        ];

        $homepageStaticContent = [
            "subheaderwelcometilte" => [
                "en" => "subheaderwelcometilte",
                "ar" => "subheaderwelcometilte"
            ],
            "subheaderwelcomesubtilte" => [
                "en" => "subheaderwelcomesubtilte",
                "ar" => "subheaderwelcomesubtilte"
            ],
            "subheaderwelcomedesc" => [
                "en" => "subheaderwelcomedesc",
                "ar" => "subheaderwelcomedesc"
            ],
            "latestnewstitle" => [
                "en" => "latestnewstitle",
                "ar" => "latestnewstitle"
            ],
            "latestnewsdesc" => [
                "en" => "latestnewsdesc",
                "ar" => "latestnewsdesc"
            ],
            "latestblogstitle" => [
                "en" => "latestblogstitle",
                "ar" => "latestblogstitle"
            ],
            "latestblogsdesc" => [
                "en" => "latestblogsdesc",
                "ar" => "latestblogsdesc"
            ],
            "latestblogstitle" => [
                "en" => "latestblogstitle",
                "ar" => "latestblogstitle"
            ],
            "successpartnerstitle" => [
                "en" => "successpartnerstitle",
                "ar" => "successpartnerstitle"
            ],
            "successpartnersdesc" => [
                "en" => "successpartnersdesc",
                "ar" => "successpartnersdesc"
            ],

        ];

        $aboutpageStaticContent = [
            "ourteamtitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "ourteamdesc" => [
                "en" => "desc",
                "ar" => "desc",
            ],
        ];

        $contactuspageStaticContent = [
            "contactinfotitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "addresstitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "addressinfo" => [
                "en" => "info",
                "ar" => "info",
            ],
            "phonetitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "phoneinfo" => [
                "en" => "info",
                "ar" => "info",
            ],
            "emailtitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "emailinfo" => [
                "en" => "info",
                "ar" => "info",
            ],
            "contactusformtitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "formname" => [
                "en" => "name",
                "ar" => "name",
            ],
            "formmobile" => [
                "en" => "mobile",
                "ar" => "mobile",
            ],
            "formemail" => [
                "en" => "email",
                "ar" => "email",
            ],
            "formmsg" => [
                "en" => "message",
                "ar" => "message",
            ],
            "formbtnsubmit" => [
                "en" => "submit",
                "ar" => "submit",
            ],
        ];

        $consultingpageStaticContent  = [
            "consultingformtitle" => [
                "en" => "title",
                "ar" => "title",
            ],
            "consultingformdesc" => [
                "en" => "desc",
                "ar" => "desc",
            ],
        ];

        $validationStaticContent = [
            //is required
            "field_is_required" => [
                "en" => "field is required",
                "ar" => "?????? ?????????? ??????????",
            ],
            //exist
            "field_does_not_exist" => [
                "en" => "field does not exist",
                "ar" => "?????? ?????????? ?????? ??????????",
            ],
            "field_already_exists" => [
                "en" => "this field already exists",
                "ar" => "?????? ?????????? ?????????? ????????????",
            ],
            //numeric
            "must_be_numeric" => [
                "en" => "field must be numeric",
                "ar" => "?????? ?????????? ?????? ???? ???????? ????????",
            ],
            //file
            "must_be_a_file" => [
                "en" => "must be a file",
                "ar" => "?????? ???? ???????? ?????? ?????????? ??????????",
            ],
            //incorrect format
            "format_is_incorrect" => [
                "en" => "field format is incorrect",
                "ar" => "?????????? ?????? ?????????? ?????? ????????",
            ],
            //minimum characters
            "min_character_limit" => [
                "en" => "characters is the minimum limit for this field",
                "ar" => "???????? ???????????? ???????? ???????????? ?????????????? ???? ???????? ?????????? ????",
            ],
            //maximum characters
            "max_character_limit" => [
                "en" => "characters is the maximum limit for this field",
                "ar" => "???????? ???????????? ???????? ???????????? ?????????????? ???? ???????? ?????????? ????",
            ],
            //valid types
            "valid_values" => [
                "en" => "are the valid values for this field",
                "ar" => "?????? ???????????????? ???? ?????????????? ?????? ?????? ??????????",
            ],
            "values_are_invalid" => [
                "en" => "values of this field are incorrect",
                "ar" => "?????? ?????? ?????????? ?????? ??????????",
            ],
            "values_should_be_different_from_target_item" => [
                "en" => "should be different from targeted item",
                "ar" => "?????? ???? ???????? ???????? ?????? ?????????? ???????????? ???? ???????????? ????????????????",
            ],
            "valid_file_types" => [
                "en" => "are the valid types for this file",
                "ar" => "?????? ???? ?????????????? ?????????????? ???????? ??????????",
            ],
            //
            "email_or_password_is_incorrect" => [
                "en" => "email or password is incorrect",
                "ar" => "???????????? ???????????????????? ???? ???????? ???????????? ?????? ??????????",
            ],
            "allowed_languages_for_this_field" => [
                "en" => "allowed languages for this field",
                "ar" => "???????????? ?????????????? ?????? ???????? ??????????",
            ],
            "file_maximum_size" => [
                "en" => "is maximum size for this file",
                "ar" => "?????? ???? ?????????? ???????????? ???????? ??????????",
            ],
            "you_cannot_delete_user_type_superadmin" => [
                "en" => "you cannot delete a user of type superadmin",
                "ar" => "???? ?????????? ?????? ???????????? ???? ?????? superadmin",
            ],
            "you_cannot_delete_role_superadmin" => [
                "en" => "you cannot delete a role of superadmin",
                "ar" => "???? ?????????? ?????? ?????????? superadmin",
            ],
        ];


        foreach ($layoutStaticContent as $key => $value) {
            StaticContent::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "layout", "text" => $value]);
        }
        foreach ($homepageStaticContent as $key => $value) {
            StaticContent::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "homepage", "text" => $value]);
        }
        foreach ($aboutpageStaticContent as $key => $value) {
            StaticContent::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "aboutpage", "text" => $value]);
        }
        foreach ($contactuspageStaticContent as $key => $value) {
            StaticContent::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "contactuspage", "text" => $value]);
        }
        foreach ($consultingpageStaticContent as $key => $value) {
            StaticContent::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "consultingpage", "text" => $value]);
        }
        foreach ($validationStaticContent as $key => $value) {
            StaticContent::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => 'validation', "text" => $value]);
        }
    }
}
