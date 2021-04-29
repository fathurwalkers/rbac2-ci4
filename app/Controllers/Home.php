<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Controllers\Auth;
use CodeIgniter\RESTful\ResourceController;
use App\Filters\Auth as FilterAuth;

// header("Access-Control-Allow-Origin: * ");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
class Home extends ResourceController
{
    public function __construct()
    {
        $this->protect = new Auth();
    }
 
    public function index()
    {
        //
    }
}
