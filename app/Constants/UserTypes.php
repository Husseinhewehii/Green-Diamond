<?php

 namespace App\Constants;

 final class UserTypes{
     const SUPER_ADMIN = 1;
     const ADMIN = 2;

     public static function getUserTypes()
     {
         return [
            UserTypes::SUPER_ADMIN => 'Super Admin',
            UserTypes::ADMIN => 'Admin',
         ];
     }

     public static function getUserTypesValues()
     {
         return array_keys(self::getUserTypes());
     }

     public static function getUserType($key = '')
     {
         return !array_key_exists($key, self::getUserTypes()) ?
          " " : self::getUserTypes()[$key];
     }
 }
