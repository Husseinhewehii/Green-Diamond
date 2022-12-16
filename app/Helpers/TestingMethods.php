<?php

//validation
if(!function_exists("assertDataHasError")){
    function assertDataHasError($response, $errorText) {
        $response->assertUnprocessable();
        $response->assertJson([
            "status_code" => 422,
            "message" => "Unprocessable Entity"
        ]);
        $response->assertSee($errorText);
    }
}


if(!function_exists("assertUnauthorizedFormat")){
    function assertUnauthorizedFormat() {
        return [
            "status_code" => 401,
            "message" => "Unauthorized",
            "data" => [

            ]
        ];
    }
}

if(!function_exists("assertForbiddenFormat")){
    function assertForbiddenFormat() {
        return [
            "status_code" => 403,
            "message" => "Forbidden",
            "data" => []
        ];
    }
}

if(!function_exists("assertNotFoundFormat")){
    function assertNotFoundFormat() {
        return [
            "status_code" => 404,
            "message" => "Not Found",
            "data" => []
        ];
    }
}

if(!function_exists("assertPaginationFormat")){
    function assertPaginationFormat($data = []) {
        return [
            "status_code" => 200,
            "message" => "OK",
            "data" => [
                "data" => $data,
                "meta" => [
                    "links" => [

                    ]
                ]
            ]
        ];
    }
}

if(!function_exists("assertCreatedPaginationFormat")){
    function assertCreatedPaginationFormat($data = []) {
        return [
            "status_code" => 201,
            "message" => "Created",
            "data" => [
                "data" => $data,
                "meta" => [
                    "links" => [

                    ]
                ]
            ]
        ];
    }
}


if(!function_exists("assertDataContent")){
    function assertDataContent($data) {
        return [
            "status_code" => 200,
            "message" => "OK",
            "data" => $data
        ];
    }
}

if(!function_exists("assertCheckPaginatedResponseHasPhotoLink")){
     function assertCheckPaginatedResponseHasPhotoLink($response, $index){
        $photoLink = json_decode($response->content(), true)['data']['data'][$index]['photo'];
        return filter_var($photoLink, FILTER_VALIDATE_URL) !== FALSE;
    }
}

if(!function_exists("assertCheckResponseHasPhotoLink")){
     function assertCheckResponseHasPhotoLink($response){
        $photoLink = json_decode($response->content(), true)['data']['photo'];
        return filter_var($photoLink, FILTER_VALIDATE_URL) !== FALSE;
    }
}


if(!function_exists("assertMediaGalleryItemFormat")){
    function assertMediaGalleryItemFormat($mediaItem) {
        return [
            "id" => $mediaItem["id"],
            "url" => $mediaItem["original_url"]
        ];
    }
 }

if(!function_exists("assertTagResponseDataFormat")){
    function assertTagResponseDataFormat($tag, $withTranslatables = false) {
        return [
            "id" => $tag->id,
            'name' => $withTranslatables ? $tag->nameTranslatables : $tag->name,
            "active" => $tag->active,
        ];
    }
}

if(!function_exists("assertReviewFormat")){
    function assertReviewFormat($review) {
        $model = strtolower(extractModelName($review->model_type));
        $reviewer = $review->user ?
        [
            'id' => $review->user->id,
            'first_name' => $review->user->first_name,
            'last_name' => $review->user->last_name,
            'email' => $review->user->email,
            'phone' => $review->user->phone,
            'type' => $review->user->type,
            'active' => $review->user->active,
        ] : $review->user_id;

        return [
            "id" => $review->id,
            sprintf("%s_id", $model) => $review->model_id,
            "rating" => $review->rating,
            "comment" => $review->comment,
            "reply" => $review->reply,
            "reviewer" => $reviewer,
        ];
    }
}





