<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Users;
use App\Filters\AuthFilter;
use Config\Service;

class AuthController extends ResourceController
{
    public function __construct()
    {
        $this->checkauth = new Users();
    }

    public function login()
    {
        $session = session();
        $token = $session->get('token');
        $exp = $session->get('exp');
        $users_Email      = $this->request->getPost('users_Email');
        $users_Password   = $this->request->getPost('users_Password');
 
        $cek_login = $this->checkauth->cek_login($users_Email);
 
        if (password_verify($users_Password, $cek_login['users_Password'])) {
            $dataEncoded = array(
                "users_Id" => $cek_login['users_Id'],
                "users_Fullname" => $cek_login['users_Fullname'],
                "users_Email" => $cek_login['users_Email']
            );
            $jwt = new AuthFilter($dataEncoded);
            $jwt->filterJWT($cek_login);
            $output = [
                'status' => 200,
                'message' => 'Berhasil login',
                "token" => $token,
                "users_Email" => $dataEncoded['users_Email'],
                "expireAt" => $exp
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 401,
                'message' => 'Login failed',
                "users_Password" => $users_Password
            ];
            return $this->respond($output, 401);
        }
    }

    public function register()
    {
        $users_Fullname  = $this->request->getPost('users_Fullname');
        $users_Email      = $this->request->getPost('users_Email');
        $users_Password   = $this->request->getPost('users_Password');
        $users_Code   = $this->request->getPost('users_Code');
        $users_Status   = $this->request->getPost('users_Status');
 
        $password_hash = password_hash($users_Password, PASSWORD_BCRYPT);
 
        $data = json_decode(file_get_contents("php://input"));
 
        $dataRegister = [
            'users_Fullname' => $users_Fullname,
            'users_Email' => $users_Email,
            'users_Code' => $users_Code,
            'users_Status' => $users_Status,
            'users_Password' => $password_hash
        ];
 
        $register = $this->checkauth->register($dataRegister);
 
        if ($register == true) {
            $output = [
                'status' => 200,
                'message' => 'Berhasil register'
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Gagal register'
            ];
            return $this->respond($output, 400);
        }
    }

    public function logout()
    {
        helper('cookie');
        // $this->session->flush();
        delete_cookie('');
        return $this->respond([
            'message' => 'Logout Berhasil!',
        ], 200);
    }
}
