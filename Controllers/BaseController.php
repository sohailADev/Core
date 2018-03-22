<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/22/2018
 * Time: 3:39 PM
 * Base Controller
 * Loads the models and views
 */
class BaseController
{
 //Load model
    public  function model($model)
    {
        //require model file
        require_once './Models/' . $model . '.php';
        //instatiate model
        return new $model;
    }
    //Load view
    public function view($view,$data = [])
    {
     //cehck for view
       // die('../Views/' . $view . '.php');
        if(file_exists('./Views/' . $view . '.php'))
        {
            require_once './Views/' . $view . '.php' ;

        }
        else
        {
            //view not exist

            die('View does not exist ');
        }

    }
}