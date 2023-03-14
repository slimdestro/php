<?php 
// http tracer. 
// tried implementing http-tracer from golang in php

// Start the tracer
function startTracer() {
    ob_start();
}

// Stop the tracer
function stopTracer() {
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

// Get the HTTP request headers
function getRequestHeaders() {
    $headers = array();
    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) == 'HTTP_') {
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
    }
    return $headers;
}

// Get the HTTP response headers
function getResponseHeaders() {
    $headers = array();
    foreach (headers_list() as $header) {
        list($key, $value) = explode(':', $header);
        $headers[$key] = $value;
    }
    return $headers;
}

// Get the HTTP request body
function getRequestBody() {
    return file_get_contents('php://input');
}

// Get the HTTP response body
function getResponseBody() {
    return stopTracer();
}

// Log the HTTP request and response
function logRequestResponse() {
    $request = array(
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'headers' => getRequestHeaders(),
        'body' => getRequestBody()
    );
    $response = array(
        'status' => http_response_code(),
        'headers' => getResponseHeaders(),
        'body' => getResponseBody()
    );
    // Log the request and response
    error_log(json_encode(array('request' => $request, 'response' => $response)));
}

// Start the tracer
startTracer();

// Register a shutdown function to log the request and response
register_shutdown_function('logRequestResponse');
      