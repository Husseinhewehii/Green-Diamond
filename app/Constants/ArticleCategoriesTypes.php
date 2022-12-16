<?php

 namespace App\Constants;

 final class ArticleCategoriesTypes{
     const BLOGS = 1;
     const NEWS = 2;

     public static function getArticleCategoriesTypes()
     {
         return [
            ArticleCategoriesTypes::BLOGS => 'BLOGS',
            ArticleCategoriesTypes::NEWS => 'NEWS',
         ];
     }

     public static function getArticleCategoriesTypesValues()
     {
         return array_keys(self::getArticleCategoriesTypes());
     }

     public static function getArticleCategoriesType($key = '')
     {
         return !array_key_exists($key, self::getArticleCategoriesTypes()) ?
          " " : self::getArticleCategoriesTypes()[$key];
     }
 }
