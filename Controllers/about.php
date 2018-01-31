<?php
/**
* about.php, about page controller
*
* About class extends the MVC extController class
*
* This is the version 2.0 of documentation
* @author Tim Berfield <tim@zoomaway.com>
* @version 1.2
* @package WL
*/

/**
* Custom controller for About page, extends Controller base class.
*
*/
class About extends extController {
}

// ---------------------------------------------------------------------------------

/**
* Init controller
* @param $this - current WebApp Object
* @param "about" name of controller
*/
$myCtrl = new About($this, "about");

// set the page title
$myCtrl->pagetitle = "About Us";

// add the html view - usually same name as the controller
$myCtrl->addContent($myCtrl->pagename);

// Route the action / execute the function
$myCtrl->routeAction('render');