<?php
/**
* sendPost.php, curl post class
* 
* sendPost.php contains the sendPost class definition 
* 
* This is the version 1.0 of documentation
* @author Tim Berfield <tberfield@prodasol.com>
* @version 1.0
* @package FireBalancer
*/

/**
* send XML request via cURL to the API server
*/
class sendPost {
	
	var $server_url;
	var $req;
	var $resp;
	var $errors = array();
	
    protected $status = false;	
	
	//-------------------------------------------------------------------------------------------
    
	/**
    * instantiate the call class
    * make call to = _SERVER_URL_ defined in index.php if a value is not passed
    *  
    * @param mixed $req
    * @param mixed $url
    */
    function __construct($req, $url = _SERVER_URL_) { // path to security server)
		$this->req 	 		= $req;
		$this->server_url 	= $url;
	}
	
	//-------------------------------------------------------------------------------------------
	
    /**
    * post the request via cURL
    * process the response via parseResponse
    * 
    */
	public function post() {
		$c = curl_init();
        curl_setopt($c, CURLOPT_HTTPHEADER, array("Content-Type: application/xml; charset=utf-8"));
		curl_setopt($c, CURLOPT_URL, $this->server_url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_POSTFIELDS, $this->req);
        
        $this->resp = curl_exec($c);
		curl_close($c);	

		// look for errors and set the status
		$this->parseResponse();		
	}

	//-------------------------------------------------------------------------------------------

	/**
    * process the XML document response and log any errors
    * 
    */
    private function parseResponse() {
		$xml_resp = trim((string)$this->resp);

		// look for a bad xml doc
		if ($xml = @simplexml_load_string($xml_resp)) {
		
			// look for errors back from process
			foreach ($xml->xpath('//ErrorCode') as $row) {
				array_push ($this->errors,(string)$row);
			}
            
            // look for user passed errors messages
            foreach ($xml->xpath('//ErrorMessage') as $row) {
                array_push ($this->errors,(string)$row);
            }
            
		}
		else {
			array_push($this->errors,"Internal Error");
		}

		if ( isset($this->errors[0]) && $this->errors[0] == "No data found") {
			$this->errors[0] = "Please check field data and try again";
		}
	}
	
	//-------------------------------------------------------------------------------------------
	
	/**
    * display the response for debugging
    * 
    * @param mixed $title
    */
    public function displayResponse($title = "XML Response") {
        print '<div style = "background-color: silver; width: 500px; padding: 4px; border: solid 1px silver; border-bottom: none; font-family: Arial; font-size: 11px; color: black"><b>'.$title.':</b></div>';
        print '<div style = "overflow: auto; height: 300px; width: 500px; padding: 4px; border: solid 1px silver; font-family: Arial; font-size: 11px; color: #4F4F4F">';
        print "<pre>".htmlentities($this->resp)."</pre>";
        print '</div>';        
	}

	//-------------------------------------------------------------------------------------------
	
	/**
    * display the request for debugging
    * 
    * @param mixed $title
    */
    public function displayRequest($title = "XML Request") {
        print '<div style = "background-color: silver; width: 500px; padding: 4px; border: solid 1px silver; border-bottom: none; font-family: Arial; font-size: 11px; color: black"><b>'.$title.':</b></div>';
        print '<div style = "overflow: auto; height: 300px; width: 500px; padding: 4px; border: solid 1px silver; font-family: Arial; font-size: 11px; color: #4F4F4F">';
        print "<pre>".htmlentities($this->req)."</pre>";
        print '</div>';        
	}

	//-------------------------------------------------------------------------------------------
	
	/**
    * debug the full request
    * 
    */
    public function display() {

		$this->displayRequest();
		print '<br /><br />';
		$this->displayResponse();
	}

    //-------------------------------------------------------------------------------------------

}
?>
