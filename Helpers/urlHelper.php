<?php
/**
 * Created by PhpStorm.
 * User: sohail
 * Date: 1/26/2018
 * Time: 2:42 PM
 */
function redirect($page)
{
    header('location:'.URLROOT.'/'.$page);
}
function dnd($obj)
{
    echo '<pre>';
    die(print_r($obj));
    echo '</pre>';

}