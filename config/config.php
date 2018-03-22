<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/22/2018
 * Time: 4:24 PM
 */

//app root
//magic method
//echo  __FILE__;
//the result will be C:\xampp\htdocs\wyredLearning\config\config.php the full path/app/root
//now we want to remove config.php

//echo dirname(__FILE__);//it will give parent path
//the result will be C:\xampp\htdocs\wyredLearning\config we removed config.php through dirname
//echo dirname(dirname(__FILE__));//it will give one more step to parent path
//result will be like this C:\xampp\htdocs\wyredLearning
//now we will define the a constant and we are going to put this path to that constant
// and we can easyly acess this constant anywhere from app


//APP ROOT
define('APPROOT',dirname(dirname(__FILE__)));


//url Root
//define('URLROOT','http://localhost/wyredlearning');
define('URLROOT','http://localhost:8080/Core');
//site name

define('SITENAME','WyredLearing');