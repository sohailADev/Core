<?php

/**
* extController.php, Controller class extension for white label clients
*
* extController class extends the MVC base Controller to include special cases, etc. for white label clients
*
* This is the version 1.0 of documentation
* @author Tim Berfield <tim@zoomaway.com>
* @version 1.0
* @package WL
* 
*/

/**
* extController extends Controller base class.
* This class adds special whitelabel functionality needed for main white label controllers
*/
class extController extends baseController {
    
    // -----------------------------------------------------------------------------
    
    /**
    * Output debug information. Disable this feature in production
    * 
    */
    public function debug() {
        if ($this->WebApp->mode == 'live') {
            return false;
        }
        $debug = new \debug\Debug($this->WebApp);
        $debug->display();    
    }

    // -----------------------------------------------------------------------------
}