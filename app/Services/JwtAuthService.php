<?php
namespace App\Services;

class JwtAuthService
{
    public function authenticateUser()
    {
        return ['status' => true, 'user_info' => ['role_id' => 1]];
    }
}