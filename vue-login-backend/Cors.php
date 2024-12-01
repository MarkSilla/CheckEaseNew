<?php
// CORS Headers
header("Access-Control-Allow-Origin: *"); // Allow all origins, change * to a specific domain if needed (e.g., 'http://localhost:5178')
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-Custom-Header");
header("Access-Control-Expose-Headers: Content-Length, X-Knowledge-Base-API-Key");
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Credentials: true");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit(); 
}

?>
