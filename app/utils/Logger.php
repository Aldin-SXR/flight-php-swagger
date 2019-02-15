<?php

class Logger {
    private $file_name;
    private $dir_path;

    public function __construct($file_name) {
        $this->file_name = $file_name;
    }

    private function process_response($response) {
        $reflectionClass = new ReflectionClass(get_class($response));
        $body = $reflectionClass->getProperty("body");
        $body->setAccessible(true);
        $code = $reflectionClass->getProperty("status");
        $code->setAccessible(true);
        return [
            "code" => $code->getValue($response),
            "body" => json_decode($body->getValue($response), true)
        ];
    }

    public function log($request, $response) {
        ob_end_flush();
        $log = [
            "date" => date('Y-m-d H:i:s'),
            "client_ip" => $request->ip,
            "method" => $request->method,
            "route" => $request->url,
            "query_params" => json_encode($request->query->getData()),
            "request_body" => json_encode($request->data->getData()),
            "response" => json_encode($this->process_response($response)),
            "request_headers" => json_encode(getallheaders()),
            "response_headers" => json_encode(apache_response_headers())
        ];
        $log = implode("\t", $log)."\n";
        
        file_put_contents($this->file_name, print_r($log, true), FILE_APPEND);
    }
}

/**
 * Replacement functions for Nginx setups.
 */

 /* Get all request headers */
if (!function_exists("getallheaders")) {
    function getallheaders() {
        $headers = []; 
        foreach ($_SERVER as $name => $value) { 
            if (substr($name, 0, 5) == 'HTTP_')  { 
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
            } 
        } 
        return $headers; 
    }
}

/* Get all response headers */
if (!function_exists('apache_response_headers')) {
    function apache_response_headers_2 () {
        $arh = array();
        $headers = headers_list();
        foreach ($headers as $header) {
            $header = explode(":", $header);
            $arh[array_shift($header)] = trim(implode(":", $header));
        }
        return $arh;
    }
}