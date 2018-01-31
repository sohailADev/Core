<?php
/**
* index.php, MVC-Bootstrap file
*
* index.php loads WebApp each time it is called
* 
* Set these options to debug
* error_reporting(E_ALL);
* ini_set('display_errors', 1);
*/

// ------------------------------------------------------

/**
 * Changelog
 * 10/17/2017   added no host and delimited hostname support
 * 10/30/2017   fields from $config now stored in WebApp
 * 12/14/2017   moved to new _Core configuration. Cleared out multiple site support
 */


// ------------------------------------------------------

/**
 * Extract hostname from a URL.
 * Return the hostname or full address if using a custom domain.
 *
 * @param mixed $url
 * @return string $host
*/
function getConfig($url) {
    // break down the requested URL
    $parts      = explode(".", $url);
    $pcount     = count($parts);
    $hostname   = $parts[0];
    $domain     = "$parts[1].$parts[2]";

    // no hostname
    if ($pcount == 2) {
        $domain   = "$parts[0].$parts[1]";
        $hostname = '';
    }

    // dot delimited hostname
    if ($pcount > 2) {
        $domain     = $parts[$pcount-2].".".$parts[$pcount-1];
        $parts      = array_slice($parts, 0, $pcount - 2);
        $hostname   = implode(".", $parts);
    }

    // set defaults
    $config                         = new stdClass();
    $config->hostname               = $hostname;
    $config->controller_path        = "Controllers/";
    $config->controller             = "home";
    $config->error_page             = "404";
    $config->mode                   = "test";
    $config->site_path              = "";
    $config->default_site_path      = "";
    $config->site_dir               = _BASE_PATH_ . 'sites/' . $config->site_path;
    $config->api_key                = "wredinAPI777";
    $config->api_version            = '2.0';
    $config->api_server             = '10.10.20.31';
    $config->clientid               = 'wyredinsights'; // clientid
    return $config;
}

// ------------------------------------------------------

// set system base path
define ('_BASE_PATH_',  "/var/www/html/_Core/");
require_once(_BASE_PATH_."Base/WebApp.php");

// get site config as an object
$config = getConfig($_SERVER['HTTP_HOST']);

// set api->config->mode to debug for full error reporting
if ($config->mode == 'debug') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);    
}

// set default paths and controller pages
define ('appname',          "Core");
define ('_HOST_',           isset($config->hostname)        ? $config->hostname : null);
define ('_APIKEY_',         isset($config->api_key)         ? $config->api_key : null);
define ('_APIPASS_',        isset($config->api_pass)        ? $config->api_pass : null);
define ('_APIVER_',         isset($config->api_version)     ? $config->api_version : null);
define ('_SERVER_URL_',     isset($config->api_server)      ? $config->api_server : null);
define ('_SECURE_DOMAIN_',  isset($config->secure_domain)   ? $config->secure_domain : null);
define ('_CTRL_PATH_',      isset($config->controller_path) ? $config->controller_path : 'landing-page/');
define ('_CTRL_NAME_',      isset($config->controller)      ? $config->controller : 'home');
define ('_ERROR_PAGE_',     isset($config->error_page)      ? $config->error_page : '404');
define ('_PATH_',           _BASE_PATH_);
define ('_VIEW_PATH_',      _BASE_PATH_ . "Views/");
define ('_DEF_PATH_',       _BASE_PATH_ . "Views/");
define ('site',             _BASE_PATH_ . "Views/");
define ('_DEFVIEW_PATH_',   _BASE_PATH_ . "Views/");
define ('_VIEW_URL_',       "/");
define ('_DEFVIEW_URL_',    "/");
define ('hrefbase',         "/");

// create the application object
$app = new WebApp($_GET);
$app->config    = (array)$config;
$app->default   = _CTRL_NAME_;
$app->ctrlExt   = _BASE_PATH_ . _CTRL_PATH_ . "extensions/extController.php";
// set the site mode - should be live or test - use these variables if they should reset
$app->mode      = $config->mode;
$app->clientid  = $config->clientid;

// store these values as constants to survive clearData function call
define ('_mode_',       $config->mode);
define ('_clientid_',   $config->clientid);

$constants = get_defined_constants(true);
//die(print_r($constants['user']));
// load the controller from the url or use default
$app->setController();
