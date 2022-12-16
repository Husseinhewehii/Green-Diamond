<?php
use App\Models\SystemRole as Role;
use App\Models\SystemPermission as Permission;
use App\Models\Tag;

//translatables
if(!function_exists("translatable_locales_are_allowed")){
    function translatable_locales_are_allowed($translatable){
        return $translatable == array_filter($translatable, fn($item) => in_array($item, main_locales()), ARRAY_FILTER_USE_KEY);
    }
 }

 if(!function_exists("validate_translatable_locales")){
    function validate_translatable_locales($validator, $translatable){
        if(!translatable_locales_are_allowed(request()->$translatable)){
            validate_single(
                $validator, $translatable,
                sprintf("%s (%s) (%s)", get_static_content("allowed_languages_for_this_field"), $translatable, valid_inputs(main_locales()))
            );
        }
    }
 }

 if(!function_exists("translatable_is_array")){
    function translatable_is_array($validator, $translatable){
         if(is_array(request()->$translatable)){
             return true;
         };
         validate_single($validator, $translatable, "($translatable) ".get_static_content("format_is_incorrect"));
         return false;
    }
 }

 if(!function_exists("translatable_first_character_is_Letter")){
    function translatable_first_character_is_Letter($validator, $translatable){
        foreach (request()->$translatable as $key => $value) {
            if(!preg_match("/^[a-zA-Z]/", $value)){
                validate_single($validator, $translatable, "($translatable) ($key) is Invalid");
                return false;
            }
        }
        return true;
    }
 }


 if(!function_exists("validate_translatables")){
    function validate_translatables($validator, $translatables){
        foreach ($translatables as $translatable) {
            if(request()->$translatable && translatable_is_array($validator, $translatable)){
                validate_translatable_locales($validator, $translatable);
            }
        }
    }
 }

 //numeric arrays
 if(!function_exists("validate_role_ids")){
    function validate_role_ids($validator, $role_ids){
        if(is_array($role_ids)){
            if($role_ids && Role::whereIn('id', $role_ids)->count() != count($role_ids)){
                validate_single($validator, 'role_ids', sprintf("%s %s", "(Role IDs)", get_static_content("values_are_invalid")));
            }
        }
    }
}

if(!function_exists("validate_permission_ids")){
    function validate_permission_ids($validator, $permission_ids){
        if(is_array($permission_ids)){
            if($permission_ids && Permission::whereIn('id', $permission_ids)->count() != count($permission_ids)){
                validate_single($validator, 'permission_ids', sprintf("%s %s", "(Permission IDs)", get_static_content("values_are_invalid")));
            }
        }

    }
}

if(!function_exists("validate_tag_ids")){
    function validate_tag_ids($validator, $tag_ids){
        if(is_array($tag_ids)){
            if($tag_ids && Tag::whereIn('id', $tag_ids)->count() != count($tag_ids)){
                validate_single($validator, 'tag_ids', sprintf("%s %s", "(Tag IDs)", get_static_content("values_are_invalid")));
            }
        }
    }
}

//media
if(!function_exists("validate_media_gallery_array")){
    function validate_media_gallery_array($validator, $media_gallery){
        if(is_array($media_gallery)){
            if($media_gallery){
                foreach ($media_gallery as $media_item) {
                    if(is_file($media_item)){
                        if(!in_array($media_item->getClientOriginalExtension(), constant('valid_media_mimes'))){
                            validate_single($validator, "media_gallery", sprintf("%s (%s) %s", "(Media Gallery Item)", valid_inputs(constant("valid_media_mimes")), get_static_content("valid_file_types")));
                        }
                        if((int)$media_item->getSize() / 1024 > (int)constant("max_media_size")){
                            validate_single($validator, "media_gallery", sprintf("%s (%s) %s", "(Media Gallery Item)", constant("max_media_size"), get_static_content("file_maximum_size")));
                        }
                    }else{
                        validate_single($validator, "media_gallery", sprintf("%s %s", "(Media Gallery Item)", get_static_content("must_be_a_file")));
                    }
                }
            }
        }
    }
}


 if(!function_exists("valid_inputs")){
    function valid_inputs($inputs){
        return substr(array_reduce($inputs, fn($a, $b) => "$a,$b"), 1);
    }
 }

 if(!function_exists("validate_single")){
    function validate_single($validator, $item, $message){
        $validator->errors()->add("$item", $message);
    }
 }
