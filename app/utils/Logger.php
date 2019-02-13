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
        $log = [
            "date" => date('Y-m-d H:i:s'),
            "client_ip" => $request->ip,
            "method" => $request->method,
            "route" => $request->url,
            "query_params" => $request->query->getData(),
            "request_body" => $request->data->getData(),
            "response" => $this->process_response($response)
        ];
        /* Write to file */
        // if (!is_dir($this->dir_path)) {
        //     mkdir($this->dir_path, 0777, true);
        //     file_put_contents($this->dir_path."/.htaccess", "Deny from all");
        // }
        file_put_contents($this->file_name, print_r($log, true)."=================================\n", FILE_APPEND);
    }
}