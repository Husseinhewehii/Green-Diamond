<?php

//constants
define('min_name_limit', 3);
define('max_name_limit', 40);

define('min_description_limit', 5);
define('max_description_limit', 500);

define("max_image_size", "5000");
define("max_media_size", "5000");
define("valid_image_mimes", ["jpeg", "jpg", "png"]);
define("valid_media_mimes", [...constant("valid_image_mimes")]);

//validations
define("valid_name", ['string', "min:".constant("min_name_limit"), "max:".constant("max_name_limit")]);
define("valid_description", ['string', "min:".constant("min_description_limit"), "max:".constant("max_description_limit")]);
define("valid_email", ["regex:/^[a-zA-Z0-9.!#$%&’*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$/"]);
define("valid_password", ["string", "min:8", "regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"]);


define("valid_image", ["file", 'mimes:'.valid_inputs(constant("valid_image_mimes")), "max:".constant("max_image_size")]);
