<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Config;
use App\Repositories\Tenant\TenantRepositoryInterface;
use App\Http\Requests\Tenant\TenantLoginRequest;
use App\Http\Requests\Tenant\TenantRegisterRequest;
use App\Http\Requests\Tenant\TenantUpdateRequest;

class TenantAuthController extends BaseController
{
    private $tenantRepository;

    public function __construct(TenantRepositoryInterface $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    public function login(TenantLoginRequest $request)
    {
        $creds = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = auth('tenant')->attempt($creds)) {
                return response()->json([
                    'message' => 'invalid_email_or_password',
                ], 406);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 502);
        }

        $user = auth('tenant')->user();
        return response()->json([
            'type' => 'Bearer',
            'role' => 'Tenant',
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

    public function register(TenantRegisterRequest $request)
    {
        $data = $request->only('name', 'email', 'date_of_birth', 'password');
        $data['password'] = bcrypt($data['password']);

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

    public function getAuthUser(Request $request)
    {
        return response()->json(auth('tenant')->user());
    }

    public function updateTenant(TenantUpdateRequest $request)
    {
        $data = $request->only('name', 'date_of_birth', 'phone_number');

        $tenant = auth('tenant')->user();

        foreach ($data as $key => $value) {
            $tenant->{$key} = $data[$key];
        }

        try {
            $tenant->save();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 500);
        }

        return response()->json([
            'message' => 'Thay đổi thông tin thành công'
        ], 200);
    }
}
