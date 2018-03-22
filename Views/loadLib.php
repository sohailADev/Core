<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/22/2018
 * Time: 2:09 PM
 */


//Load config
require_once './config/config.php';
//Load libraries
require_once './Includes/Database.php';
require_once './Controllers/Router.php';
require_once './Controllers/BaseController.php';
require_once './Includes/Composer/vendor/autoload.php';//load helpers

require_once './Helpers/urlHelper.php';
require_once './Helpers/sessionHelper.php';
//the following code will replace all the above lins :P
//auto load  libraries
//spl_autoload_register(function ($className){
//
//    require_once './Controllers/'. $className . '.php';
//});