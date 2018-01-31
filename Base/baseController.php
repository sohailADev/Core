<?php
/**
* baseController.php, MVC baseController File
*
* baseController.php contains the baseController class definition
*
* This is the version 2.01
* @author Tim Berfield <tim@wyredin.com>
* @version 2.01
* @package MVC
*/

/**
* baseController is the base for each Controller and is extended for further functionality
* An instance of WebApp is passed to baseController
 *
* @package MVC
* @subpackage Base
*/
class baseController {
    /** @var mixed $contentArray - Array of views to render */
    private $contentArray = array();

    /**
    * @var boolean $allowBadFunctions - Rule if function called is missing.
    *
    * False: second url argument to 404.
    * True: treat as input data
    */
    private $allowBadFunctions = true;

    /** @var mixed $_mods_loaded - list of models that have been loaded by this baseController */
    private $_mods_loaded = array();

    /** @var mixed $WebApp - link to the WebApp Object that called this baseController */
    public $WebApp;

    /** @var mixed $contentArray - Array of views to render */
    public $defaultAction = 'render';

    /** @var mixed $input - Array of $_POST or other fields used as input to this baseController */
    public $input;

    /** @var mixed $vars - Array of user data. */
    public $vars = array();

    /** @var string $pagename - Name of the page. */
    public $pagename;

    /** @var string $pagetitle - Page title to display, usually in propper case. */
    public $pagetitle;

    /** @var mixed $jsVars - Array of values to output for javascript. */
    public $jsVars  = array();

    //-------------------------------------------------------

    /**
    * Check for existance and readability of a file.
    *
    * @param string $file - File to check.
    *
    * @return boolean
    */
    private function goodFile($file) {
        if (file_exists($file) && is_readable($file)) {
            return true;
        }
        return false;
    }

    //-------------------------------------------------------

    /**
    * linkFile is used to generate the URL of a js or css file with fallback to a default location
    *
    * @param mixed $name - Name of the file i.e. footer.php
    * @param mixed $location - Predefined file location
     *
     * @return mixed - path or link to file
    */
    protected function linkFile($name, $location, $debug = false)
    {
        switch (strtolower($location))
        {
            case 'jsview':
            case 'jsviews':
                $url        = _VIEW_URL_    . "Assets/js/views/$name";
                $alt_url    = _DEFVIEW_URL_ . "Assets/js/views/$name";
                $file       = _PATH_        . "Assets/js/views/$name";
                $alt_file   = _DEF_PATH_    . "Assets/js/views/$name";
                $action     = 'print';
                break;

            case 'js':
                $url        = _VIEW_URL_    . "Assets/js/$name";
                $alt_url    = _DEFVIEW_URL_ . "Assets/js/$name";
                $file       = _PATH_        . "Assets/js/$name";
                $alt_file   = _DEF_PATH_    . "Assets/js/$name";
                $action     = 'print';
                break;

            case 'jslibs':
            case 'libs':
                $url        = 'Assets/js/lib/' . "$name";
                $alt_url    = 'Assets/js/lib/' . "$name";
                $file       = 'Assets/js/lib/' . "$name";
                $alt_file   = 'Assets/js/lib/' . "$name";
                $action     = 'pass';
                break;

            case 'img':
            case 'imgs':
            case 'image':
            case 'images':
                $url        = _VIEW_URL_    . "Assets/img/$name";
                $alt_url    = _DEFVIEW_URL_ . "Assets/img/$name";
                $file       = _PATH_        . "Assets/img/$name";
                $alt_file   = _DEF_PATH_    . "Assets/img/$name";
                $action     = 'print';
                break;

            case 'css':
            case 'style':
            case 'styles':
                $url        = _VIEW_URL_    . "Assets/css/$name";
                $alt_url    = _DEFVIEW_URL_ . "Assets/css/$name";
                $file       = _PATH_        . "Assets/css/$name";
                $alt_file   = _DEF_PATH_    . "Assets/css/$name";
                $action     = 'print';
                break;

            case 'php':
            case 'include':
            case 'includes':
                $file       = _PATH_        . "Includes/$name";
                $alt_file   = _DEF_PATH_    . "Includes/$name";
                $action     = 'include';
                break;
        }

        // exit with output if debug
        if ($debug)
        {
            die ("file = $file <br />alt = $alt_file");
        }

        switch ($action)
        {
            case 'pass':
                print $url;
                break;

            case 'print':
                if ($this->goodFile($file)) {
                    print $url;
                } elseif ($this->goodFile($alt_file)) {
                    print $alt_url;
                }
                break;

            case 'include':
                if ($this->goodFile($file))
                {
                    return $file;
                }
                elseif ($this->goodFile($alt_file))
                {
                    return $alt_file;
                }
                break;
        }
    }

    //-------------------------------------------------------

    /**
    * Recurse the array of data until target is found
    *
    * @param mixed $needle - field name to find
    * @param mixed $haystack - array to search
     *
     * @return mixed $out
    */
    public function n_array($needle, $haystack) {
        foreach ($haystack as $key => $value) {
            if ($key === $needle) {
                return $value;
            }
            elseif (is_array($value)) {
                $out = $this->n_array($needle, $value);
                if ($out) {
                    return $out;
                }
            }
        }
    }

    //-------------------------------------------------------

    /**
    * Get a field from the class data array.
    *
    * @param mixed $field
     *
     * @return mixed
    */
    public function __get($field) {
        if (isset( $this->vars[$field] )) {
            return $this->vars[$field];
        } else {
            return $this->n_array($field, $this->WebApp->postVars);
        }
    }

    //-------------------------------------------------------

    /**
    * Set a value on the class data array.
    *
    * @param mixed $field
    * @param mixed $value
    */
    public function __set($field, $value) {
        $this->vars[$field] = $value;
    }

    //-------------------------------------------------------

    /**
    * Check if field is set - Only checks vars
    *
    * @param string $field
     *
     * @return mixed
    */
    public function __isset($field) {
        if (isset($this->vars[$field])) {
            return true;
        } else {
            return $this->n_array($field, $this->WebApp->postVars);
        }
    }

    //-------------------------------------------------------

    /**
    * Inaccessible method was called, return false
    *
    * @param string $name
    * @param mixed $data
    *
    * @return boolean
    */
    public function __call($name=null, $data=null) {
        return false;
    }

    //-------------------------------------------------------

    /**
    * baseController class.
    * Set pagename and title if passed, these are often used with navigation.
    * Store session data saved for this page in vars. This replaces posted data.
    *
    * @param mixed $WebApp - link to WebApp calling object.
    * @param string $name - not required, can be set as a property.
    */
    public function __construct($WebApp, $name = null) {
        $this->WebApp = $WebApp;
        $this->pagename = $name;
        $this->pagetitle = ucwords($name);

        // save data in vars if set in session
        if (isset($this->WebApp->postVars[$this->pagename])) {
            $this->vars = $this->WebApp->postVars[$this->pagename];
        }
    }

    //-------------------------------------------------------

    /**
    * Simple function to redirect to another page.
    *
    * @param string $pageName
    */
    public function redirect($pageName) {
        // check for a leader "/" add it if missing
        if (substr($pageName, 0, 1) != '/') {
            $pageName = '/' . $pageName;
        }
        header ('Location: http://' . $_SERVER['HTTP_HOST'] . $pageName);
        exit();
    }

    //-------------------------------------------------------

    /**
    * Redirect to a secure version of the current page.
    *
    * @param integer $port - defaults to 443.
    */
    public function securePage($port = 443) {
        if ($_SERVER['SERVER_PORT'] != $port) {

            // check for a custom domain
            if (_SECURE_DOMAIN_) {
                $domain = _SECURE_DOMAIN_ ? _SECURE_DOMAIN_ : $_SERVER['HTTP_HOST'];
                $path = _HOST_ . ".$domain" . $_SERVER['REQUEST_URI'];
                $path .= "/id=" . session_id();
            }
            else {
                $path =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }
            header ("Location: https://$path");
            exit();
        }
    }

    //-------------------------------------------------------

    /**
    * Route the action or function.
    * If the method called doesn't exist, the default is called the method treated as data.
    *
    * @param string $call - Uses the default if blank.
    */
    public function routeAction($call = null) {
        // use the passed function name or the baseController default
        $stmt = $call ? $call : $this->defaultAction;

        // 404 error if no statement
        if (!$stmt) $this->redirect('404');

        // make sure routing is enabled
        if ($this->WebApp->routing) {
            // keep the same function if this is called more than once
            if ($this->WebApp->function) {
                $stmt = $this->WebApp->function;
            }

            // make sure the method exists
            if (!method_exists($this,$stmt)) {
                // if the default action does not exist then go to 404 error
                if ($stmt == $this->defaultAction) {
                    $this->redirect('404');
                }

                // allow bad functions will force the default action to execute
                if (!$this->allowBadFunctions) {
                    $this->redirect('404');
                } else {
                    // set the default function and statement
                    $this->WebApp->function = $this->defaultAction;
                    $stmt = $this->defaultAction;
                }
            }

            // execute the statement. passing the params - this invokes __call
            $this->$stmt($this->WebApp->param, $this->WebApp->params);
        }
    }

    //-------------------------------------------------------

    /**
    * Add html content to the content array to be rendered.
    *
    * @param mixed $content
    */
    public function addContent($content) {
        array_push($this->contentArray, "$content.php");
    }

    //-------------------------------------------------------

    /**
    * Set the html content, over-riding anything added previously.
    *
    * @param mixed $content
    */
    public function setContent($content) {
        $this->contentArray = array("$content.php");
    }

    //-------------------------------------------------------

    /**
    * Include model code. Return true if loaded or already loaded / false if cannot be loaded.
    *
    * @param mixed $model
    * @return boolean
    */
    public function loadModel($model) {

        die (_BASE_PATH_."Models/$model.php");

        if ( include_once(_BASE_PATH_."Models/$model.php") ) {
            $this->_mods_loaded[$model] = true;
            return true;
        }
        return false;
    }

    //-------------------------------------------------------

    /**
     * Check if fields in the array have been set.
     *
     * @param $fields
     * @param bool $recursive
     *
     * @return bool
     */
    public function validate($fields, $recursive = false) {
        // loop the fields
        foreach ($fields as $field) {
            // recursive field search
            if ($recursive && !isset($this->$field)) {
                return false;
            }
            // standard field search
            if (!$recursive && !isset($this->vars[$field])) {
                return false;
            }
        }
        return true;
    }

    //-------------------------------------------------------

    /**
    * Render the html view. Any html files included in the contentArray are rendered.
    * If the html page doesn't exist, use the view from the default directory.
    *
    */
    public function render() {
        // include the each content page
        foreach ($this->contentArray as $content) {
            if (@!include(_VIEW_PATH_ . "$content")) {
                if (@!include(_DEFVIEW_PATH_."$content")) {
                    $this->redirect('404');
                }
            }
        }
    }

    //-------------------------------------------------------

    /**
    * Output jsVars array as javascript variable definition.
    *
    */
    public function getVars() {
        print "\n\t<script type='text/javascript'>\r\n";

        // loop the array and output a javascript cariable definitikon for each one
        foreach ( $this->jsVars as $key => $value ) {
            if (is_array($value)) {
                 print "\t\tvar $key = ".json_encode($value, JSON_UNESCAPED_SLASHES).";\r\n";
            } else {
                print "\t\tvar $key = '$value';\r\n";
            }
        }
        print "\t</script>\r\n";
    }

    // -----------------------------------------------------------------------------

}