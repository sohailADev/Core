<?php
/**
* home.php, Home page controller
*
* Home class extends the MVC extController class
*
* This is the version 2.0 of documentation
* @author Tim Berfield <tim@zoomaway.com>
* @version 1.2
* @package WL
*/

/**
* Custom controller for Contact page, extends Controller base class.
*
*/
class Contact extends extController {

    // ---------------------------------------------------------------------------------

    /**
     * Check that the user came from this same server
     *
     * @return bool
     */
    private function checkSource() {
        if ($_SERVER['REDIRECT_SSL_TLS_SNI'] != $_SERVER['SERVER_NAME']) {
            return false;
        }
        return true;
    }

    // -----------------------------------------------------------------------------

    /**
     * check fields and submit the lead to the CreateLead API. Uses $_POST data
     * $post = array('fname' => 'tim', 'lname' => 'berfield', 'email' => 'tberfield@prodasol.com', 'phone' => '+1(702) 239-1755', 'comment' => 'this is a comment');
     *
     */
    public function process() {
        $post = $_POST; // save the fields posted via form submission

        // make sure page was submitted from this server
        if (!$this->checkSource()) {
            $this->setError('Unauthorized Process');
        }

        // redirect if the contact has already been logged
        if ($this->WebApp->isLogged('contact')) {
            $this->redirect('home');
        }

        // break up the phone number if present
        $phParts = $this->prepPhone($post['phone']);

        // create the args array
        $args = array('mode' => 'live', 'fname' => $post['fname'], 'lname' => $post['lname'], 'email' => $post['email'], 'comment' => $post['comment'], 'ccode' => $phParts['ccode'], 'area' => $phParts['area'], 'phone' => $phParts['phone']);

        // call the API
        $lead = new xmlAPI('CreateLead', _APIKEY_, 'xml', $args);
        $lead->send();
        $message = '';

        // charge approved - go to confirmation
        if ($lead->Status == 'OK' && $lead->leadid) {
            $this->WebApp->addLog('contact');
            $message = $lead->message;
        }

        // declined or error condition, get the errors
        if ($lead->STATUS != 'OK') {
            if (is_array($lead->errors)) {
                foreach ($lead->errors as $error) {
                    $message .= $error . '<br />';
                }
            }
        }

        // output the result as json
        $output = json_encode(array('status' => $lead->Status, 'message' => $message));
        die ($output);
    }

    // -----------------------------------------------------------------------------

    /**
     * strip non-numeric characters and break the phone number into components
     *
     * @param $src
     * @return array - code, area, phone
     */
    private function prepPhone($src) {
        $src = preg_replace("/[^0-9,.]/", "", $src ); // strip non-numbers
        $parts = array(
            'phone' =>  substr($src, (strlen($src)-7), 7),
            'area' =>   substr($src, (strlen($src)-10), 3),
            'ccode' =>  substr($src, 0, (strlen($src)-10))
        );

        return $parts;
    }

    // -----------------------------------------------------------------------------

}

// ---------------------------------------------------------------------------------

/**
* Init controller
* @param $this - current WebApp Object
* @param "contact" name of controller
*/
$myCtrl = new Contact($this, "contact");

// set the page title
$myCtrl->pagetitle = "Contact Us";

// add the html view - usually same name as the controller
$myCtrl->addContent($myCtrl->pagename);

// Route the action / execute the function
$myCtrl->routeAction('render');