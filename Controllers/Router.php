<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/22/2018
 * Time: 11:57 AM
 */

/*
 * core class
 * Cretes url and loads core controller
 * url formate /controller/method/parameters
 */
Class Router
{
    protected $currentController = 'HomeController';
    protected $currentMethode = 'index';
    protected $params = [];


   public  function __construct()
   {

       $url = $this->getUrl();
       //look in controller first
       //usword will captilze the first letter

       if(file_exists('./Controllers/'. ucwords($url[0]). '.php'))
       {

           //if exist set as controller
           $this->currentController = ucwords($url[0]);
           //usset 0 index
           unset($url[0]);

       }

       //require the controller
       require_once $this->currentController.'.php';
       //instantiate controller class
       $this->currentController = new $this->currentController();
       //check for second part of url
       if (isset($url[1]))
       {

           //check to see if method exists in controller
           if (method_exists($this->currentController,$url[1]))
           {

               $this->currentMethode = $url[1];
                unset($url[1]);

           }
       }

       //check for parameters
       $this->params = $url ? array_values($url):[];
      //call a callback with array of params
      // print_r($this->currentMethode);
	  //print_r($this->currentController);
       call_user_func_array([$this->currentController,$this->currentMethode],$this->params);
   }

    public function getUrl()
    {
        if(isset( $_GET['url']))
        {
            //this will trim the forward slasch from url at the end
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;


        }
    }
}