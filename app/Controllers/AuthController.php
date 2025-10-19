<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Services\JwtAuthService;
/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class AuthController extends ResourceController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function login()
    {
        try {
            $request = $this->request->getJSON(true);
            $email = $request['email'] ?? '';
            $password = $request['password'] ?? '';

            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
            ];
            if (!$this->validate($rules)) {
                return $this->respond([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ], 422);
            }
            
            $user = $this->db->table('users')->where('email', $email)->get()->getRowArray();
            if (!$user || !password_verify($password, $user['password'])) {
                return $this->respond([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $jwtService = new JwtAuthService();
            $token = $jwtService->generateToken($user);

            return $this->respond([
                'status' => true,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            log_message('error', 'AuthController.login: ' . $th->getMessage());
            return $this->respond([
                'status' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }
}
