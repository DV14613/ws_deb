<?php
class ErrorController {    
    public function index() {
        $response = array();
        $response[] = ['error' => "404 Not Found"];			
        echo json_encode($response);          
    } 
}
