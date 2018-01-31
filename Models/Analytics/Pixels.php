<?php
/**
* Pixels.php, file to hold Pixel class
*
* Sets the controller path, site mode and defaults.
*/

namespace pixels;

/**
* Class to call the GetPixels API and store the results as an object.
* Look ups are based on hostname or custom_name.
* 
*/
class Pixels {
    
    /** @var mixed $data - data for find and replace */
    private $data;

    /** @var mixed $codes - pixel/analytic codes found */
    public $codes;

    //-------------------------------------------------------

    /**
     * Set the data source to look up pixels and do string replacements.
     * Get ZA standard pixels and 3rd party pixels.
     *
     * @param mixed $data - session data, i.e. WebApp
    */
    public function __construct($data) {


        /*
        $this->data = $data ? $data : $this->WebApp->AppData;

        // check if pixels have been loaded into the session
        if (empty($this->data['postVars']['pixels'])) {
            $this->getPixels();
        } else {
            $this->codes = $this->data['postVars']['pixels'];
        }
        */
    }

    // -----------------------------------------------------------------------------

    /**
     * Find pixels that match the site and tracking / affiliate criteria and load the code into _pixel_cache
     */
    private function getCache() {

    }

    // -----------------------------------------------------------------------------

    /**
     * Set the arguments as a combination of parent_id and/or hostname to find pixels by.
     *
     * @return array
     */
    private function setLookup($contract) {

        $args = array();
        if (!empty($contract['parent_id'])) {
            $args['parent_id'] = $contract['parent_id'];
        }
        if (!empty($contract['hostname'])) {
            $args['hostname'] = $contract['hostname'];
        }

        return $args;
    }


    // -----------------------------------------------------------------------------

    /**
    * Call an API to get 3rd party tracking codes
     *
    * @return boolean
    */
    private function get() {
        // set array to save all pixels in
        $save = array();

        // send session contract data to be checked
        $args = $this->setLookup($this->data['contract']);

        // if no arguments then exit with false
        if (empty($args)) {
            return false;
        }

        // call API to retrieve pixel codes
        $call = new \xmlAPI('GetPixels', _APIKEY_, 'xml', $args);
        $call->send();

        // loop codes and add to array to be saved
        while (!$call->eof) {
            $codes = $call->trackingcodes['Row'];
            foreach ($codes as $code) {
                $save[$code['events']] = $code;
            }
            $call->next();
        }

        $this->codes = $codes;
        return true;
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
    private function n_array($needle, $haystack) {
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
     * @return mixed
     */
    private function getField($field) {
        if (isset( $this->data[$field] )) {
            return $this->data[$field];
        } else {
            return $this->n_array($field, $this->data);
        }
    }

    //-------------------------------------------------------

    /**
     * Find and replace {template} fields with data
     *
     * @param $content
     * @param $data
     * @return mixed
     */
    private function replaceFields($content) {

        preg_match_all('/{(.*?)}/', $content, $matches);

        for ($x=0; $x < count($matches[1]); $x++) {
            $search  = $matches[0][$x];

            // look for a path - replace the template field with data
            $parts = explode(".", $matches[1][$x]);
            if (count($parts) > 1) {
                $str = '$replace = $this->data["postVars"]';
                for ($a=0; $a < count($parts); $a++) {
                    $str .= '["'.$parts[$a].'"]';
                }
                eval($str.";");
            }
            else {
                $replace = $this->getField($matches[1][$x]);
            }

            // update the content with data
            $content = str_replace($search, urlencode(strip_tags($replace)), $content);
        }

        return $content;
    }

    //-------------------------------------------------------

    /**
     * Display the pixel code
     *
     * @param $event - current page name
     */
    public function display($event) {
        // loop the pixels codes and show the ones for the current event / page
        foreach ($this->codes as $code) {
            if ($code['events'] == $event || $code['events'] == '*') {
                $output = $this->replaceFields($code['tracking_code']);
                print '<div style="position:absolute;">'. $output ."</div>\r\n";
            }
        }
    }

    //-------------------------------------------------------

    /**
     * Dump all pixel codes for debugging
     */
    public function debug() {
        die (print_r($this->codes));
    }

    //-------------------------------------------------------

}