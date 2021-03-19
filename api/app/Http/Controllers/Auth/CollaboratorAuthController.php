<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Collaborator\CollaboratorLoginRequest;
use JWTAuth;
use Config;

class CollaboratorAuthController extends BaseController
{
    public function __construct()
    {
    }

    public function login(CollaboratorLoginRequest $request)
    {
        $creds = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = auth('collaborator')->attempt($creds)) {
                return response()->json([
                    'message' => 'invalid_email_or_password',
                ], 406);
            }
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                
            ], 502);
        }
        $user = auth('collaborator')->user();
        return response()->json([
            'type' => 'Bearer',
            'role' => 'Collaborator',
            'TTL' => Config::get('jwt.ttl'),
            'token' => $token,
            'user' => $user
        ], 200);
    }


    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        try {
            JWTAuth::invalidate($token);

            return response()->json([
                'message' => 'Logout successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 502);
        }
    }

    public function getAuthUser(Request $request)
    {
        return response()->json(auth('collaborator')->user(), 200);
    }
}
