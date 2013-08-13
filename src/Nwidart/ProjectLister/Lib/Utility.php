<?php namespace Nwidart\ProjectLister\Lib;

class Utility {
    /**
     * Fetch a web resource by URL
     * @param string $url The HTTP URL that the request is being made to
     * @param array  $options Any PHP cURL options that are needed
     * @return object An object with properties of 'url', 'body', and 'status'
     */
    public static function fetch($url, $options = array())
    {
        if(!function_exists('curl_exec'))
        {
            if(!$options) return file_get_contents ($url);
            else return '';
        }

        $curl_handle  = curl_init($url);
        $curl_version = curl_version();

        $options    += array(CURLOPT_RETURNTRANSFER => true);
        $options    += array(CURLOPT_USERAGENT      => "curl/".$curl_version['version']);

        curl_setopt_array($curl_handle, $options);

        $timer = "Call to $url via HTTP";

        $body   = curl_exec($curl_handle);
        $status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

        return $body;
    }
    /**
     * Issues an HTTP GET request to the specified URL
     * @param string $url
     * @return object An object with properties of 'url', 'body', and 'status'
     */
    public static function get($url)
    {
        return self::fetch($url);
    }
}
