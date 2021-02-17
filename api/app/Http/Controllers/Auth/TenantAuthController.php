<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Config;
use App\Repositories\Tenant\TenantRepositoryInterface;

class TenantAuthController extends BaseController
{
    private $tenantRepository;

    public function __construct(TenantRepositoryInterface $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
        Config::set('jwt.user', 'App\Models\Tenant');
        Config::set('auth.defaults.guard', 'tenant');
        Config::set('auth.providers.users.model', App\Models\Tenant::class);
    }

    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($creds)) {
                return response()->json([
                    'message' => 'invalid_email_or_password',
                ], 406);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 502);
        }

        $user = JWTAuth::user();
        return response()->json([
            'type' => 'Bearer',
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

    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'date_of_birth', 'password');

        $newTenant = null;
        try {
            $newTenant = $this->tenantRepository->create($data);
            return response()->json([
                'message' => 'Register successful',
                'tenant' => $newTenant
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ], 502);
        }
    }
}
