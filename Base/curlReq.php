<?php
/**
* curlReq.php, curlReq Class File.
*
* curlReq.php contains the curlReq class definition
*
* This is the version 1.0 of documentation
* @author Tim Berfield <tberfield@prodasol.com>
* @version 1.0
* @package FireBalancer
*/

/**
* curlReq is a wrapper class around cURL. Handles basic communication to the API server.
* 
* @package MVC
* @subpackage Base
*/
class curlReq {

    /** @var string $host - the URL of the server to call */
    var $host;

    /** @var string $port - the port number to call */
    var $port;

    /** @var string $method - POST or GET method. Defaults to post */
    var $method = 'post';

    /** @var string $data - the data to pass */
    var $data;

    /** @var string $header - customer header to use in the request */
    var $header;

    /** @var integer $redirects - max number of redirects to follow */
    var $redirects = 3;

    /** @var string $userAgent - user agent to pass in cURL request */
    var $userAgent = "Zoomaway v1.0";

    /** @var integer $timeout - timeout setting for the request */
    var $timeout = 45;

    /** @var integer $contimeout - connection timeout */
    var $contimeout = 45;

    /** @var string $resp - cURL responce */
    var $resp;

    /** @var string $error - cURL error number */
    var $error;

    /** @var mixed $resultCode - cURL http code */
    var $resultCode;

    /** @var mixed $resultArray - cURL getinfo */
    var $resultArray;

    //------------------------------------------

	/**
    * Instantiate the class. 
    * 
    * @param mixed $host
    * @param mixed $method
    * @param mixed $data
    * @param mixed $header - field is optional 
    */
    function __construct($host, $method, &$data, $header = null) {
		$this->host     = $host;
		$this->request  = $request;
        $this->data     = $data;
        $this->header   = $header;

        // set post as the default method
        if ($this->method != $method) {
          $this->method = "post";  
        } 
        
	}

    //------------------------------------------
    
    /**
    * send the request using cURL.
    * 
    * @return mixed $this->output - curl_exec result.
    * @return mixed $this->resultArray - curl_getinfo.
    * @return mixed $this->resultCode - http_code of the call.
    * @return mixed $this->error - curl_errno | error number.
    */
    public function send() {
        $ch = curl_init();

        // set a special port if specified
        if ($this->port) {
            curl_setopt($ch, CURLOPT_PORT,$this->port); 
        }
        
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent); // agent / browser name
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return the web page
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout); // set response connection timeout default = 45
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->contimeout); // set response timeout default = 45
        curl_setopt($ch, CURLOPT_HEADER, 0); // do not return headers
        
        // follow number of max redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_MAXREDIRS, $this->redirects); 

        // do not verify ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // add the header if specified                
        if ($this->header) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->header);
        }

        // send for get or post
        if ($this->method == "get") {
            curl_setopt($ch, CURLOPT_URL, $this->host . "?" .$this->data);
        }
        else {
            curl_setopt($ch, CURLOPT_URL, $this->host);
            curl_setopt($ch, CURLOPT_POST, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data); 
        }

        // submit the request and collect the results
        $this->output = curl_exec($ch);
        $this->resultArray = curl_getinfo($ch);        
        $this->resultCode = $results['http_code'];
        $this->error = curl_errno($ch);

        curl_close ($ch);
	}

    //------------------------------------------

} 

?>