<?php

use App\Constants\Status_Responses;

if(!function_exists("jsonResponse")){
    function jsonResponse($statusCode, $message, $data){
        return response([
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
 }

 if(!function_exists("response_msg")){
    function response_msg($status_code) {
        return Status_Responses::get_response_msg($status_code);
    }
 }

 if(!function_exists("ok_response")){
    function ok_response($data = [], $msg = null){
        $msg = $msg ?? response_msg(Status_Responses::OK);
        return jsonResponse(Status_Responses::OK, $msg, $data);
    }
 }

 if(!function_exists("created_response")){
    function created_response($data = [], $msg = null){
        $msg = $msg ?? response_msg(Status_Responses::CREATED);
        return jsonResponse(Status_Responses::CREATED, $msg, $data);
    }
 }

 if(!function_exists("unprocessable_response")){
    function unprocessable_response($errors = []){
        return jsonResponse(Status_Responses::UNPROCESSABLE_ENTITY, response_msg(Status_Responses::UNPROCESSABLE_ENTITY), $errors);
    }
 }

 if(!function_exists("unauthorized_response")){
    function unauthorized_response($data = [], $msg = null){
        $msg = $msg ?? response_msg(Status_Responses::UNAUTHORIZED);
        return jsonResponse(Status_Responses::UNAUTHORIZED, $msg, $data);
    }
 }

 if(!function_exists("forbidden_response")){
    function forbidden_response($data = [], $msg = null){
        $msg = $msg ?? response_msg(Status_Responses::FORBIDDEN);
        return jsonResponse(Status_Responses::FORBIDDEN, $msg, $data);
    }
 }

 if(!function_exists("internal_server_error_response")){
    function internal_server_error_response($data = [], $msg = null){
        $msg = $msg ?? response_msg(Status_Responses::INTERNAL_SERVER_ERROR);
        return jsonResponse(Status_Responses::INTERNAL_SERVER_ERROR, response_msg(Status_Responses::INTERNAL_SERVER_ERROR), $data);
    }
 }

 if(!function_exists("not_found_response")){
    function not_found_response($data = [], $msg = null){
        $msg = $msg ?? response_msg(Status_Responses::NOT_FOUND);
        return jsonResponse(Status_Responses::NOT_FOUND, response_msg(Status_Responses::NOT_FOUND), $data);
    }
 }
