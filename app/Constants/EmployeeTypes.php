<?php

 namespace App\Constants;

 final class EmployeeTypes{
     const MANAGER = 1;
     const STAFF = 2;

     public static function getEmployeeTypes()
     {
         return [
            EmployeeTypes::MANAGER => 'MANAGER',
            EmployeeTypes::STAFF => 'STAFF',
         ];
     }

     public static function getEmployeeTypesValues()
     {
         return array_keys(self::getEmployeeTypes());
     }

     public static function getEmployeeType($key = '')
     {
         return !array_key_exists($key, self::getEmployeeTypes()) ?
          " " : self::getEmployeeTypes()[$key];
     }
 }
