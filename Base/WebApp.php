<?php
/**
 * WebApp.php, Main MVC File
 *
 * WebApp.php contains the WebApp class definition
 *
 * This is the version 1.0 of documentation
 * @author Tim Berfield <tberfield@prodasol.com>
 * @version 1.0
 * @package MVC
 */

/**
 * WebApp is the base application controller and bootstrap class
 * It is called each time index.php is called via the routing.
 * Example: host.domain.com/controller/function/param
 *
 * Help:
 * "input" is data in the postVars Array
 *
 * @package MVC
 * @subpackage Base
 */
class WebApp {

    /** @var string $SArrayName - The name of the session sub-array to hold app values */
    var $SArrayName = "AppData";

    /** @var boolean $routing - Enable or disable routing */
    var $routing = true;

    /** @var string $mode Site mode live or test */
    var $mode = 'live';

    /** @var string $controller The first parameter on $_GET */
    var $controller;

    /** @var string $ctrlExt - extension to base class */
    var $ctrlExt;

    /** @var string $function The second parameter on $_GET */
    var $function;

    /** @var string $param The third parameter on $_GET  */
    var $param;

    /** @var mixed $params Parameters passed on $_GET after first controller/function/param */
    var $params = array();

    /** @var mixed $calls Full set of original parameters passed on $_GET */
    var $calls = array();

    /** @var mixed $lifetime Lifetime of the session cookie, defined in seconds.  */
    var $lifetime = 0;

    /** @var mixed $path Path on the domain where the cookie will work. Use a single '/' for all paths on the domain. */
    var $path = '/';

    /** @var mixed $lifetime Cookie expiration in seconds */
    var $domain = 0;

    /** @var mixed $secure True to send cookie only over secure connections */
    var $secure = false;

    /** @var mixed $httponly Attempt to send the httponly flag when setting session cookie */
    var $httponly = true;

    /** @var string $default Default controller to use */
    var $default;

    /** @var array $config - store config options */
    var $config = array();

    //-------------------------------------------------------

    /**
     * Session handling and routing. If enabled, route to the requested controller.
     *
     * @param mixed $getPath - i.e. $app = new WebApp($_GET);
     */
    public function __construct($getPath) {
        // check for a session_id passed on the URL
        $id = $this->checkId();

        // get the settings defined in php.ini
        $params = session_get_cookie_params();

        // set any missing params
        $this->lifetime = $this->lifetime   ? $this->lifetime   : $params['lifetime'];
        $this->path     = $this->path       ? $this->path       : $params['path'];
        $this->domain   = $this->domain     ? $this->domain     : $params['domain'];
        $this->secure   = $this->secure     ? $this->secure     : $params['secure'];
        $this->httponly = $this->httponly   ? $this->httponly   : $params['httponly'];

        // set session options and start the session
        session_set_cookie_params($this->lifetime, $this->path, $this->domain, $this->secure, $this->httponly);

        // load passed session_id
        if ($id) session_id($id);

        session_start();

        // get the path to the requested controller
        if ($this->routing) {
            $this->routeController($getPath);
        }
    }

    //-------------------------------------------------------

    /**
     * Look for a session_id to be passed on the url.
     * This method only works with url rewrite.
     *
     * URL params are altered /controller/id=xxxx as /controller/id
     * If id is found, return the value {xxxx}
     *
     * @return mixed
     */
    private function checkId() {
        // get the / delimited params
        foreach ($_GET as $key => $value) {
            $fields = explode('/', $key);

            // look for the id param
            foreach ($fields as $field) {
                if ($field == "id") {
                    return $value;
                }
            }
        }
        return false;
    }

    //-------------------------------------------------------

    /**
     * Read the values on the url, set the routing values as controller/function/value
     *
     * $this->controller   = $params[0];
     * $this->function     = $params[1];
     * $this->param        = $params[2];
     */
    private function routeController() {
        // figure out which controller to run
        foreach ($_GET as $key => $value) {
            $this->params = explode("/",$key);
            break;
        }

        // save the params before being shifted
        $this->calls        = $this->params;
        $this->controller   = array_shift($this->params);
        $this->function     = array_shift($this->params);
        $this->param        = array_shift($this->params);
    }

    //-------------------------------------------------------

    /**
     * Check for existence and readability of $file.
     * If redirect is set true, die with a 404 error; usually used if no 404 page has been set.
     *
     * @param string $file - File to check.
     * @param boolean $redirect - treu if user should get a simple 404 message.
     *
     * @return boolean
     */
    private function goodFile($file, $redirect = false) {
        if (file_exists($file) && is_readable($file)) {
            return true;
        } elseif ($redirect) {
            die('404 Error - could not load the requested page');
        }
        return false;
    }

    //-------------------------------------------------------

    /**
     * Load the controller base class and extension class
     *
     * @param string $ctrl - Extension class to load.
     */
    private function loadController($ctrl) {
        // load base controller class
        require_once(_BASE_PATH_."Base/baseController.php");

        // load extension to controller
        if (isset($this->ctrlExt)) {
            if ($this->goodFile($this->ctrlExt)) {
                require_once($this->ctrlExt);
            }
        }

        // load request page controller
        include_once($ctrl);
    }

    //-------------------------------------------------------

    /**
     * Display the defined constants - usually set by index.php
     */
    public function _debug_constants() {
        $const = get_defined_constants(true);
        die (print_r($const['user']));
    }

    //-------------------------------------------------------

    /**
     * Choose the requested controller, default controller if blank, error page or 404 page.
     * requested -> default -> error -> 404
     *
     * @param string $ldName - Name of the controller to load.
     * @return bool
     */
    public function setController($ldName = null) {
        // get the passed controller name or default if blank
        $ldName = $ldName ? $ldName : ($this->controller ? $this->controller : $this->default);

        // set the full path to the requested controller or to the error handler controller i.e. 404
        $ldPath     = _BASE_PATH_._CTRL_PATH_. str_replace("_php","",$ldName).'.php';
        $ldError    = _BASE_PATH_._CTRL_PATH_._ERROR_PAGE_.'.php';
        $ld404      = _BASE_PATH_._CTRL_PATH_.'404.php';

        // Check for the controller, go to the error controller if it does not exist
        if ($this->goodFile($ldPath, false)) {
            $this->loadController($ldPath);
            return true;
        }

        // check for a defined error controller
        if ($this->goodFile($ldError, false)) {
            $this->loadController($ldError);
            return true;
        }

        // attempt to load 404 controller, display message if there isn't one
        if ($this->goodFile($ld404, true)) {
            $this->loadController($ld404);
        }
        return false;
    }

    //-------------------------------------------------------

    /**
     * Clear array of fields from the postVars array.
     * Loop the session storage array and unset the named fields
     *
     * @param mixed $fields
     * @return boolean
     */
    public function clearInput($fields) {
        if (is_array($this->postVars)) {
            foreach ($fields as $field) {
                unset($_SESSION[$this->SArrayName][$field]);
            }
            return true;
        }
        else {
            return false;
        }
    }

    //-------------------------------------------------------

    /**
     * Save $data to the session array.
     * Sets postVars Array. Data is merged with any existing values.
     *
     * @param mixed $data
     * @return bool - true if successful
     */
    public function addInput($data, $detail = null) {
        // make sure an array of data was passed or exit
        if (!is_array($data)) {
            if (isset($detail)) {
                $name = $data;
                $data = array();
                $data[$name] = $detail;
            } else {
                return false;
            }
        }

        // merge post with existing data if it exists
        if (is_array($this->postVars)) {
            $this->postVars = array_merge($this->postVars, $data);
        } else {
            $this->postVars = $data;
        }
        return true;
    }

    //-------------------------------------------------------

    /**
     * Save $data to the session array.
     * Sets postVars Array. Data is merged with any existing values.
     *
     * @param string $field - subarray name
     * @param mixed $data - array of data to change
     *
     * @return bool - true if successful
     */
    public function editInput($field, $data = null) {
        // exit if a string has not been passed
        if (gettype($field) != 'string') {
            return false;
        }

        // if the data is an array merge with any existing data
        if (is_array($this->postVars[$field])) {
            if (is_array($this->postVars[$field])) {
                $_SESSION[$this->SArrayName]['postVars'][$field] = array_merge($this->postVars[$field], $data);
            }
            else {
                $_SESSION[$this->SArrayName]['postVars'][$field] = $data;
            }
        }
        return true;
    }

    //-------------------------------------------------------

    /**
     * Clear user stored session user data data.
     */
    public function clearData() {
        unset($_SESSION[$this->SArrayName]);
    }

    //-------------------------------------------------------

    /**
     * Add or increment a logged event.
     *
     * @param string $event - name of event to log
     */
    public function addLog($event) {
        // create the event
        if (!isset($_SESSION[$this->SArrayName]['_logging'][$event])) {
            $_SESSION[$this->SArrayName]['_logging'][$event] = 1;
        } else {
            $_SESSION[$this->SArrayName]['_logging'][$event] ++; // increment its counter
        }
    }

    //-------------------------------------------------------

    /**
     * Delete a logged event from the memory.
     * Unsets the value in _logging array.
     *
     * @param mixed $event - name of event to delete
     */
    public function delLog($event) {
        unset($_SESSION[$this->SArrayName]['_logging'][$event]);
    }

    //-------------------------------------------------------

    /**
     * Check if an event has been logged.
     *
     * @param mixed $event - name of logged event
     * @return integer - count of times event has been logged
     */
    public function isLogged($event) {
        $output = null;
        if (isset($_SESSION[$this->SArrayName]['_logging'][$event])) {
            $output = $_SESSION[$this->SArrayName]['_logging'][$event];
        }

        return $output;
    }

    //-------------------------------------------------------

    /**
     * Get a value from the data array.
     * The entire array can me returned if SArrayName is passed.
     *
     * @param string $field
     * @return mixed
     */
    public function __get($field) {
        $output = null;

        if ($field == 'config') {
            return ($this->config);
        }

        if ($field == $this->SArrayName) {
            return ($_SESSION[$this->SArrayName]);
        }

        if (isset($_SESSION[$this->SArrayName][$field])) {
            $output = $_SESSION[$this->SArrayName][$field];
        }

        return $output;
    }

    //-------------------------------------------------------

    /**
     * Set a value on the data array.
     *
     * @param string $field - field to store i.e. AppData[$field]
     * @param mixed $value - value to store i.e. AppData[$field] = $value;
     */
    public function __set($field, $value = null) {
        $_SESSION[$this->SArrayName][$field] = $value;
    }

    //-------------------------------------------------------

    /**
     * Unset field from object's data array.
     *
     * @param string $field Field to remove
     * @return bool - true if unset
     */
    public function __unset($field) {
        if ( isset($_SESSION[$this->SArrayName][$field]) ) {
            unset( $_SESSION[$this->SArrayName][$field] );
            return true;
        } else {
            return false;
        }
    }

    //-------------------------------------------------------

    /**
     * Check if field is set in object's data array.
     *
     * @param string $field - Field to remove
     * @return bool
     */
    public function __isset($field) {
        return (isset($_SESSION[$this->SArrayName][$field]));
    }

    //-------------------------------------------------------

    /**
     * Store a value directly on the session.
     *
     * @param mixed $field
     * @param mixed $value
     */
    public function save($field, $value) {
        if ($field != $this->SArrayName) {
            $_SESSION[$field] = $value;
        }
    }

    //-------------------------------------------------------

    /**
     * Store submitted page data in $postVars[$page] and redirect to $page.
     * Fixes invalid session errors moving back and forth between pages with form submits.
     *
     * @param $page
     * @param null $data
     * @param int $port
     * @param null $function
     */
    public function submitPage($page, $data = null, $port = 80, $function = null) {
        // set default protocol
        $protocol = 'http://';
        $portNum = $port ? $port : $_SERVER['SERVER_PORT'];

        // set data for the next page in the session
        $temp[$page] = $data;
        $this->addInput($temp);

        if ($portNum != '80') {
            $protocol = 'https://';
        }

        if (!empty($function)) {
            $page .= "/$function";
        }

        header('Location: '.$protocol.$_SERVER['HTTP_HOST'] .'/'.$page);
        exit();
    }

    //-------------------------------------------------------

}
