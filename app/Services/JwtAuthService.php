<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\RequestInterface;
use Exception;

class JwtAuthService
{
    protected $request;
    protected $key;
    protected $algo = 'HS256';

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->key = env('jwt.secret_key', 'secret-key-1234567890');
    }

    public function authenticateUser()
    {
        try {
            $authHeader = $this->request->getHeaderLine('Authorization');
            log_message('debug', 'Authorization Header: ' . $authHeader);
            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                log_message('error', 'No token or invalid format');
                return [
                    'status' => false,
                    'message' => 'No token provided'
                ];
            }

            $token = str_replace('Bearer ', '', $authHeader);
            log_message('debug', 'Extracted Token: ' . $token);
            $decoded = JWT::decode($token, new Key($this->key, $this->algo));
            log_message('debug', 'Decoded Payload: ' . json_encode((array) $decoded));

            return [
                'status' => true,
                'user_info' => [
                    'id' => $decoded->sub,
                    'role_id' => $decoded->role_id ?? 0
                ]
            ];
        } catch (Exception $e) {
            log_message('error', 'JWT Error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Invalid token: ' . $e->getMessage()
            ];
        }
    }

    public function generateToken($user)
    {
        $currentTime = time(); 
        log_message('debug', 'Current Time (seconds since epoch): ' . $currentTime);

        $payload = [
            'iss' => 'ttrcash-test',
            'sub' => $user['id'],
            'role_id' => $user['role_id'],
            'iat' => $currentTime,              
            'exp' => $currentTime + 3600,
        ];
        $token = JWT::encode($payload, $this->key, $this->algo);
        log_message('debug', 'Generated Token: ' . $token);
        return $token;
    }
}