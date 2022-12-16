<?php
use App\Models\StaticContent;
use App\Models\Tag;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;


define('default_cache_expiration_time', 1296000);

//string
if(!function_exists("extractModelName")){
    function extractModelName($modelPath){
        $pieces = explode("\\", $modelPath);
        return array_pop($pieces);
    }
 }

//locale
if(!function_exists("main_locales")){
    function main_locales() {
        return array_keys(config('laravellocalization.supportedLocales'));
    }
 }

 if(!function_exists("localizedFunction")){
    function localizedFunction($closure, $params) {
        $tempLocale = current_locale();
        $args = [];
        foreach (main_locales() as $locale) {
            App::setLocale($locale);
            $args = $params;
            $args[] = $locale;
            $closure(...$args);
        }
        App::setLocale($tempLocale);
    }
 }

 if(!function_exists("current_locale")){
    function current_locale() {
        return App::currentLocale();
    }
 }

//collection format
if(!function_exists("collectionFormat")){
    function collectionFormat($collection, $data) {
        return $collection::collection($data);
    }
}

if(!function_exists("paginatedCollectionFormat")){
    function paginatedCollectionFormat($collection, $data) {
        return $collection::collection($data)->response()->getData(true);
    }
}

//config
if(!function_exists("main_locales")){
    function main_locales() {
        return array_keys(config('laravellocalization.supportedLocales'));
    }
 }

//static content
if(!function_exists("get_static_content")){
    function get_static_content($key){
        return StaticContent::where('key', $key)->first()->text;
    }
}


if(!function_exists("convert_arabic_to_unicode")){
    function convert_arabic_to_unicode($string) {
        return substr(json_encode($string), 1, -1);
    }
}

//cache
if(!function_exists("cacheAndLocalizeArray")){
    function cacheAndLocalizeArray($item, $key_name, $locale, $expiration_time = 0) {
        $expiration_time = $expiration_time === 0 ? constant("default_cache_expiration_time") : $expiration_time;
        if(is_array($item) && count($item)){
            Redis::set($key_name."_".$locale, json_encode($item), "EX", $expiration_time);
        }
    }
 }

 if(!function_exists("cachedLocalizedArray")){
    function cachedLocalizedArray($key_name) {
        $array = Redis::get($key_name."_".current_locale());
        if($array){
            return json_decode($array);
        }
    }
 }

 //media
 if(!function_exists("add_media_item")){
    function add_media_item($model, $item, $collection) {
        if($item){
            try {
                $model->addMedia($item)->toMediaCollection($collection);
            } catch (Throwable $th) {
                dd($th);
                throw new HttpResponseException(internal_server_error_response());
            }
        }
    }
 }

 if(!function_exists("add_multi_media_item")){
    function add_multi_media_item($model, $items, $collection) {
        if($items){
            try {
                foreach ($items as $item) {
                    add_media_item($model, $item, $collection);
                }
            } catch (Throwable $th) {
                throw new HttpResponseException(internal_server_error_response());
            }
        }
    }
 }

 if(!function_exists("get_media_gallery_filtered")){
    function get_media_gallery_filtered($model, $collection) {
        return array_map(fn($item) => assertMediaGalleryItemFormat($item), $model->getMedia($collection)->toArray());
    }
 }

 //array
 if(!function_exists("check_item_in_array_collection_contain_string")){
    function check_item_in_array_collection_contain_string($arrayCollection, $item, $string) {
        foreach ($arrayCollection as $arrayModel) {
            if(!str_contains($arrayModel[$item], $string)){
                return false;
            }
        }
        return true;
    }
 }

//tags
if(!function_exists("add_tags")){
function add_tags($model, $tag_ids) {
        if(is_array($tag_ids)){
            $tags = Tag::whereIn('id', $tag_ids)->get();
            $model->syncTags($tags);
        }
    }
 }
